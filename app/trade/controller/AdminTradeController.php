<?php
namespace app\trade\controller;

use cmf\controller\AdminBaseController;
// use app\trade\model\TradeModel;
// use think\Db;

class AdminTradeController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        echo '二手车买卖模块';
        return $this->fetch();
    }
}