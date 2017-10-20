<?php
namespace app\insurance\controller;

use cmf\controller\AdminBaseController;
// use app\insurance\model\InsuranceModel;
// use think\Db;

class AdminCompensationController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        return "车险服务 - 理赔模块";
        return $this->fetch();
    }
}