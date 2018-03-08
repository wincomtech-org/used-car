<?php
namespace app\shop\controller;

use cmf\controller\HomeBaseController;

/**
* 商品订单类
*/
class OrderController extends HomeBaseController
{
    // 购物车元素
    public function cart()
    {
        $data = $this->request->param();

        dump($data);
    }
}