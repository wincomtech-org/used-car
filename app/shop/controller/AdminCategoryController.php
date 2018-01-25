<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;
use app\shop\model\ShopGoodsCategoryModel;
use think\Db;

/**
* 服务商城 独立模块
* 类别（类目）
*/
class AdminCategoryController extends AdminBaseController
{
    public function index()
    {
        $goodsCate = new ShopGoodsCategoryModel();
        $categoryTree = $goodsCate->shopGoodsCategoryTableTree();

        $this->assign('category_tree', $categoryTree);
        return $this->fetch();
    }

    // 新增
    public function add()
    {
        $parentId = $this->request->param('parent', 0, 'intval');
        $goodsCate = new ShopGoodsCategoryModel();
        $categoriesTree = $goodsCate->adminCategoryTree($parentId);

        $this->assign('categories_tree', $categoriesTree);
        return $this->fetch();
    }
    public function addPost()
    {
        $goodsCate = new ShopGoodsCategoryModel();
        $data = $this->request->param();

        $result = $this->validate($data, 'GoodsCategory');
        if ($result !== true) {
            $this->error($result);
        }

        $result = $goodsCate->addCategory($data);

        if ($result === false) {
            $this->error('添加失败!');
        }
        $this->success('添加成功!', url('AdminCategory/index'));
    }

    // 编辑
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id > 0) {
            $category = ShopGoodsCategoryModel::get($id)->toArray();

            $goodsCate = new ShopGoodsCategoryModel();
            // $category = $goodsCate->get($id)->toArray();
            $categoriesTree      = $goodsCate->adminCategoryTree($category['parent_id'], $id);

            $this->assign($category);
            $this->assign('categories_tree', $categoriesTree);
            return $this->fetch();
        } else {
            $this->error('操作错误!');
        }
    }
    public function editPost()
    {
        $data = $this->request->param();

        $result = $this->validate($data, 'GoodsCategory');
        if ($result !== true) {
            $this->error($result);
        }

        $goodsCate = new ShopGoodsCategoryModel();
        $result = $goodsCate->editCategory($data);

        if ($result === false) {
            $this->error('保存失败!');
        }
        $this->success('保存成功!');
    }

    public function listOrder()
    {
        parent::listOrders(Db::name('shop_goods_category'));
        $this->success("排序更新成功！", '');
    }

    // 分类选择对话框
    public function select()
    {
        $ids = $this->request->param('ids');
        $selectedIds = explode(',', $ids);
        $goodsCate = new ShopGoodsCategoryModel();

        $tpl = <<<tpl
<tr class='data-item-tr'>
    <td>
        <input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]'
               value='\$id' data-name='\$name' \$checked>
    </td>
    <td>\$id</td>
    <td>\$spacer <a href='\$url' target='_blank'>\$name</a></td>
</tr>
tpl;
        $config = ['url'=>'shop/AdminCategory/edit'];
        $categoryTree = $goodsCate->adminCategoryTableTree($selectedIds, $tpl, $config);
// dump($categoryTree);die;
        $where      = ['delete_time' => 0];
        $categories = $goodsCate->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    public function delete()
    {
        $goodsCate = new ShopGoodsCategoryModel();
        $id = $this->request->param('id');

        //获取删除的内容
        $findCategory = $goodsCate->where('id', $id)->find();
        if (empty($findCategory)) {
            $this->error('分类不存在!');
        }

        $categoryChildrenCount = $goodsCate->where('parent_id', $id)->count();
        if ($categoryChildrenCount > 0) {
            $this->error('此分类有子类无法删除!');
        }

        $categoryPostCount = Db::name('shop_goods_attr')->where('attrId', $id)->count();
        if ($categoryPostCount > 0) {
            $this->error('此分类有属性无法删除!');
        }

        $data   = [
            'table_name'  => 'shop_goods_category',
            'object_id'   => $findCategory['id'],
            'name'        => $findCategory['name'],
            'create_time' => time(),
        ];

        // 软删除操作
        $transStatus = true;
        try{
            $goodsCate->where('id', $id)->update(['delete_time'=>time()]);
            Db::name('recycleBin')->insert($data);
        }catch(\Exception $e){
            Db::rollback();
            $transStatus = false;
        }

        if ($transStatus===true) {
            $this->success('删除成功!');
        } else {
            $this->error('删除失败');
        }
    }

    
}