<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;
use app\shop\model\ShopGoodsAttrModel;
use app\shop\model\ShopGoodsAvModel;
use think\Db;

/**
* 服务商城 独立模块
* 属性
* 属性值
* 产品属性关系
*/
class AdminAttrController extends AdminBaseController
{
    public function index()
    {
        return $this->fetch();
    }
    public function add()
    {
        return $this->fetch();
    }
    public function addPost()
    {
        $data = $this->request->param();

        // Db::name('shop_goods_attr')->insertGetId($data);
        $this->success('保存成功');
    }
    public function edit()
    {
        return $this->fetch();
    }
    public function editPost()
    {
        $data = $this->request->param();

        // Db::name('shop_goods_attr')->insertGetId($data);
        $this->success('保存成功');
    }



    // 属性值
    public function listav()
    {
        $filter = $this->request->param();
        
        return $this->fetch();
    }
    public function addav()
    {
        return $this->fetch();
    }
    public function addavPost()
    {
        $data = $this->request->param();

        // Db::name('shop_goods_attr')->insertGetId($data);
        $this->success('保存成功');
    }
    public function editav()
    {
        return $this->fetch();
    }
    public function editavPost()
    {
        $data = $this->request->param();

        // Db::name('shop_goods_attr')->insertGetId($data);
        $this->success('保存成功');
    }
    
}