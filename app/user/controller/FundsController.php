<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
use app\user\model\UserModel;
use app\funds\model\UserFundsLogModel;
use app\funds\model\FundsApplyModel;
// use think\Validate;
use think\Db;

/**
* 个人中心
* 财务管理 资金动向
*/
class FundsController extends UserBaseController
{
    function _initialize()
    {
        parent::_initialize();
        $u_f_nav = $this->request->action();

        $this->user = cmf_get_current_user();

// dump($u_f_nav);

        $this->assign('u_f_nav',$u_f_nav);
        $this->assign('user',$this->user);
    }

    // 列表页
    public function index()
    {
        $param = $this->request->param();
        $month = $this->request->param('month',0,'intval');
        $type = $this->request->param('type',0,'intval');

        $param['userId'] = $this->user['id'];
        // vendor('topthink/think-helper/src/Time');
        // Time::today();
        $param['start_time'] = strtotime("-$month month");
        // $param['end_time'] = time();

        $fundsModel = new UserFundsLogModel();
        $list = $fundsModel->getLists($param);

        // 押金 需去除 -1,-3,-5,-6,-7
        // $deposit = $fundsModel->sumCoin($this->user['id'],'1,3,5,6,7');
        // $deposit2 = $fundsModel->sumCoin($this->user['id'],'-1,-3,-5,-6,-7');
        // 收入
        $income = $fundsModel->sumCoin($this->user['id'],'',$param['start_time'],'gt');
        // 支出
        $expense = $fundsModel->sumCoin($this->user['id'],'',$param['start_time'],'lt');
        // 类型
        // $categorys = $fundsModel->getTypes($type);

        // $this->assign('categorys', $categorys);
        $this->assign('income', $income);
        $this->assign('expense', $expense);
        $this->assign('type', $type);
        $this->assign('list', $list->items());
        $list->appends($param);
        $this->assign('pager', $list->render());

        return $this->fetch();
    }

    // 点券
    public function ticket()
    {
        // $param = $this->request->param();
        $where['user_id'] = $this->user['id'];

        $list = Db::name('user_ticket_log')->where($where)->paginate();

        $this->assign('list', $list);
        $this->assign('pager', $list->render());

        return $this->fetch();
    }

    // 充值
    public function recharge()
    {
        return $this->fetch();
    }

    public function rechargePost()
    {
        $data = $this->request->param();
        // dump($data);

        $valid = [
            'user_id'   => $this->user['id'],
            'coin'      => empty($data['r_money'])?null:$data['r_money'],
            'payment'   => empty($data['payment_way'])?null:$data['payment_way'],
            'type'      => 'recharge',
        ];

        // 验证
        $result = $this->validate($valid, 'Funds.recharge');
        if ($result!==true) {
            $this->error($result);
        }

        $post = [
            'paytype'  => $valid['payment'],
            'action'  => 'recharge',
            'coin'  => $valid['coin'],
        ];

        // 支付接口
        $this->redirect('funds/Pay/pay', $post);

    }

