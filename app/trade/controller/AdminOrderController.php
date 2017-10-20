<?php
namespace app\trade\controller;

use cmf\controller\AdminBaseController;
// use app\trade\model\TradeModel;
// use think\Db;

class AdminOrderController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        return '二手车买卖订单模块';
        return $this->fetch();
    }
}