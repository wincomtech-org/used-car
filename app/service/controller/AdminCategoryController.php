<?php
namespace app\service\controller;

use think\Db;
use cmf\controller\AdminBaseController;
use app\service\model\ServiceCategoryModel;

class AdminCategoryController extends AdminBaseController
{
    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $categories = model('ServiceCategory')->getLists($param);

        $cateType = isset($param['cateType']) ? $param['cateType'] : '';
        $keyword = isset($param['keyword']) ? $param['keyword'] : '';
        
        $this->assign('cateType',$cateType);
        $this->assign('keyword',$keyword);
        $this->assign('categories', $categories->items());// 获取查询数据并赋到模板
        $categories->appends($param);//添加URL参数
        $this->assign('pager', $categories->render());// 获取分页代码并赋到模板

        return $this->fetch();
    }

    public function add()
    {
        // 没有上级
        $this->op();
        return $this->fetch();
    }
    public function addPost()
    {
        $cate = $this->opPost('add');

        $result = model('ServiceCategory')->addCategory($cate);

        if ($result === false) {
            $this->error('添加失败!');
        }
        $this->success('添加成功!', url('AdminCategory/index'));
    }

    public function op($category=[])
    {
        $scModel = new ServiceCategoryModel;
        if (!isset($category['define_data'])) {
            $category['define_data'] = [];
        }
        // if (!isset($category['define_data2'])) {
        //     $selectIds = [];
        // } else {
        //     $selectIds = json_decode($category['define_data2'],true);
        // }
        
        // 没有上级
        $defineData = $scModel->getDefineData($category['define_data']);
        // 获取自定义字段
        // $defineData2 = Db::name('service_define')->field('id,name')->select();
        // $tpl = '';
        // foreach ($defineData2 as $vo) {
        //     $tpl .= '<label class="define_label"><input class="define_input" type="checkbox" name="define_data2[]" value="'.$vo['id'].'" '.(in_array($vo['id'],$selectIds)?'checked':'').'><span> &nbsp;'.$vo['name'].'</span></label>';
        // }

        $this->assign('defineData',$defineData);
        // $this->assign('defineData2',$tpl);
    }
    public function opPost($valid='add')
    {
        $data   = $this->request->param();
        // $data   = $_POST;
        $cate = $data['cate'];
        $cate['define_data'] = empty($data['define_data']) ? [] : $data['define_data'];
        // $cate['define_data2'] = empty($data['define_data2']) ? [] : $data['define_data2'];
        // $cate['define_data2'] = json_encode($data['define_data2']);

        $result = $this->validate($cate, 'Category.'.$valid);
        if ($result !== true) {
            $this->error($result);
        }

    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        $scModel = new ServiceCategoryModel;
        if ($id > 0) {
            /*使用模型处理*/
            $category = $scModel->getPost($id);

            /*使用原生处理*/
            // $category = Db::name('service_category')->where('id',$id)->find();
            // // 富文本
            // $category['content'] = $this->ueditorAfter($category['content']);
            // // 自定义客户字段
            // $category['define_data'] = json_decode($category['define_data'],true);

        } else {
            $this->error('操作错误!');
        }

        $this->op($category);

        $this->assign($category);
        return $this->fetch();
    }
    public function editPost()
    {
        $cate = $this->opPost('edit');

        /*使用模型处理*/
        $result = model('ServiceCategory')->editCategory($cate);

        /*使用原生处理*/
        // $data = $_POST;
        // $cate = $data['cate'];
        // // 富文本
        // $cate['content'] = $this->ueditorBefore($cate['content']);
        // // 自定义客户字段
        // $cate['define_data'] = empty($data['define_data']) ? '': json_encode($data['define_data']);
        // $result = $this->validate($cate, 'Category.edit');
        // if ($result !== true) {
        //     $this->error($result);
        // }
        // $result = Db::name('service_category')->update($cate);

        if ($result === false) {
            $this->error('保存失败!');
        }
        $this->success('保存成功!',url('edit',['id'=>$cate['id']]));
    }

    public function select()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);
        $categoryTree = model('ServiceCategory')->createCategoryTableTree($selectedIds);

        $where      = ['status' => 1];
        $categories = model('ServiceCategory')->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categoryTree', $categoryTree);
        return $this->fetch();
    }

    public function listOrder()
    {
        parent::listOrders(Db::name('ServiceCategory'));
        $this->success("排序更新成功！", '');
    }

    // 删除 回收机制
    public function delete()
    {
        $id = $this->request->param('id');
        //获取删除的内容
        $find = model('ServiceCategory')->where('id', $id)->find();
        if (empty($find)) {
            $this->error('模型不存在!');
        }
        if (model('Service')->where('model_id',$id)->count() > 0) {
            $this->error('此模型下有业务，无法删除!');
        }

        // $data   = [
        //     'object_id'   => $find['id'],
        //     'create_time' => time(),
        //     'table_name'  => 'ServiceCategory',
        //     'name'        => $find['name']
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




    // 自定义客户字段
    public function defineSet()
    {
        $list = Db::name('service_define')->paginate(16);

        $this->assign('list',$list);
        // $list->appends();
        $this->assign('pager',$list->render());
        return $this->fetch();
    }
    public function add2()
    {
        // config('service_define_type');

        return $this->fetch();
    }
    public function edit2()
    {
        $id = $this->request->param('id',0,'intval');
        $post = Db::name('service_define')->where('id',$id)->find();
        $this->assign($post);
        return $this->fetch();
    }
    public function opPost2()
    {
        $data = $this->request->param();
        $id = $this->request->param('id',0,'intval');

        if (empty($id)) {
            $valid = 'add';
        } else {
            $valid = 'edit';
        }

        // 字段验证
        $result = $this->validate($data, 'Define.'.$valid);
        if ($result !== true) {
            $this->error($result);
        }

        if (empty($id)) {
            $result = Db::name('service_define')->insertGetId($data);
        } else {
            $result = Db::name('service_define')->update($data);
        }

        if ($result) {
            $this->success('添加成功',url('defineSet'));
        }
        $this->error('修改失败 或 无更新');
    }
}