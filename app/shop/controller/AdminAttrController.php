<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;
use app\shop\model\ShopGoodsCategoryModel;
use app\shop\model\ShopGoodsAttrModel;
use app\shop\model\ShopGoodsAvModel;
use app\shop\service\AttrService;
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
        $param = $this->request->param();
        $categoryId = $this->request->param('category', 0, 'intval');

        $postService = new AttrService();
        $list = $postService->adminAttrList($param);
        $list->appends($param);

        $cateModel = new ShopGoodsCategoryModel();
        $categoryTree = $cateModel->adminCategoryTree($categoryId);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('list', $list->items());
        $this->assign('category_tree', $categoryTree);
        $this->assign('category', $categoryId);
        $this->assign('pager', $list->render());

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