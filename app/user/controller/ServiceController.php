<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
use app\user\model\UserModel;
// use think\Validate;
use think\Db;

/**
* 个人中心 保险
*/
class ServiceController extends UserBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    // 列表页
    public function index()
    {
        $userId = cmf_get_current_user_id();
        $extra = ['user_id'=>$userId];

        $list = model('service/Service')->getLists([],'','',$extra);
        // dump($list);

        $this->assign('list',$list);
        return $this->fetch();
    }

    public function details()
    {
        $id = $this->request->param('id/d');

        $page = model('service/Service')->getPost($id);

        $this->assign('page',$page);
        return $this->fetch();
    }

    public function cancel()
    {
        $id = $this->request->param('id/d');
        $result = Db::name('service')->where('id',$id)->setField('status',-1);
        if ($result) {
            $this->success('取消成功');
        } else {
            $this->error('取消失败');
        }
        

        return $this->fetch();
    }

    public function del()
    {
        parent::del(Db::name('service'));
        $this->success("刪除成功！", '');

        // 传统
        // $id = $this->request->param('id/d');
        // $result = parent::del(['id'=>$id],Db::name('service'));
        // if ($result) {
        //     $this->success('刪除成功');
        // } else {
        //     $this->error('删除失败！');
        // }
    }

    public function more()
    {
        return $this->fetch();
    }
}