<?php
namespace app\trade\controller;

use cmf\controller\AdminBaseController;
use app\trade\model\TradeReportCateModel;
use think\Db;


class AdminReportCateController extends AdminBaseController
{
    function _initialize()
    {
        // parent::_initialize();
        // $data = $this->request->param();
        $this->uModel = new TradeReportCateModel();
    }

    public function index()
    {
        $topId = $request = input('request.topId');
        // dump($topId);die;
        $config = [
            'm'         => 'AdminReportCate',
            'url'       => '',
            'add'       => true,
            'edit'      => true,
            'delete'    => false
        ];
        $extra = ['unit'=>1,'code_type'=>1,'is_rec'=>1];
        $filter = [];
        if (!empty($topId)) {
            $filter['path'] = [['eq',"0-{$topId}"],['like',"0-{$topId}-%"],'OR'];
            // $filter['path'] = ['like',["0-{$topId}","0-{$topId}-%"],'AND'];
        }
        $categoryTree = $this->uModel->adminCategoryTableTree(0,'',$config,$extra,$filter);

        $firstTree = $this->uModel->adminCategoryTree($topId,0,0);
        // dump($firstTree);die;

        $this->assign('firstTree', $firstTree);
        $this->assign('firstTree', $firstTree);
        $this->assign('category_tree', $categoryTree);
        return $this->fetch();
    }

    public function add()
    {
        $parentId           = $this->request->param('parent', 0, 'intval');
        $categoriesTree     = $this->uModel->adminCategoryTree($parentId);
        $codeType           = $this->uModel->getCodeType();

        $this->assign('categories_tree', $categoriesTree);
        $this->assign('codeType', $codeType);
        return $this->fetch();
    }
    public function addPost()
    {
        $data = $this->request->param();
        $result = $this->validate($data,'usual/ItemCate.add');
        if ($result !== true) {
            $this->error($result);
        }
        $result = $this->uModel->addCategory($data);
        if ($result === false) {
            $this->error('添加失败!');
        }
        $this->success('添加成功!', url('AdminReportCate/index'));
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id > 0) {
            $category = TradeReportCateModel::get($id)->toArray();
            $categoriesTree = $this->uModel->adminCategoryTree($category['parent_id'], $id);
            $codeType = $this->uModel->getCodeType($category['code_type']);

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
        $result = $this->validate($data,'usual/ItemCate.edit');
        if ($result !== true) {
            $this->error($result);
        }
        // 提交结果
        unset($data['code']);
        $result = $this->uModel->editCategory($data);
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
        $categoryTree = $this->uModel->adminCategoryTableTree($selectedIds, $tpl);

        $where      = ['delete_time' => 0];
        $categories = $this->uModel->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    public function listOrder()
    {
        parent::listOrders(Db::name('TradeReportCate'));
        $this->success("排序更新成功！", '');
    }

    // 删除 回收机制
    public function delete()
    {
        $id = $this->request->param('id');
        //获取删除的内容
        $findCategory = $this->uModel->where('id', $id)->find();
        if (empty($findCategory)) {
            $this->error('分类不存在!');
        }

        $categoryChildrenCount = $this->uModel->where('parent_id', $id)->count();
        if ($categoryChildrenCount > 0) {
            $this->error('此分类有子类无法删除，请改名!');
        }

        $categoryPostCount = Db::name('TradeReport')->where('cate_id',$id)->count();
        if ($categoryPostCount > 0) {
            $this->error('此分类有属性无法删除，请改名!');
        }

        // $data   = [
        //     'object_id'   => $findCategory['id'],
        //     'create_time' => time(),
        //     'table_name'  => 'usual_brand',
        //     'name'        => $findCategory['name']
        // ];
        $result = $this->uModel
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