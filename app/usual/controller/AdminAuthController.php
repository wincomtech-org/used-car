<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;
// use app\usual\model\UsualModel;
// use think\Db;

/**
* 认证模块
*/
class AdminAuthController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        return '认证模块';
        return $this->fetch();
    }
}