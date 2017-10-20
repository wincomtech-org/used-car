<?php
namespace app\service\controller;

use cmf\controller\AdminBaseController;
// use app\service\model\ServiceModel;
// use think\Db;

class AdminCategoryController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        return "车辆业务 - 业务分类模块";
        return $this->fetch();
    }
}