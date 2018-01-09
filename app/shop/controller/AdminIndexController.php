<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;

/**
* 服务商城 独立模块
* 配置
*/
class AdminIndexController extends AdminBaseController
{
    public function index()
    {
        return $this->fetch(':config');
    }

    
}