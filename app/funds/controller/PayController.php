<?php
namespace app\funds\controller;

use cmf\controller\HomeBaseController;
// use cmf\controller\UserBaseController;
use app\funds\model\PayModel;
use think\Db;

/**
* 支付中心
* 支付标识 pay_id：alipay支付宝 wxjs微信js  wxnative微信扫码
* 
*/
class PayController extends HomeBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }
        $type = $this->request->param('type');
        $action = $this->request->param('action');
        return "支付中心 - 支付类型：".$type.'，应用模块：'.$action.'。（接口预留）';
        return $this->fetch();
    }

    // 支付总入口
    public function pay()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }

        $data = $this->request->param();
        // if (!empty($data)) {
        //     dump($data);
        // }
        $this->success('支付中心 - 模拟支付',cmf_url('user/Funds/index'),$data,100);
    }

    // 
    public function payment()
    {
        $payModel = new PayModel();
    }

    public function trans()
    {
        bcscale(2);
        Db::startTrans();
        $transStatus = false;
        try{
            Db::name('trade_order')->where('id',$id)->setField('status',-2);
            Db::name('user')->where('id',$userId)->dec('coin',$bargain_money);
            Db::name('user')->where('id',$orderInfo['buyer_uid'])->setInc('coin', $bargain_money);
            Db::name('user_score_log')->insert([
                'user_id'     => $orderInfo['buyer_uid'],
                'create_time' => time(),
                'action'      => 'trade_sellerCancel',
                'coin'        => $bargain_money,
            ]);
            $transStatus = true;
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            // throw $e;
        }
        if ($transStatus===false) {
            $this->error('取消失败');
        }
         $this->success('成功');
    }
}