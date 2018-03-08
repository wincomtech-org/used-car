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
        $id = $this->request->param('id',0,'intval');

        $goods = Db::name('shop_goods')->where('id',$id)->find();
dump($goods);die;
        $this->assign('goods',$goods);
        return $this->fetch();
    }
}