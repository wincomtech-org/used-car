<?php
namespace app\usual\controller;

// use app\admin\model\RouteModel;
use cmf\controller\AdminBaseController;
use app\usual\model\UsualItemCateModel;
use think\Db;
// use app\admin\model\ThemeModel;


class AdminItemCateController extends AdminBaseController
{
    function _initialize()
    {
        // parent::_initialize();
        // $data = $this->request->param();
        $this->UsualModel = new UsualItemCateModel();
    }

    public function index()
    {
        $config = [
            'm'         => 'AdminItemCate',
            'url'       => '',
            'add'       => true,
            'edit'      => true,
            'delete'    => false
        ];
        $categoryTree    = $this->UsualModel->adminCategoryTableTree(0,'',$config,['unit'=>1,'code'=>1,'code_type'=>1,'is_rec'=>1]);

        $this->assign('category_tree', $categoryTree);
        return $this->fetch();
    }

    public function add()
    {
        $parentId           = $this->request->param('parent', 0, 'intval');
        $categoriesTree     = $this->UsualModel->adminCategoryTree($parentId);
        $codeType           = $this->UsualModel->getCodeType();

        $this->assign('categories_tree', $categoriesTree);
        $this->assign('codeType', $codeType);
        return $this->fetch();
    }
    public function addPost()
    {
        $data = $this->request->param();
        $result = $this->validate($data,'ItemCate.add');
        if ($result !== true) {
            $this->error($result);
        }
        $result = $this->UsualModel->addCategory($data);
        if ($result === false) {
            $this->error('添加失败!');
        }
        $this->success('添加成功!', url('AdminItemCate/index'));
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id > 0) {
            $category = UsualItemCateModel::get($id)->toArray();
            $categoriesTree      = $this->UsualModel->adminCategoryTree($category['parent_id'], $id);
            $codeType           = $this->UsualModel->getCodeType($category['code_type']);

            $this->assign($category);
            $this->assign('categories_tree', $categoriesTree);
            $this->assign('codeType', $codeType);
            return $this->fetch();
        } else {
            $this->error('操作错误!');
        }
    }
    public function editPost()
    {
        $data = $this->request->param();
        // 字段验证
        $result = $this->validate($data,'ItemCate.edit');
        if ($result !== true) {
            $this->error($result);
        }
        // 提交结果
        unset($data['code']);
        $result = $this->UsualModel->editCategory($data);
        if ($result === false) {
            $this->error('保存失败!');
        }
        $this->success('保存成功!');
    }

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
        $categoryTree = $this->UsualModel->adminCategoryTableTree($selectedIds, $tpl);

        $where      = ['delete_time' => 0];
        $categories = $this->UsualModel->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    public function listOrder()
    {
        parent::listOrders(Db::name('UsualItemCate'));
        $this->success("排序更新成功！", '');
    }

    public function delete()
    {
        $id = $this->request->param('id');
        //获取删除的内容
        $findCategory = $this->UsualModel->where('id', $id)->find();
        if (empty($findCategory)) {
            $this->error('分类不存在!');
        }

        $categoryChildrenCount = $this->UsualModel->where('parent_id', $id)->count();
        if ($categoryChildrenCount > 0) {
            $this->error('此分类有子类无法删除，请改名!');
        }

        $categoryPostCount = Db::name('UsualItem')->where('cate_id',$id)->count();
        if ($categoryPostCount > 0) {
            $this->error('此分类有属性无法删除，请改名!');
        }

        // $data   = [
        //     'object_id'   => $findCategory['id'],
        //     'create_time' => time(),
        //     'table_name'  => 'usual_brand',
        //     'name'        => $findCategory['name']
        // ];
        $result = $this->UsualModel
            ->where('id', $id)
            ->update(['delete_time' => time()]);
        if ($result) {
            // Db::name('recycleBin')->insert($data);
            $this->success('删除成功!');
        } else {
            $this->error('删除失败');
        }
    }
}