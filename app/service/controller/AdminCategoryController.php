<?php
namespace app\service\controller;

use cmf\controller\AdminBaseController;
// use app\service\model\ServiceCategoryModel;
use think\Db;
// use app\admin\model\ThemeModel;


class AdminCategoryController extends AdminBaseController
{
    // function _initialize()
    // {
    //     // parent::_initialize();
    // }

    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $categories = model('ServiceCategory')->getLists($param);
die;
        $categories->appends($param);//添加URL参数
        $this->assign('categories', $categories->items());// 获取查询数据并赋到模板
        $this->assign('page', $categories->render());// 获取分页代码并赋到模板

        return $this->fetch();
    }

    public function add()
    {
        $parentId           = $this->request->param('parent', 0, 'intval');
        $categoriesTree     = model('ServiceCategory')->adminCategoryTree($parentId);

        $this->assign('categories_tree', $categoriesTree);
        $this->assign('parentId', $parentId);
        return $this->fetch();
    }

    public function addPost()
    {
        $data = $this->request->param();

        $result = $this->validate($data, 'Category.add');
        if ($result !== true) {
            $this->error($result);
        }

        $result = model('ServiceCategory')->addCategory($data);
        if ($result === false) {
            $this->error('添加失败!');
        }

        $this->success('添加成功!', url('AdminCategory/index'));
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id > 0) {
            $category = ServiceCategoryModel::get($id)->toArray();

            $categoriesTree      = model('ServiceCategory')->adminCategoryTree($category['parent_id'], $id);

            $this->assign($category);
            $this->assign('categories_tree', $categoriesTree);
            $this->assign('parentId', $category['parent_id']);
            return $this->fetch();
        } else {
            $this->error('操作错误!');
        }

    }

    public function editPost()
    {
        $data = $this->request->param();

        $result = $this->validate($data, 'Category.edit');
        if ($result !== true) {
            $this->error($result);
        }

        $result = model('ServiceCategory')->editCategory($data);
        if ($result === false) {
            $this->error('保存失败!');
        }

        $this->success('保存成功!');
    }

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
            'm'=>'AdminCategory',
            'url'=>'',
            'add'=>true,
            'add_title'=>'',
            'edit'=>true,
            'delete'=>true,
            'table2'=>''
        ];
        $categoryTree = model('ServiceCategory')->adminCategoryTableTree($selectedIds, $tpl, $config);

        $where      = ['delete_time' => 0];
        $categories = model('ServiceCategory')->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    public function listOrder()
    {
        parent::listOrders(Db::name('ServiceCategory'));
        $this->success("排序更新成功！", '');
    }

    public function delete()
    {
        $id = $this->request->param('id');
        //获取删除的内容
        $findCategory = model('ServiceCategory')->where('id', $id)->find();
        if (empty($findCategory)) {
            $this->error('模型不存在!');
        }

        // $categoryChildrenCount = model('ServiceCategory')->where('parent_id', $id)->count();
        // if ($categoryChildrenCount > 0) {
        //     $this->error('此品牌有子类无法删除!');
        // }

        // $categoryPostCount = Db::name('usual_car')->where('model_id',$id)->whereOr('serie_id',$id)->count();
        $categoryPostCount = Db::name('service')->where('model_id',$id)->count();
        if ($categoryPostCount > 0) {
            $this->error('此模型下有业务，无法删除!');
        }

        // $data   = [
        //     'object_id'   => $findCategory['id'],
        //     'create_time' => time(),
        //     'table_name'  => 'ServiceCategory',
        //     'name'        => $findCategory['name']
        // ];
        $result = model('ServiceCategory')
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