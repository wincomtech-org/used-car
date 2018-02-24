<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;

/**
* 服务商城 独立模块
* 店铺
*/
class AdminShopController extends AdminBaseController
{
    public function index()
    {
        return $this->fetch();
    }

    
}