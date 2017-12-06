<?php
namespace app\funds\controller;

use cmf\controller\AdminBaseController;
// use app\funds\model\FundsModel;
// use think\Db;

/**
* 后台 
* 财务管理 资金动向
*/
class AdminRechargeController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        return "财务管理 - 充值管理";
        return $this->fetch();
    }
}