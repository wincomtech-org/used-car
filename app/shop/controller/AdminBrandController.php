<?php
namespace app\shop\controller;

use cmf\controller\AdminBaseController;
use app\shop\model\ShopBrandModel;
use think\Db;


class AdminBrandController extends AdminBaseController
{
    /**
     * 品牌分类列表
     * @adminMenu(
     *     'name'   => '分类管理',
     *     'parent' => 'shop/AdminBrand/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '品牌分类列表',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $scModel = new ShopBrandModel();

        $param = $this->request->param();//接收筛选条件
        $categories = $scModel->getLists($param);

        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('categories', $categories->items());// 获取查询数据并赋到模板
        $categories->appends($param);//添加URL参数
        $this->assign('pager', $categories->render());// 获取分页代码并赋到模板

        return $this->fetch();
    }

    /**
     * 添加品牌分类
     * @adminMenu(
     *     'name'   => '添加品牌分类',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加品牌分类',
     *     'param'  => ''
     * )
     */
    public function add()
    {

        return $this->fetch();
    }

    /**
     * 添加品牌分类提交
     * @adminMenu(
     *     'name'   => '添加品牌分类提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加品牌分类提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        $data = $this->request->param();
        // dump($data);die;
        $result = $this->validate($data, 'Brand.add');
        if ($result !== true) {
            $this->error($result);
        }

        $scModel = new ShopBrandModel();
        $result = $scModel->addBrand($data);
        if ($result === false) {
            $this->error('添加失败!');
        }

        $this->success('添加成功!', url('AdminBrand/index'));
    }

    /**
     * 编辑品牌分类
     * @adminMenu(
     *     'name'   => '编辑品牌分类',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑品牌分类',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id > 0) {
            $category = ShopBrandModel::get($id)->toArray();

            $scModel = new ShopBrandModel();
            $categoriesTree = model('ShopGoodsCategory')->adminCategoryTree($category['category_id']);

            $this->assign($category);
            $this->assign('categories_tree', $categoriesTree);
            // $this->assign('cateId', $category['category_id']);
            return $this->fetch();
        } else {
            $this->error('操作错误!');
        }
    }

    /**
     * 编辑品牌分类提交
     * @adminMenu(
     *     'name'   => '编辑品牌分类提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑品牌分类提交',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {
        $data = $this->request->param();

        $result = $this->validate($data, 'Brand.edit');
        if ($result !== true) {
            $this->error($result);
        }

        $scModel = new ShopBrandModel();
        $result = $scModel->editBrand($data);
        if (empty($result)) {
            $this->error('保存失败或无变化');
        }

        $this->success('保存成功!');
    }

    /**
     * 品牌分类选择对话框
     * @adminMenu(
     *     'name'   => '品牌分类选择对话框',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '品牌分类选择对话框',
     *     'param'  => ''
     * )
     */
    public function select()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);

        // $tpl = "<td>\$spacer <a href='\$url' target='_blank'>\$name</a></td>";
        $tpl = <<<tpl
<tr class='data-item-tr'>
    <td>
        <input type='radio' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]' value='\$id' data-name='\$name' \$checked>
    </td>
    <td>\$id</td>
    <td>\$spacer <a style='text-decoration:none;cursor:pointer;'>\$name</a></td>
</tr>
tpl;
        $scModel = new ShopBrandModel();
        $config = ['url'=>'shop/AdminBrand/edit'];
        $categoryTree = $scModel->adminCategoryTableTree($selectedIds, $tpl, $config);

        $where      = ['delete_time' => 0];
        $categories = $scModel->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    /**
     * 品牌分类排序
     * @adminMenu(
     *     'name'   => '品牌分类排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '品牌分类排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('shop_brand'));
        $this->success("排序更新成功！", '');
    }

    /**
     * 删除品牌分类 回收机制
     * @adminMenu(
     *     'name'   => '删除品牌分类',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除品牌分类',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $id = $this->request->param('id');
        $scModel = new ShopBrandModel();
        
        //获取删除的内容
        $find = $scModel->where('id', $id)->find();
        if (empty($find)) {
            $this->error('品牌不存在!');
        }

        if ($find['category_id'] > 0) {
            $this->error('此品牌有关联的商品分类，无法删除!');
        }

        $result = $scModel->where('id', $id)->delete();
        if ($result) {
            $this->success('删除成功!');
        } else {
            $this->error('删除失败');
        }
    }
}