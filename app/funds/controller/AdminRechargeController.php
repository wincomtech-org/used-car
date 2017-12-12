<?php
namespace app\funds\controller;

use cmf\controller\AdminBaseController;
use app\funds\model\FundsApplyModel;
use think\Db;

/**
* 后台 
* 财务管理 充值管理
*/
class AdminRechargeController extends AdminBaseController
{
    public function index()
    {
        $param = $this->request->param();
        $param['type'] = 'recharge';

        $fundsModel = new FundsApplyModel();
        $list = $fundsModel->getLists($param);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('list', $list->items());
        $list->appends($param);
        $this->assign('pager', $list->render());
        return $this->fetch();
    }

    // 给用户加钱
    public function add()
    {

        return $this->fetch();
    }

    public function addPost()
    {
        $data = $this->request->param();

        // 验证
        $result = $this->validate($data,'Funds.coin');
        if ($result===false) {
            $this->error($result);
        }
        // 获取uid
        $uid = intval($data['uname']);
        if (empty($uid)) {
            $uid = Db::name('user')->whereOr(['user_nickname|user_login|user_email|mobile'=>$data['uname']])->value('id');
            $uid = intval($uid);
        }

        // 保存数据
        // $res = model('');
        $transStatus = true;
        Db::startTrans();
        try{
            Db::name('user')->where('id',$uid)->setInc('coin',$data['coin']);
            $post = [
                'user_id' => $uid,
                'type' => 11,
                'coin' => $data['coin'],
                'app' => 'funds',
                'obj_id' => cmf_get_current_admin_id(),
            ];
            lothar_put_funds_log($post);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $transStatus = false;
        }

        if ($transStatus===false) {
            $this->error('用户充值失败');
        }
        $userNew   = Db::name('user')->where('id',$uid)->find();
        cmf_update_current_user($userNew);
        $this->success('用户充值成功',url('AdminFunds/index'));
    }

    public function addTicket()
    {
        return $this->fetch();
    }

    public function addTicketPost()
    {
        $data = $this->request->param();

        // 验证
        $result = $this->validate($data,'Funds.ticket');
        if ($result===false) {
            $this->error($result);
        }
        // 获取uid
        $uid = intval($data['uname']);
        if (empty($uid)) {
            $uid = Db::name('user')->whereOr(['user_nickname|user_login|user_email|mobile'=>$data['uname']])->value('id');
            $uid = intval($uid);
        }

        // 保存数据
        $transStatus = true;
        Db::startTrans();
        try{
            Db::name('user')->where('id',$uid)->setInc('ticket',$data['ticket']);
            $post = [
                'user_id' => $uid,
                'type' => 11,
                'ticket' => $data['ticket'],
                'deal_uid' => cmf_get_current_admin_id(),
                'create_time' => time(),
            ];
            Db::name('user_ticket_log')->insert($post);
            // lothar_put_funds_log($post);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $transStatus = false;
        }

        if ($transStatus===false) {
            $this->error('用户增加点券失败');
        }
        $this->success('用户增加点券成功',url('AdminFunds/index'));
    }

    public function more()
    {
        # code...
    }
}