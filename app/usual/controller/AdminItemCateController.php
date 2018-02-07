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
        parent::_initialize();
        $this->cateModel = new UsualItemCateModel();
    }

    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $parent = $this->request->param('parent',0,'intval');

        $list = $this->cateModel->getLists($param);
        // dump($list);die;
        $cates = model('UsualItemCate')->getFirstCate($parent);

        $this->assign('keyword', isset($param['keyword'])?$param['keyword']:'');
        // $this->assign('jumpext','keyword='.$keyword.'&parent='.$parent);
        $this->assign('categorys', $cates);
        $this->assign('list', $list);
        return $this->fetch();
    }

    public function add()
    {
        $parentId           = $this->request->param('parent', 0, 'intval');
        $categoriesTree     = $this->cateModel->adminCategoryTree($parentId);
        $codeType           = $this->cateModel->getCodeType();

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
        $result = $this->cateModel->addCategory($data);
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
            $categoriesTree      = $this->cateModel->adminCategoryTree($category['parent_id'], $id);
            $codeType           = $this->cateModel->getCodeType($category['code_type']);
            // 被保留的字段码
            $reserve = config('usual_car_filter_var02').','.config('usual_car_filter_var').','.config('usual_car_filter_var2');
            $reserve = explode(',', $reserve);
            $is_reserve = false;
            if (in_array($category['code'],$reserve)) {
                $is_reserve = true;
            }

            $this->assign($category);
            $this->assign('categories_tree', $categoriesTree);
            $this->assign('codeType', $codeType);
            $this->assign('is_reserve', $is_reserve);
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
        // unset($data['code']);
        $result = $this->cateModel->editCategory($data);
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
        $categoryTree = $this->cateModel->adminCategoryTableTree($selectedIds, $tpl);

        $where      = ['delete_time' => 0];
        $categories = $this->cateModel->where($where)->select();

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

    // 删除 回收机制
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
        $result = $this->cateModel
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