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
        $fundsModel = new FundsApplyModel();
        $uid = $fundsModel->getUid($data['uname']);

        // 保存数据
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

    // 给用户充点券
    public function addTicket()
    {
        return $this->fetch('addTicket');
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
        $fundsModel = new FundsApplyModel();
        $uid = $fundsModel->getUid($data['uname']);

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

    // Excel导出 
    public function orderExcel()
    {
        $ids = $this->request->param('ids/a');
        $where = [];
        if (!empty($ids)) {
            $where = ['a.id'=>['in',$ids]];
        }
        $where['a.type'] = 'recharge';

        $title = '充值管理';
        $head = ['订单号','充值金额','用户ID','支付方式','创建时间','状态'];
        $field = 'a.order_sn,a.coin,a.user_id,a.payment,a.create_time,a.status';
        $dir = 'funds';
        $statusV = config('funds_apply_status');

        $data = Db::name('funds_apply')->alias('a')
              ->join('user b','a.user_id=b.id')
              ->field($field)
              ->where($where)
              ->select()->toArray();
        if (empty($data)) {
            $this->error('数据为空！');
        }

        $new = [];
        foreach ($data as $key => $value) {
            $value['create_time'] = date('Y-m-d H:i',$value['create_time']);
            $value['status'] = $statusV[$value['status']];
            $new[] = $value;
        }

        model('FundsApply')->excelPort($title, $head, $new, $where, $dir);
    }

    // 更多……  保留代码
    public function more()
    {
        # code...
    }
}