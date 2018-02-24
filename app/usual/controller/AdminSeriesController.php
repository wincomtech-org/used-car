<?php
namespace app\usual\controller;

// use app\admin\model\RouteModel;
use cmf\controller\AdminBaseController;
use app\usual\model\UsualSeriesModel;
use think\Db;
// use app\admin\model\ThemeModel;


class AdminSeriesController extends AdminBaseController
{
    public function _initialize()
    {
        parent::_initialize();
        // $data = $this->request->param();
        $this->cateModel = new UsualSeriesModel();
    }

    /**
     * 车型分类列表
     * @adminMenu(
     *     'name'   => '分类管理',
     *     'parent' => 'usual/AdminSeries/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '车型分类列表',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $brandId = $this->request->param('brandId',0,'intval');
        $parent = $this->request->param('parent',0,'intval');

        $list = $this->cateModel->getLists($param,'',30);
        $brands = model('UsualBrand')->getBrands($brandId);
        $cates = $this->cateModel->getFirstCate($parent);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('brands', $brands);
        $this->assign('categorys', $cates);
        $this->assign('list', $list);
        // $this->assign('list', $list->items());
        // $list->appends($param);
        // $this->assign('pager', $list->render());
        return $this->fetch();
    }

    /**
     * 添加车型分类
     * @adminMenu(
     *     'name'   => '添加车型分类',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加车型分类',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        $parentId       = $this->request->param('parent', 0, 'intval');
        $categoriesTree = $this->cateModel->adminCategoryTree($parentId);
        $brand_id       = $this->cateModel->where('id',$parentId)->value('brand_id');
        $brandId        = !empty($brand_id) ? $brand_id : $this->request->param('brand', 0, 'intval');
        $BrandTree      = model('UsualBrand')->adminCategoryTree($brandId);

        $this->assign('categories_tree', $categoriesTree);
        $this->assign('BrandTree', $BrandTree);
        return $this->fetch();
    }

    /**
     * 添加车型分类提交
     * @adminMenu(
     *     'name'   => '添加车型分类提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加车型分类提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        $data = $this->request->param();

        $result = $this->validate($data, 'UsualSeries.add');
        if ($result !== true) {
            $this->error($result);
        }
        $data['create_time'] = $data['update_time'] = time();
        $result = $this->cateModel->addCategory($data);
        if ($result === false) {
            $this->error('添加失败!');
        }

        $this->success('添加成功!', url('AdminSeries/index'));

    }

    /**
     * 编辑车型分类
     * @adminMenu(
     *     'name'   => '编辑车型分类',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑车型分类',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id > 0) {
            $category = UsualSeriesModel::get($id)->toArray();

            $categoriesTree = $this->cateModel->adminCategoryTree($category['parent_id'], $id);
            $BrandTree = model('UsualBrand')->adminCategoryTree($category['brand_id']);

            $this->assign($category);
            $this->assign('categories_tree', $categoriesTree);
            $this->assign('BrandTree', $BrandTree);
            return $this->fetch();
        } else {
            $this->error('操作错误!');
        }

    }

    /**
     * 编辑车型分类提交
     * @adminMenu(
     *     'name'   => '编辑车型分类提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑车型分类提交',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {
        $data = $this->request->param();

        $result = $this->validate($data, 'UsualSeries.edit');
        if ($result !== true) {
            $this->error($result);
        }
        $data['update_time'] = time();
        $result = $this->cateModel->editCategory($data);
        if ($result === false) {
            $this->error('保存失败!');
        }

        $this->success('保存成功!');
    }

    /**
     * 车型分类选择对话框
     * @adminMenu(
     *     'name'   => '车型分类选择对话框',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '车型分类选择对话框',
     *     'param'  => ''
     * )
    */
    public function select()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);

        $tpl = <<<tpl
<tr class='data-item-tr'>
    <td>
        <input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]' value='\$id' data-name='\$name' \$checked>
    </td>
    <td>\$id</td>
    <td>\$spacer <a href='\$url' target='_blank'>\$name</a></td>
</tr>
tpl;

        $categoryTree = $this->cateModel->adminCategoryTableTree($selectedIds, $tpl);
        // 带链接的
        // $config = ['url'=>'usual/AdminSeries/edit'];
        // $categoryTree = $this->cateModel->adminCategoryTableTree($selectedIds, $tpl, $config);

        $where      = ['delete_time' => 0];
        $categories = $this->cateModel->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    /**
     * 车型分类排序
     * @adminMenu(
     *     'name'   => '车型分类排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '车型分类排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('UsualSeries'));
        $this->success("排序更新成功！", '');
    }

    /**
     * 删除车型分类 回收机制
     * @adminMenu(
     *     'name'   => '删除车型分类',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除车型分类',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $id = $this->request->param('id');
        //获取删除的内容
        $findCategory = $this->cateModel->where('id', $id)->find();
        if (empty($findCategory)) {
            $this->error('分类不存在!');
        }

        $categoryChildrenCount = $this->cateModel->where('parent_id', $id)->count();
        if ($categoryChildrenCount > 0) {
            $this->error('此车系有子类无法删除，请改名!');
        }

        $categoryPostCount = Db::name('usual_car')->where('serie_id',$id)->count();
        if ($categoryPostCount > 0) {
            $this->error('此车系有车子无法删除，请改名!');
        }

        // $data   = [
        //     'object_id'   => $findCategory['id'],
        //     'create_time' => time(),
        //     'table_name'  => 'usual_brand',
        //     'name'        => $findCategory['name']
        // ];
        $result = $this->cateModel
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