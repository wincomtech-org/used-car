<?php
namespace app\funds\controller;

use cmf\controller\AdminBaseController;
use app\funds\model\FundsApplyModel;
use think\Db;

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
// dump($data);die;

        bcscale(2);
        if ($data['status']==-1 || $data['status']==-2) {
            $transStatus = true;
            Db::startTrans();
            try{
                model('FundsApply')->allowField(true)->isUpdate(true)->data($data, true)->save();
                Db::name('user')->where('id',$data['user_id'])->setInc('coin',$data['coin']);
                Db::name('user')->where('id',$data['user_id'])->setDec('freeze',$data['coin']);

                $userNew   = Db::name('user')->where('id',$data['user_id'])->find();
                // lothar_put_funds_log($data['user_id'], -9, $data['coin'],$userNew['coin'], 'funds',cmf_get_current_admin_id());
                cmf_update_current_user($userNew);
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                $transStatus = false;
            }
        } elseif ($data['status']==10) {
            $transStatus = true;
            Db::startTrans();
            try{
                model('FundsApply')->allowField(true)->isUpdate(true)->data($data, true)->save();
                Db::name('user')->where('id',$data['user_id'])->setDec('coin',$data['coin']);
                Db::name('user')->where('id',$data['user_id'])->setDec('freeze',$data['coin']);

                $userNew   = Db::name('user')->where('id',$data['user_id'])->find();
                lothar_put_funds_log($data['user_id'], 9, -$data['coin'],$userNew['coin'], 'funds',cmf_get_current_admin_id());
                cmf_update_current_user($userNew);
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                $transStatus = false;
            }
        } else {
            $transStatus = model('FundsApply')->allowField(true)->isUpdate(true)->data($data, true)->save();
        }

        // $result = model('FundsApply')->allowField(true)->isUpdate(true)->data($data, true)->save();
        // $result = Db::name('funnds_apply')->update($data);

        if (empty($transStatus)) {
            $this->error('修改失败');
        }
        $this->success('修改成功',url('index'));
    }

    public function more()
    {
        # code...
    }
}