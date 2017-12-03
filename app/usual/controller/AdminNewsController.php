<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;
use app\usual\model\NewsModel;
use think\Db;

/**
* 消息模块
*/
class AdminNewsController extends AdminBaseController
{
    // protected function initialize()
    // {
    //     parent::initialize();
    // }

    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $appId = $this->request->param('appId',null);
        $status = $this->request->param('status',null);

        $newModel = new NewsModel();
        $data = $newModel->getLists($param);
        $apps = $newModel->cateOptions($appId);
        $statusOptions = $newModel->getStatus($status);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');

        $this->assign('categorys',$apps);
        $this->assign('statusOptions',$statusOptions);
        $this->assign('list', $data->items());
        $data->appends($param);
        $this->assign('pager', $data->render());

        return $this->fetch();
    }

    public function edit()
    {
        $id = $this->request->param('id',0,'intval');

        $newModel = new NewsModel();
        $post = $newModel->getPost($id);
        $apps = $newModel->cateOptions($post['app']);
        $statusOptions = $newModel->getStatus($post['status']);

        $this->assign('categorys',$apps);
        $this->assign('statusOptions',$statusOptions);
        $this->assign('post',$post);

        return $this->fetch();
    }
    public function editPost()
    {
        $data = $this->request->param();
        $post = $data['post'];
        $post['deal_uid'] = cmf_get_current_admin_id();

        $result = Db::name('news')->update($post);
        if ($result) {
            $this->success('提交成功',url('index'));
        }
        $this->error('提交失败');
    }

    // 批量处理
    public function deal()
    {
        $param = $this->request->param();

        if (isset($param['ids']) && isset($param['status'])) {
            $ids = $this->request->param('ids/a');
            model('News')->where(['id' => ['in', $ids]])->update(['status'=>$param['status'],'deal_uid'=>cmf_get_current_admin_id()]);
            switch ($param['status']) {
                case '1':$desc='已读';break;
                case '2':$desc='已处理';break;
                default:$desc='未读';break;
            }
            $this->success("批量{$desc}成功！", '');
        }
        $this->error('数据错误！');
    }

    public function delete()
    {
        $param           = $this->request->param();

        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            $result = model('News')->where(['id' => $id])->delete();
            if ($result) {
                $this->success("删除成功！", '');
            }
        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $result  = model('News')->where(['id' => ['in', $ids]])->delete();
            if ($result) {
                $this->success('删除成功！','');
            }
        }
        $this->error('删除失败！');
    }
}