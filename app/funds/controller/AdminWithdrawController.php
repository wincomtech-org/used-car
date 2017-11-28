<?php
namespace app\funds\controller;

use cmf\controller\AdminBaseController;
// use app\funds\model\FundsModel;
// use think\Db;

/**
* 后台 
* 财务管理 资金动向
*/
class AdminWithdrawController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        return "财务管理 - 提现管理";
        return $this->fetch();
    }
}