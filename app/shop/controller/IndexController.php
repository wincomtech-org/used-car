<?php
namespace app\shop\controller;

use think\Db;
use cmf\controller\HomeBaseController;
use app\shop\model\ShopGoodsCategoryModel;
use app\shop\model\ShopGoodsModel;
// use app\portal\service\ApiService;
use app\portal\service\PostService;

/**
 * 服务商城 独立模块
 */
class IndexController extends HomeBaseController
{
    /*首页*/
    public function index()
    {

        // 数据总缓存
        $obcache = cache('obshopIndex');
        if (empty($obcache)) {
            $scModel = new ShopGoodsModel;
            // 本周热卖
            $hot_sales = $scModel->getGoodsHot();
            // 商品大循环
            $goodslist = $scModel->getGoodsByCate();
            // 底部文章
            // $apiModel = new ApiService;
            $pModel = new PostService;
            $articles = $pModel->vis_a_vis(12,5,'a.recommended desc','a.id,a.post_title');

            $obcache = [
                'hot_sales' => $hot_sales,
                'goodslist' => $goodslist,
                'articles'  => $articles,
            ];
            cache('obshopIndex', $obcache);
        }

        $this->assign('hot_sales', $obcache['hot_sales']);
        $this->assign('goodslist', $obcache['goodslist']);
        $this->assign('articles', $obcache['articles']);
        return $this->fetch();
    }

    // 用于手机端
    function cate_map(){
        return $this->fetch();
    }

    /*
     * 列表页
     * 分类必选，默认
     */
    // public function list()//被占用
    public function lists()
    {
        // $this->error('临时关闭');
        // $it = "INSERT INTO `cmf_shop_goods` (`cate_id`,`brand_id`,`avids`,`price`) VALUES ";
        // error_log(date('Y-m-d H:i:s') .'---'. $it . "\r\n", 3, 'data/log.txt');

        // for ($i=0; $i < 70000; $i++) { 
        //     $it .= '('.rand(0,23).','.rand(0,8).','.rand(1,999).','.rand(0,1000).'),';
        // }
        // $it = substr($it,0,-1);
        // // echo $it;die;
        // error_log(date('Y-m-d H:i:s') .'---'. $i . "\r\n", 3, 'data/log.txt');

        // $result = Db::query($it);
        // error_log(date('Y-m-d H:i:s') . "\r\n\r\n", 3, 'data/log.txt');
        // die;
        


        // 获取请求 typeCast()$type=a|d|f|b|s|gettype()
        $data        = $this->request->param();
        $param_attr  = $this->request->param('oxnum'); //来自属性值表
        $param_cate  = $this->request->param('cate/d'); //分类
        $param_brand = $this->request->param('brand'); //商品品牌
        // $param_price = $this->request->param('priceMin.priceMax/d');//价格区间
        $param_price1 = $this->request->param('priceMin/d'); //最小价格
        $param_price2 = $this->request->param('priceMax/d'); //最大价格
        // $jumpext = $this->request->param('jumpext','','strval');

        /*初始化*/
        // 预设
        $jumpext = '';
        $string  = ''; $oxnum='';
        $field = 'a.id,a.name,a.price,a.thumbnail';
        $order = '';
        $limit = '';
        $filter = $extra = [];

        // 实例化
        $scModel   = new ShopGoodsModel;
        $cateModel = new ShopGoodsCategoryModel();

        // 数据总缓存
        $obcache = cache('obshopIndexLists');
        if (empty($obcache)) {
            // 获取相关数据
            // $categories = $cateModel->getGoodsTreeArray($param_cate);
            $categories = $cateModel->getCateChildrens($param_cate);
            $brands     = Db::name('shop_brand')->field('id,name')->where('status',1)->select()->toArray();
            $attrTree   = $cateModel->getAttrByCate($param_cate);
            $obcache = [
                'categories' => $categories,
                'brands'     => $brands,
                'attrTree'   => $attrTree,
            ];
            cache('obshopIndexLists', $obcache);
        }

        /*
         * URL 参数
         * oxnum 被保留的属性id
         */
        $jumpext = (empty($param_cate)?'':'&cate='.$param_cate)
            . (empty($param_brand)?'':'&brand='.$param_brand)
            . (empty($param_price1)?'':'&priceMin='.$param_price1)
            . (empty($param_price2)?'':'&priceMax='.$param_price2)
            . (empty($param_attr)?'':'&oxnum='.$param_attr);

        /*处理条件*/
        $filter['cateId'] = $param_cate;
        $filter['brandId'] = $param_brand;
        if (!empty($param_price1) && !empty($param_price2)) {
            $extra['a.price'] = [['egt', $param_price1], ['elt', $param_price2]];
        } else {
            if (!empty($param_price1)) {
                $extra['a.price'] = ['egt', $param_price1];
            }
            if (!empty($param_price2)) {
                $extra['a.price'] = ['elt', $param_price2];
            }
        }

        /*
         * 属性值处理
         * 相关表
            cmf_shop_gav 关联表，依据属性值的ID查找对应商品数据
            cmf_shop_goods_attr  属性表
            cmf_shop_goods_av  属性值表
            cmf_shop_goods  商品表
         */
        $filter['avIds'] = $param_attr;
        $oxnum = trim($param_attr);
        $av_ids = explode('_',$oxnum);//获取当前参与筛选的属性值ID集合
        $attrTree = $obcache['attrTree'];//当前分类所有属性及值的集合
        
        $show_tpl = ''; // 生成筛选html,URL中留下需要保留的 ids
        $hide_ids = '';//页面中需要隐藏的属性ID： attr_id
        // $goods_ids = '';// 需要从数据库中找出的商品ID： goods_id

        if (!empty($attrTree)) {
            // $attr_ids = array_keys($attrTree);// 获取当前分类所有属性id
            foreach ($attrTree as $key1 => $vo1) {
                // $attr_ids[] = $key1;// 获取当前分类所有属性id
                foreach ($vo1['value'] as $key2 => $vo2) {
                    if (in_array($vo2['id'],$av_ids)) {
                        $hide_ids[] = $key1;//参与筛选的分类属性ID
                        // 注意：这里 $key1=$vo1['id']
                        // 
                        $dd = implode('_',array_merge(array_diff($av_ids, [$vo2['id']])));
                        $show_tpl .= '<li class="li_filter"><a href="'.url('shop/Index/lists',$jumpext.'&oxnum='.$dd).'">'.$vo1['name'].'：<em>'.$vo2['name'].'</em><i>x</i></a></li>';
                    } else {
                        
                    }
                }
            }
        }


        /*商品数据集*/
        $goodslist = $scModel->getLists($filter,$order,$limit,$extra,$field);


        /*模板赋值*/
        $this->assign('jumpext', $jumpext);
        $this->assign('oxnum', (empty($oxnum)?'':$oxnum.'_'));
        $this->assign('show_tpl',$show_tpl);
        $this->assign('hide_ids',$hide_ids);

        $this->assign('cate', $param_cate);
        $this->assign('brand', $param_brand);
        $this->assign('priceMin', $param_price1);
        $this->assign('priceMax', $param_price2);
        $this->assign('categories', $obcache['categories']);
        $this->assign('brands', $obcache['brands']);
        $this->assign('attrTree', $attrTree);

        // 数据分页
        // $this->assign('goodslist', $goodslist);
        $this->assign('goodslist', $goodslist->items());
        $goodslist->appends($jumpext);//字符串
        // $goodslist->appends('jumpext',$jumpext);//数组
        $this->assign('pager',$goodslist->render());

        return $this->fetch();
    }



}