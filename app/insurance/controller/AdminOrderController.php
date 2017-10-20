<?php
namespace app\insurance\controller;

use cmf\controller\AdminBaseController;
use app\insurance\model\InsuranceModel;
use think\Db;

/**
* 保险业务表
*/
class AdminOrderController extends AdminBaseController
{
    // function __initialize()
    // {
    //     parent::__initialize();
    // }

    public function index()
    {
        return '车险 - 保单模块';
        return $this->display('显示');
        return $this->fetch();
    }
}