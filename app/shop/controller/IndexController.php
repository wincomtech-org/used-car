<?php
namespace app\shop\controller;

use cmf\controller\HomeBaseController;

/**
* 服务商城 独立模块
*/
class IndexController extends HomeBaseController
{
    public function index()
    {
        return $this->fetch();
    }
}