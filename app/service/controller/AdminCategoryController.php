<?php
namespace app\service\controller;

use cmf\controller\AdminBaseController;
use think\Db;
// use app\service\model\ServiceCategoryModel;
// use app\admin\model\ThemeModel;
// use think\Env;

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

        $cateType = isset($param['cateType']) ? $param['cateType'] : '';
        $keyword = isset($param['keyword']) ? $param['keyword'] : '';

        $categories->appends($param);//添加URL参数
        $this->assign('categories', $categories->items());// 获取查询数据并赋到模板
        $this->assign('page', $categories->render());// 获取分页代码并赋到模板
        $this->assign('cateType',$cateType);
        $this->assign('keyword',$keyword);

        return $this->fetch();
    }

    public function add()
    {
        // 没有上级
        $this->assign('define_data',model('ServiceCategory')->getDefineData());
        return $this->fetch();
    }
    public function addPost()
    {
        $data = $this->request->param();
        $cate = $data['cate'];
        $result = $this->validate($cate, 'Category.add');
        if ($result !== true) {
            $this->error($result);
        }
        $data['define_data'] = empty($data['define_data'])?[]:$data['define_data'];
        $result = model('ServiceCategory')->addCategory($cate,$data['define_data']);
        if ($result === false) {
            $this->error('添加失败!');
        }

        $this->success('添加成功!', url('AdminCategory/index'));
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id > 0) {
            $category = model('ServiceCategory')->getPost($id);
            $this->assign($category);
            $this->assign('define_data',model('ServiceCategory')->getDefineData($category['define_data']));
            return $this->fetch();
        } else {
            $this->error('操作错误!');
        }
    }
    public function editPost()
    {
        $data = $this->request->param();
        $cate = $data['cate'];
        $result = $this->validate($cate, 'Category.edit');
        if ($result !== true) {
            $this->error($result);
        }

        $data['define_data'] = empty($data['define_data'])?[]:$data['define_data'];
        $result = model('ServiceCategory')->editCategory($cate,$data['define_data']);
        if ($result === false) {
            $this->error('保存失败!');
        }

        $this->success('保存成功!');
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
}