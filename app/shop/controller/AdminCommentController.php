<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;
use app\shop\model\ShopGoodsCommentModel;

/**
* 服务商城 独立模块
* 评论
*/
class AdminCommentController extends AdminBaseController
{
    public function index()
    {
        return $this->fetch();
    }

    
}