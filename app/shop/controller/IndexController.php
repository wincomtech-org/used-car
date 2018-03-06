<?php
namespace app\shop\controller;

use cmf\controller\HomeBaseController;
use app\shop\model\ShopGoodsModel;

/**
* 服务商城 独立模块
*/
class IndexController extends HomeBaseController
{
    public function index()
    {
        $scModel = new ShopGoodsModel;

        // 本周热卖
        $hot_sales = $scModel->getGoodsHot();

        // 商品大循环
        $goodslist = $scModel->getGoodsByCate();
//         foreach ($goodslist as $key => $v1) {
//             print_r($v1['cate']['id']);die;
//         }
// dump($goodslist);die;
        // 底部文章
        $articles = '';

        $this->assign('hot_sales',$hot_sales);
        $this->assign('goodslist',$goodslist);
        $this->assign('articles',$articles);
        return $this->fetch();
    }
}