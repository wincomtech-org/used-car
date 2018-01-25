<?php
namespace app\shop\controller;

use cmf\controller\HomeBaseController;
use think\Db;

/**
* 服务商城 独立模块
* 列表之后的
*/
class PostController extends HomeBaseController
{
    public function details()
    {
        return $this->fetch();
    }
}