<?php
namespace app\service\controller;

use cmf\controller\AdminBaseController;
// use app\service\model\ServiceModel;
// use think\Db;

class AdminServiceController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        return "车辆业务 - 业务单子模块";
        return $this->fetch();
    }
}