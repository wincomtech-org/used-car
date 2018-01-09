<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;

/**
* 服务商城 独立模块
* 订单
*/
class AdminOrderController extends AdminBaseController
{
    public function index()
    {
        return $this->fetch();
    }

    
}