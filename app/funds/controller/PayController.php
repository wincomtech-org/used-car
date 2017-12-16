<?php
namespace app\funds\controller;

use cmf\controller\HomeBaseController;
// use cmf\controller\UserBaseController;
use app\funds\model\PayModel;
use think\Db;
// use paymentOld\alipay\WorkPlugin;

use test\Test;

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

    public function test()
    {
        // dump(cmf_get_order_sn());die;
        $data = $this->request->param();

        // 对象有命名空间
        // $test = new Test();//通过use引入过的
        // $test = new \test\Test();//裸的
        // 对象没有命名空间
        import('test/Test',EXTEND_PATH);
        $test = new \Test('ok');
        $post = $test->out($data);
        dump($post);
        // $test->tp();
        dump($test->tp());



        // $work = new WorkPlugin();

        // $work = new \paymentOld\alipay\WorkPlugin();

        $paytype = 'alipay';
        import('paymentOld/alipay/WorkPlugin',EXTEND_PATH);
        $work = new \WorkPlugin(cmf_get_order_sn(),1);

        echo $work->workForm();

        // $work->workUrl();
        // $work->workCurl();

        // $work->log();
        // dump($work->log());




        
    }

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
        if (empty($data)) {
            $this->error('非法数据集');
        }

        // $this->success('支付中心 - 模拟支付',cmf_url('user/Funds/index'),$data,100);

        $this->$data['action']($data);
    }

    // 对应支付模块
    public function insurance($data)
    {
        $this->success('支付中心 - 模拟 保险 支付',cmf_url('user/Funds/index'),$data,100);
        $payModel = new PayModel();

        $payModel->pay();
    }
    public function seecar($data)
    {
        $this->success('支付中心 - 模拟 预约看车 支付',cmf_url('user/Funds/index'),$data,100);
        $payModel = new PayModel();

        $payModel->pay();
    }
    public function deposit($data)
    {
        $this->success('支付中心 - 模拟 店铺押金 支付',cmf_url('user/Funds/index'),$data,100);
        $payModel = new PayModel();

        $payModel->pay();
    }
    public function recharge($data)
    {
        $this->success('支付中心 - 模拟 充值 支付',cmf_url('user/Funds/index'),$data,100);
        $payModel = new PayModel();

        $payModel->pay();
    }



    // 支付方式
    public function payment($paytype='')
    {
        // $payModel = new PayModel();
        $work = new \paymentOld\alipay\WorkPlugin();

    }

    // 回调处理
    public function callBack()
    {
        // $payModel = new PayModel();
        $work = new \paymentOld\alipay\WorkPlugin();
        $method = $this->request->isGet() ? 'get' : ($this->request->isPost()?'post':'null');

        if ($this->request->isGet()) {
            $result = $work->getReturn();
        } elseif ($this->request->isPost()) {
            $result = $work->getNotify();
        } else {
            return false;
        }

        if (!empty($result)) {
            // if (!checkorderstatus($out_trade_no)) {
            //     orderhandle($parameter);
            //     //进行订单处理，并传送从支付宝返回的参数；
            // }
        }

    }



    // 事务处理
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