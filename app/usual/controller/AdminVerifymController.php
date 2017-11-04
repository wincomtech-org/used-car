<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;
use think\Db;
// use app\verify\usual\VerifyModelModel;
// use app\admin\model\ThemeModel;

/**
* 认证模型模块
*/
class AdminVerifymController extends AdminBaseController
{
    // function _initialize()
    // {
    //     // parent::_initialize();
    // }

    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $categories = model('VerifyModel')->getLists($param);

        $categories->appends($param);//添加URL参数
        $this->assign('categories', $categories->items());// 获取查询数据并赋到模板
        $this->assign('page', $categories->render());// 获取分页代码并赋到模板

        return $this->fetch();
    }

    public function add()
    {
        // 没有上级
        $this->assign('define_data',model('VerifyModel')->getDefineData());
        return $this->fetch();
    }
    public function addPost()
    {
        $data = $this->request->param();
        $cate = $data['cate'];
        $result = $this->validate($cate, 'VerifyM.add');
        if ($result !== true) {
            $this->error($result);
        }
        $data['define_data'] = empty($data['define_data'])?[]:$data['define_data'];
        $result = model('VerifyModel')->addCategory($cate,$data['define_data']);
        if ($result === false) {
            $this->error('添加失败!');
        }

        $this->success('添加成功!', url('AdminVerifym/index'));
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        $code = $this->request->param('code');
        if ($id > 0) {
            $post = model('VerifyModel')->getPost($id);
        } elseif (!empty($code)) {
            // $post = Db::name('VerifyModel')->where(['code'=>$code])->find();
            $post = model('VerifyModel')->where(['code'=>$code])->find()->toArray();
        } else {
            $this->error('操作错误!');
        }
        $this->assign($post);
        $this->assign('define_data',model('VerifyModel')->getDefineData($post['more']));

        return $this->fetch();
    }
    public function editPost()
    {
        $data = $this->request->param();
        $cate = $data['cate'];
        $result = $this->validate($cate, 'VerifyM.edit');
        if ($result !== true) {
            $this->error($result);
        }

        $result = model('VerifyModel')->editCategory($cate);
        if ($result === false) {
            $this->error('保存失败!');
        }

        $this->success('保存成功!');
    }

    public function select()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);
        $categoryTree = model('VerifyModel')->createCategoryTableTree($selectedIds);

        $where      = ['status' => 1];
        $categories = model('VerifyModel')->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categoryTree', $categoryTree);
        return $this->fetch();
    }

    public function listOrder()
    {
        parent::listOrders(Db::name('VerifyModel'));
        $this->success("排序更新成功！", '');
    }

    public function delete()
    {
        $id = $this->request->param('id');
        //获取删除的内容
        $find = model('VerifyModel')->where('id', $id)->find();
        if (empty($find)) {
            $this->error('模型不存在!');
        }
        if (model('Verify')->where('model_id',$id)->count() > 0) {
            $this->error('此模型下有认证资料，无法删除!');
        }

        // $data   = [
        //     'object_id'   => $find['id'],
        //     'create_time' => time(),
        //     'table_name'  => 'VerifyModel',
        //     'name'        => $find['name']
        // ];
        $result = model('VerifyModel')
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