<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;
use app\shop\model\ShopGoodsModel;


/**
* 服务商城 独立模块
* 产品
*/
class AdminGoodsController extends AdminBaseController
{
    public function index()
    {
        return $this->fetch();
    }

    
}