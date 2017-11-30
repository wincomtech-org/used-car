<?php
namespace app\funds\controller;

use cmf\controller\UserBaseController;
// use app\funds\model\FundsModel;
// use think\Db;

/**
* 支付中心
*
*/
class PayController extends UserBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        $type = $this->request->param('type');
        $action = $this->request->param('action');
        return "支付中心 - 支付类型：".$type.'，应用模块：'.$action.'。（接口预留）';
        return $this->fetch();
    }
}