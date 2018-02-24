<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;

/**
* 服务商城 独立模块
* 快递 物流
*/
class AdminExpressController extends AdminBaseController
{
    public function index()
    {
        return $this->fetch();
    }

    
}