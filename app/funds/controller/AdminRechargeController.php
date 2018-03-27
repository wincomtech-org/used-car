<?php
namespace app\funds\controller;

use cmf\controller\AdminBaseController;
use app\funds\model\FundsApplyModel;
use think\Db;

/**
* 后台,财务管理。 懒得再弄文件，就放一起了
* 充值管理
* 积分管理
* 优惠券管理
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

    // 给用户加金币
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
        if (empty($uid)) $this->error('用户数据丢失');

        // 保存数据
        $transStatus = true;
        Db::startTrans();
        try{
            Db::name('user')->where('id',$uid)->setInc('coin',$data['coin']);
            $log = [
                'user_id' => $uid,
                'type' => 11,
                'coin' => $data['coin'],
                'app' => 'funds',
                'obj_id' => cmf_get_current_admin_id(),
            ];
            lothar_put_funds_log($log);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $transStatus = false;
        }

        if ($transStatus===false) {
            $this->error('用户充值失败');
        }
        $userNew = Db::name('user')->where('id',$uid)->find();
        cmf_update_current_user($userNew);
        $this->success('用户充值成功',url('AdminFunds/index'));
    }

    // 给用户充积分
    public function listScore()
    {
        $list = Db::name('user_score_log')->paginate();
        // dump($list);die;
        $this->assign('list', $list);
        $this->assign('pager', $list->render());
        return $this->fetch('listScore');
    }
    public function addScore()
    {
        return $this->fetch('addScore');
    }
    public function addScorePost()
    {
        $data = $this->request->param();
        // 验证
        $result = $this->validate($data,'Funds.score');
        if ($result===false) {
            $this->error($result);
        }
        // 获取uid
        $fundsModel = new FundsApplyModel();
        $uid = $fundsModel->getUid($data['uname']);
        if (empty($uid)) $this->error('用户数据丢失');

        // 保存数据
        $transStatus = true;
        Db::startTrans();
        try{
            Db::name('user')->where('id',$uid)->setInc('score',$data['score']);
            $log = [
                'user_id' => $uid,
                'action' => 'admin',
                'score' => $data['score'],
                'deal_uid' => cmf_get_current_admin_id(),
                'create_time' => time(),
            ];
            Db::name('user_score_log')->insert($log);
            // lothar_put_funds_log($post);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $transStatus = false;
        }

        if ($transStatus===false) {
            $this->error('用户增加积分失败');
        }
        $userNew = Db::name('user')->where('id',$uid)->find();
        cmf_update_current_user($userNew);
        $this->success('用户增加积分成功',url('AdminRecharge/listScore'));
    }

    // 发放优惠券
    public function listCoupon()
    {
        $id = $this->request->param('id');
        $where = [];
        if (!empty($id)) {
            $where['id'] = $id;
        }
        $list = Db::name('user_coupons_log')->where($where)->paginate();
        $this->assign('list', $list);
        $this->assign('pager', $list->render());
        return $this->fetch('listCoupon');
    }
    public function addCoupon()
    {
        return $this->fetch('addCoupon');
    }
    public function addCouponPost()
    {
        $data = $this->request->param();
        // 验证
        $result = $this->validate($data,'Funds.coupon');
        if ($result===false) {
            $this->error($result);
        }
        // 获取uid
        $uid = model('usual/Usual')->getUid($data['uname']);
        if (empty($uid)) $this->error('用户数据丢失');

        // 保存数据
        $transStatus = true;
        Db::startTrans();
        try{
            Db::name('user')->where('id',$uid)->inc('coupon');
            $log = [
                'user_id'   => $uid,
                'type'      => 11,
                'coupon'    => $data['coupon'],
                'reduce'    => $data['reduce'],
                'deal_uid'  => cmf_get_current_admin_id(),
                'status'    => (empty($data['status'])?0:$data['status']),
                'due_time'  => (empty($data['due_time'])?0:strtotime($data['due_time'])),
                'create_time' => time(),
            ];
            Db::name('user_coupons_log')->insert($log);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $transStatus = false;
        }

        if ($transStatus===false) {
            $this->error('添加优惠券失败');
        }
        $userNew = Db::name('user')->where('id',$uid)->find();
        cmf_update_current_user($userNew);
        $this->success('添加优惠券成功',url('AdminRecharge/listCoupon'));
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