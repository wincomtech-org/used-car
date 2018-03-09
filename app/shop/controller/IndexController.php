<?php
namespace app\shop\controller;

use app\shop\model\ShopGoodsCategoryModel;
use app\shop\model\ShopGoodsModel;
use cmf\controller\HomeBaseController;
use think\Db;

/**
 * 服务商城 独立模块
 */
class IndexController extends HomeBaseController
{
    /*首页*/
    public function index()
    {
        $scModel = new ShopGoodsModel;

        // 本周热卖
        $hot_sales = $scModel->getGoodsHot();

        // 商品大循环
        $goodslist = $scModel->getGoodsByCate();

        // 底部文章
        $articles = '';

        $this->assign('hot_sales', $hot_sales);
        $this->assign('goodslist', $goodslist);
        $this->assign('articles', $articles);
        return $this->fetch();
    }

    /*
     * 列表页
     * 分类必选，默认
     */
    // public function list()//被占用
    public function lists()
    {
// 测试

        // $cateId =1;
        // $table = Db::getTable('shop_goods_category');
        // $sql = sprintf('SELECT `id`,`name` FROM `%s` WHERE `path` like concat((SELECT `path` FROM `%s` WHERE `id`=%u),\'-%%\') ORDER BY list_order',$table,$table,$cateId);
        // $categories = Db::query($sql);
        $categories = model('ShopGoodsCategory')->getCateChildrens(1,[],'');

// dump(model('ShopGoodsCategory')->getCateChildren(10));
// dump(model('ShopGoodsCategory')->getSpecByCate(7));
// dump(model('ShopGoodsCategory')->getAttrByCate());
        // dump($categories);
        // die;



        // 实例化
        $scModel   = new ShopGoodsModel;
        $cateModel = new ShopGoodsCategoryModel();

        // 获取请求 typeCast()$type=a/d/f/b/s/gettype()
        $data        = $this->request->param();
        $param_attr  = $this->request->param('oxnum'); //来自属性值表
        $param_cate  = $this->request->param('cate/d'); //分类
        $param_brand = $this->request->param('brand'); //商品品牌
        // $param_price = $this->request->param('priceMin.priceMax/d');//价格区间
        $param_price1 = $this->request->param('priceMin/d'); //价格区间
        $param_price2 = $this->request->param('priceMax/d'); //价格区间
        // $jumpext = $this->request->param('jumpext','','strval');

// var_dump($param_attr);
// var_dump($param_cate);
// dump($param_price);
// dump($data);
// die;
        /*初始化*/
        // 预设
        $jumpext = '';
        $string  = ''; $oxnum='';
        $field = 'a.id,a.name,a.price,a.thumbnail';
        $order = '';
        $limit = '';
        $filter = $extra = [];

        // 获取相关数据
        // $categories = $cateModel->getGoodsTreeArray($param_cate);
        $categories = $cateModel->getCateChildrens($param_cate);
        $brands     = Db::name('shop_brand')->field('id,name')->where('status',1)->select()->toArray();
        $attrTree   = $cateModel->getAttrByCate($param_cate);

// dump($categories);
// dump($brands);
// dump($attrTree);
// die;

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
        // 属性 cmf_shop_gav 依据属性值的ID查找对应商品数据
        $oxnum = trim($param_attr);
        // $attr1 = str_split($oxnum,3);
        $attr1 = '';
        if (!empty($attrTree)) {
            $attr_ids = array_keys($attrTree);
            // dump($attr_ids);
        }
        // dump($attrTree);die;



        // 数据总缓存
        // $obcache = cache('obcache3');
        // if (empty($obcache)) {
        //     $obcache = [
        //         'categories' => $categories,
        //         'brands'     => $brands,
        //         'attrTree'   => $attrTree,
        //     ];
        //     cache('obcache3', $obcache);
        // }

        /*URL 参数*/
        $jumpext = (empty($param_cate)?'':'&cate='.$param_cate)
            . (empty($param_brand)?'':'&brand='.$param_brand)
            . (empty($param_price1)?'':'&priceMin='.$param_price1)
            . (empty($param_price2)?'':'&priceMax='.$param_price2);
// dump($jumpext);die;
        /*商品数据集*/
        // $goodslist = $scModel->getLists($filter,$order,$limit,$extra,$field);
        $goodslist = $scModel->getLists([],$order,$limit,$extra,$field);
// dump($goodslist->toArray());die;
        /*模板赋值*/
        $this->assign('jumpext', $jumpext);
        $this->assign('oxnum', $param_attr);

        $this->assign('priceMin', $param_price1);
        $this->assign('priceMax', $param_price2);
        $this->assign('cate', $param_cate);
        $this->assign('categories', $categories);
        $this->assign('brand', $param_brand);
        $this->assign('brands', $brands);
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