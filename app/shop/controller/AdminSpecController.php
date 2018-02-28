<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;
use app\shop\model\ShopSpecModel;
use think\Db;

/**
* 商品规格
* SKU
*/
class AdminSpecController extends AdminBaseController
{
    private $scModel;
    private $sqlObj;
    public function _initialize()
    {
        parent::_initialize();

        $this->scModel = new ShopSpecModel();
        $this->sqlObj = Db::name('shop_spec');
    }
    public function index()
    {
        $filter = $this->request->param();
        $list = $this->scModel->getLists($filter);
        // dump($list);

        $this->assign('list',$list->items());
        $list->appends($filter);
        $this->assign('pager',$list->render());
        return $this->fetch();
    }

    public function add()
    {
        $categoryTree = model('ShopGoodsCategory')->adminCategoryTree();
        $this->assign('category_tree',$categoryTree);
        return $this->fetch();
    }
    public function addPost()
    {
        $data = $this->request->param();

        $result = $this->sqlObj->insertGetId($data);

        if ($result) {
            $this->success('添加成功',url('index'));
        }
        $this->error('添加失败');
    }

    public function edit()
    {
        $id = $this->request->param('id/d',0,'intval');
        
        $post = $this->scModel->get($id)->toArray();
        $categoryTree = model('ShopGoodsCategory')->adminCategoryTree($post['category_id']);

        $this->assign('category_tree',$categoryTree);
        $this->assign($post);
        return $this->fetch();
    }
    public function editPost()
    {
        $data = $this->request->param();

        $result = $this->sqlObj->update($data);

        if ($result) {
            $this->success('更新成功');
        }
        $this->error('更新失败或数据无变化');
    }

    public function delete()
    {
        $ids = $this->request->param();
        dump($ids);
    }

    public function listOrder()
    {
        parent::listOrders(Db::name('shop_spec'));
        $this->success("排序更新成功！", '');
    }

}