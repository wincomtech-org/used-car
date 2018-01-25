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
        $this->assign('define_data',model('ServiceCategory')->getDefineData());
        return $this->fetch();
    }
    public function addPost()
    {
        $data   = $this->request->param();
        // $data   = $_POST;
        $cate = $data['cate'];
        $cate['define_data'] = empty($data['define_data']) ? '': $data['define_data'];
        $result = $this->validate($cate, 'Category.add');
        if ($result !== true) {
            $this->error($result);
        }

        $result = model('ServiceCategory')->addCategory($cate);

        if ($result === false) {
            $this->error('添加失败!');
        }
        $this->success('添加成功!', url('AdminCategory/index'));
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id > 0) {
            /*使用模型处理*/
            $category = model('ServiceCategory')->getPost($id);

            /*使用原生处理*/
            // $category = Db::name('service_category')->where('id',$id)->find();
            // // 富文本
            // $category['content'] = $this->ueditorAfter($category['content']);
            // // 自定义客户字段
            // $category['define_data'] = json_decode($category['define_data'],true);

        } else {
            $this->error('操作错误!');
        }

        $this->assign($category);
        $this->assign('define_data',model('ServiceCategory')->getDefineData($category['define_data']));
        return $this->fetch();
    }
    public function editPost()
    {
        /*使用模型处理*/
        $data   = $this->request->param();
        $cate = $data['cate'];
        $cate['define_data'] = empty($data['define_data']) ? '': $data['define_data'];
        $result = $this->validate($cate, 'Category.edit');
        if ($result !== true) {
            $this->error($result);
        }
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