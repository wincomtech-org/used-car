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
        // 实例化
        $scModel   = new ShopGoodsModel;
        $cateModel = new ShopGoodsCategoryModel();

        // 获取请求 typeCast()$type=a/d/f/b/s/gettype()
        $data        = $this->request->param();
        $param_attr  = $this->request->param('oxnum'); //来自属性表
        $param_cate  = $this->request->param('cate/d'); //分类
        $param_brand = $this->request->param('brand'); //商品品牌
        // $param_price = $this->request->param('priceMin.priceMax/d');//价格区间
        $param_price1 = $this->request->param('priceMin/d'); //价格区间
        $param_price2 = $this->request->param('priceMax/d'); //价格区间
        // $jumpext = $this->request->param('jumpext','','strval');

// var_dump($param_cate);
// dump($param_price);
// dump($data);
// die;
        /*初始化*/
        // 预设
        $jumpext = '';
        $string  = '';

        // 获取相关数据
        // $categories = $cateModel->getGoodsTreeArray($param_cate);
        $categories = $cateModel->getChildrens($param_cate);
        $brands     = Db::name('shop_brand')->field('id,name')->where('status',1)->select()->toArray();
        $moreTree   = $cateModel->getAttrByCate($param_cate);

// dump($categories);
// dump($brands);
// dump($moreTree);
// die;
        // 数据总缓存
        // $obcache = cache('obcache3');
        // if (empty($obcache)) {
        //     $obcache = [
        //         'categories' => $categories,
        //         'brands'     => $brands,
        //         'moreTree'   => $moreTree,
        //     ];
        //     cache('obcache3', $obcache);
        // }

        /*URL 参数*/
        $jumpext = 'oxnum=' . $string
            . (empty($price) ? '' : '&price=' . $price);

        /*商品数据集*/
        $goodslist = '';

        /*模板赋值*/
        $this->assign('jumpext', $jumpext);

        $this->assign('priceMin', $param_price1);
        $this->assign('priceMax', $param_price2);
        $this->assign('cate', $param_cate);
        $this->assign('categories', $categories);
        $this->assign('brand', $param_brand);
        $this->assign('brands', $brands);
        $this->assign('moreTree', $moreTree);

        // 数据分页
        $this->assign('goodslist', $goodslist);
        // $goodslist->appends($jumpext);//字符串
        // $goodslist->appends('jumpext',$jumpext);//数组
        // $this->assign('pager',$goodslist->render());

        return $this->fetch();
    }
}
