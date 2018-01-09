<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;

/**
* 服务商城 独立模块
* 属性
* 属性值
* 属性关系
*/
class AdminAttrController extends AdminBaseController
{
    public function index()
    {
        return $this->fetch();
    }

    
}