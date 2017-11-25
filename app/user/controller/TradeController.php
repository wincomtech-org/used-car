<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
use app\user\model\UserModel;
// use think\Validate;
use think\Db;

/**
* 个人中心 保险
*/
class TradeController extends UserBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    // 买家订单列表页
    public function buyer()
    {
        return $this->fetch();
    }


    /*
    * 卖家数据
    */
    public function seller()
    {
        return $this->fetch();
    }

    public function sellerCar()
    {
        return $this->fetch('seller_car');
    }

    public function sellerOrder()
    {
        return $this->fetch('seller_order');
    }

    public function cancel()
    {
        return $this->fetch();
    }

    public function del()
    {
        return $this->fetch();
    }

    public function more()
    {
        return $this->fetch();
    }
}