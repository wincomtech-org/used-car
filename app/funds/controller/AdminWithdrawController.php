<?php
namespace app\funds\controller;

use cmf\controller\AdminBaseController;
use app\funds\model\FundsApplyModel;
// use think\Db;

/**
* 后台 
* 财务管理 提现管理
*/
class AdminWithdrawController extends AdminBaseController
{
    public function index()
    {
        $param = $this->request->param();
        $param['type'] = 'withdraw';

        $fundsModel = new FundsApplyModel();
        $list = $fundsModel->getLists($param);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('list', $list->items());
        $list->appends($param);
        $this->assign('pager', $list->render());
        return $this->fetch();
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');

        $fundsModel = new FundsApplyModel();
        $post = $fundsModel->getPost($id);
        if (empty($post)) {
            $this->error('数据不存在！');
        }

        $this->assign('post', $post);
        return $this->fetch();
    }
    public function editPost()
    {
        $data = $this->request->post();
        // 验证
        $result = $this->validate($data,'Apply.withdraw');
        if ($result===false) {
            $this->error($result);
        }

        // $result = model('FundsApply')->isUpdate(true)->save($data);
        if (!empty($result)) {
            $this->success('修改成功');
        }
        $this->error('修改失败');
    }

    public function more()
    {
        # code...
    }
}