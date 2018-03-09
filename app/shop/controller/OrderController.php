<?php
namespace app\shop\controller;

use cmf\controller\HomeBaseController;

/**
* 商品订单类
* 不需要登录的
*/
class OrderController extends HomeBaseController
{
    // 购物车元素 - 查看购物车
    public function cart()
    {
        $data = $this->request->param();
        dump($data);
        $carts = [];

        $this->assign('carts',$carts);
        return $this->fetch();
    }


}