    // 提现
    public function withdraw()
    {
        return $this->fetch();
    }
    public function withdrawPost()
    {
        $data = $this->request->post();
        // dump($data);die;

        // 预处理数据
        $data['account'] = $data[$data['payment_way']]['account'];

        $post = [
            'user_id'   => $this->user['id'],
            'account'   => $data['account'],
            'username'  => $data['w_name'],
            'coin'      => $data['w_money'],
            'payment'   => $data['payment_way'],
            'create_time'=> time(),
        ];
        $post['coin'] = intval($post['coin']);

        $applyModel = new FundsApplyModel();
        $count = $applyModel->counts($this->user['id']);
        if ($count>=1) {
            $this->error('您有提现待处理的数据',url('user/Funds/apply'));
        }
        $count = $applyModel->counts($this->user['id'],'time');
        if ($count>=1) {
            $this->error('每天仅限一次，请明天再来');
        }

        bcscale(2);
        // 验证
        $result = $this->validate($post,'Funds.withdraw');
        if ($result!==true) {
            $this->error($result);
        }
        if (empty($data['w_pwd'])) {
            $this->error('请输入密码');
        }

        if (cmf_compare_password($data['w_pwd'],$this->user['paypwd'])===false) {
            $this->error('您的密码不对');
        }
        // 点券是无法提现的 $this->user['ticket']
        if ($post['coin']>$this->user['coin']) {
            $this->error('余额不足');
        }
        $remain = bcsub($this->user['coin'], $post['coin']);
        $freeze = bcadd($this->user['freeze'], $post['coin']);

        // 数据库操作
        Db::startTrans();
        $transStatus = true;
        try{
            // ->setInc('freeze',$post['coin'])
            Db::name('user')->where('id',$this->user['id'])->setDec('coin',$post['coin']);
            Db::name('user')->where('id',$this->user['id'])->setInc('freeze',$post['coin']);
            // Db::name('funds_apply')->insert($post);
            $result = Db::name('funds_apply')->insertGetId($post);
            // lothar_put_funds_log($this->user['id'], 9, -$post['coin'], $remain);
            $data = [
                'title'     => '提现申请',
                'user_id'   => $this->user['id'],
                'object'    => 'funds_apply:'.$result,
                'adminurl'  => 5,
            ];
            lothar_put_news($data);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $transStatus = false;
        }

        if (empty($transStatus)) {
            $this->error('提交失败了');
        } else {
            // $userNew   = Db::name('user')->where('id',$this->user['id'])->find();
            $this->user['coin'] = $remain;
            $this->user['freeze'] = $freeze;
            cmf_update_current_user($this->user);
            $this->success('提交成功',url('withdrawView',['id'=>$result]));
        }
    }
    public function withdrawView()
    {
        $id = $this->request->param('id',0,'intval');
        $apply = Db::name('funds_apply')->where('id',$id)->find();
        if (empty($apply)) {
            abort(404, ' 数据不存在!');
        }

        $this->assign('apply',$apply);

        return $this->fetch('withdraw_view');
    }
    public function withdrawReset()
    {
        $id = $this->request->param('id',0,'intval');
        if (empty($id)) {
            $this->error('数据非法！');
        } else {
            Db::nmae('funds_apply')->where('id',$id)->setField('status',0);
            $this->redirect('Funds/withdraw');
        }
    }
    public function withdrawCancel()
    {
        $id = $this->request->param('id',0,'intval');
        if (empty($id)) {
            $this->error('数据非法！');
        } else {
            $coin = Db::name('funds_apply')->where('id',$id)->value('coin');
            bcscale(2);
            $remain = bcadd($coin,$this->user['coin']);
            $freeze = bcsub($this->user['freeze'], $coin);
            // 更改数据
            Db::startTrans();
            $transStatus = true;
            try{
                // ->setDec('freeze',$coin)
                Db::name('user')->where('id',$this->user['id'])->setInc('coin',$coin);
                Db::name('user')->where('id',$this->user['id'])->setDec('freeze',$coin);
                Db::name('funds_apply')->where('id',$id)->setField('status',-2);
                // lothar_put_funds_log($this->user['id'], -9, $coin, $remain);
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                $transStatus = false;
            }

            if (empty($transStatus)) {
                $this->error('取消失败了');
            } else {
                $this->user['coin'] = $remain;
                $this->user['freeze'] = $freeze;
                cmf_update_current_user($this->user);
                $this->success('取消成功，钱款被退回',url('user/Funds/index',['type'=>-9]));
            }
        }
    }

    public function apply()
    {
        $where = ['user_id'=>$this->user['id'],'type'=>'withdraw'];
        $list = Db::name('funds_apply')->where($where)->order('id','DESC')->paginate(15);

        $this->assign('list', $list);
        $this->assign('pager', $list->render());

        return $this->fetch();
    }




    public function cancel()
    {
        return $this->fetch();
    }

    public function del()
    {
        parent::dels(Db::name('user_funds_log'));
        $this->success("刪除成功！", '');
    }

    public function more()
    {
        return $this->fetch();
    }
}