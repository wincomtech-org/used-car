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

    // 列表页
    public function buyer()
    {
        return $this->fetch();
    }

    public function seller()
    {
        return $this->fetch();
    }

    public function sellerCar()
    {
        return $this->fetch();
    }

    public function orderList()
    {
        return $this->fetch();
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