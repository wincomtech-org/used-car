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
        // 没有上级
        $defineData = $scModel->getDefineData($category['define_data']);

        // 新的设计
        // $defineData = [];

        $this->assign('defineData',$defineData);
    }
    public function opPost($valid='add')
    {
        $data   = $this->request->param();
        // $data   = $_POST;
        $cate = $data['cate'];

        $cate['define_data'] = empty($data['define_data']) ? [] : $data['define_data'];

        // 新的设计


        $result = $this->validate($cate, 'Category.'.$valid);
        if ($result !== true) {
            $this->error($result);
        }
        return $cate;
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        $scModel = new ServiceCategoryModel;
        if ($id == 0) {
            $this->error('操作错误!');
        }
        $category = $scModel->getPost($id);
        // 富文本处理 ueditorAfter()
        $this->op($category);
        $this->assign($category);
        return $this->fetch();
    }
    public function editPost()
    {
        $cate = $this->opPost('edit');
        /*使用模型处理*/
        $result = model('ServiceCategory')->editCategory($cate);
        // 富文本处理 ueditorBefore()
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
        $this->error('未开放');
        $list = Db::name('service_define')->order('id desc')->paginate(16);

        $this->assign('list',$list);
        // $list->appends();
        $this->assign('pager',$list->render());
        return $this->fetch();
    }
    public function add2()
    {
        $this->error('未开放');
        // config('service_define_type');

        $scModel = new ServiceCategoryModel;
        $types = $scModel->getStatus('','service_define_type');

        $this->assign('types',$types);
        return $this->fetch();
    }
    public function edit2()
    {
        // $this->error('未开放');
        $id = $this->request->param('id',0,'intval');
        if ($id<18) {
            $this->error('非法操作！');
        }
        $post = Db::name('service_define')->where('id',$id)->find();

        $scModel = new ServiceCategoryModel;
        $types = $scModel->getStatus($post['type'],'service_define_type');

        $this->assign($post);
        $this->assign('types',$types);
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