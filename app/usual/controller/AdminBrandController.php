<?php
namespace app\usual\controller;

use app\admin\model\RouteModel;
use cmf\controller\AdminBaseController;
use app\usual\model\UsualBrandModel;
use think\Db;
// use app\admin\model\ThemeModel;


class AdminBrandController extends AdminBaseController
{
    function _initialize()
    {
        parent::_initialize();
        // $data = $this->request->param();
        $this->UsualModel = new UsualBrandModel();
    }

    /**
     * 品牌分类列表
     * @adminMenu(
     *     'name'   => '分类管理',
     *     'parent' => 'usual/AdminBrand/default',
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
        // dump(CMF_ROOT);die;
        // $config = [
        //     'm'=>'AdminBrand',
        //     'url'=>'portal/List/index',
        //     'add'=>false,
        //     'add_title'=>'',
        //     'edit'=>true,
        //     'delete'=>true,
        //     'table2'=>''
        // ];
        // $categoryTree    = $this->UsualModel->adminCategoryTableTree(0,'',$config);
        $param = $this->request->param();//接收筛选条件
        $categories = $this->UsualModel->getLists($param);
        // $categories = model('UsualBrand')->getLists($param);

        $categories->appends($param);//添加URL参数
        $this->assign('categories', $categories->items());// 获取查询数据并赋到模板
        $this->assign('page', $categories->render());// 获取分页代码并赋到模板
        // $this->assign('category_tree', $categoryTree);
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
        $parentId           = $this->request->param('parent', 0, 'intval');
        $categoriesTree     = $this->UsualModel->adminCategoryTree($parentId);

        $this->assign('categories_tree', $categoriesTree);
        $this->assign('parentId', $parentId);
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

        $result = $this->validate($data, 'UsualBrand.add');
        if ($result !== true) {
            $this->error($result);
        }

        $result = $this->UsualModel->addCategory($data);
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
            $category = UsualBrandModel::get($id)->toArray();

            $categoriesTree      = $this->UsualModel->adminCategoryTree($category['parent_id'], $id);

            // 路由定义 别名alias
            // $routeModel = new RouteModel();
            // $alias      = $routeModel->getUrl('portal/List/index', ['id' => $id]);
            // $category['alias'] = $alias;

            $this->assign($category);
            $this->assign('categories_tree', $categoriesTree);
            $this->assign('parentId', $category['parent_id']);
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

        $result = $this->validate($data, 'UsualBrand.edit');
        if ($result !== true) {
            $this->error($result);
        }

        $result = $this->UsualModel->editCategory($data);
        if ($result === false) {
            $this->error('保存失败!');
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
        $config = [
            'm'=>'AdminBrand',
            'url'=>'',
            'add'=>true,
            'add_title'=>'',
            'edit'=>true,
            'delete'=>true,
            'table2'=>''
        ];
        $categoryTree = $this->UsualModel->adminCategoryTableTree($selectedIds, $tpl, $config);

        $where      = ['delete_time' => 0];
        $categories = $this->UsualModel->where($where)->select();

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
        parent::listOrders(Db::name('usual_brand'));
        $this->success("排序更新成功！", '');
    }

    /**
     * 删除品牌分类
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
        //获取删除的内容
        $findCategory = $this->UsualModel->where('id', $id)->find();
        if (empty($findCategory)) {
            $this->error('品牌不存在!');
        }

        // $categoryChildrenCount = $this->UsualModel->where('parent_id', $id)->count();
        // if ($categoryChildrenCount > 0) {
        //     $this->error('此品牌有子类无法删除!');
        // }

        // $categoryPostCount = Db::name('usual_car')->where('brand_id',$id)->whereOr('serie_id',$id)->count();
        $categoryPostCount = Db::name('usual_car')->where('brand_id',$id)->count();
        if ($categoryPostCount > 0) {
            $this->error('此品牌有车子无法删除!');
        }

        // $data   = [
        //     'object_id'   => $findCategory['id'],
        //     'create_time' => time(),
        //     'table_name'  => 'usual_brand',
        //     'name'        => $findCategory['name']
        // ];
        $result = $this->UsualModel
            ->where('id', $id)
            ->delete();
            // ->update(['delete_time' => time()]);
        if ($result) {
            // Db::name('recycleBin')->insert($data);
            $this->success('删除成功!');
        } else {
            $this->error('删除失败');
        }
    }
}