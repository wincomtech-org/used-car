<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;

/**
* 服务商城 独立模块
* 类别（类目）
*/
class AdminCategoryController extends AdminBaseController
{
    public function index()
    {
        return $this->fetch();
    }

    
}