<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;
// use app\usual\model\UsualModel;
// use think\Db;



/**
* 公司企业模块
*/
class AdminCompanyController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        return '公司企业模块';
        return $this->fetch();
    }
}