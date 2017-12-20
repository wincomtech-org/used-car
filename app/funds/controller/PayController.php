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
    function _initialize()
    {
        parent::_initialize();
        // $this->work = new WorkPlugin(cmf_get_order_sn(),0.01);//使用了use引入
        // $this->work = new \paymentOld\alipay\WorkPlugin(cmf_get_order_sn(),0.01);//直接使用命名空间实例化
        // $paytype = 'alipay';$table = '';
        // import('paymentOld/'.$paytype.'/WorkPlugin',EXTEND_PATH);
        // $this->work = new \WorkPlugin(cmf_get_order_sn($table),0.01);//import引入
    }

    // 临时测试
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


        $paytype = 'alipay';$action = '';$amount=0.01;
        import('paymentOld/'.$paytype.'/WorkPlugin',EXTEND_PATH);
        $work = new \WorkPlugin(cmf_get_order_sn($action),$amount);

        // $dump = $work->p_set();
        $dump = $work->parameter();

        // 调起支付
        $echo = $work->workForm(false);
        // $echo = $work->workUrl(false);
        // $echo = $work->workCurl();

        // $echo = $work->log();


        // echo $echo;
        // dump($dump);
        exit;
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



    /*
    * 支付总入口
    * 发起支付
    * @param $data 获取数据
        $data = [
            'paytype'=> 'cash',
            'action' => 'seecar',
            'coin'   => '0.01',
            'order_sn' => 'seecar_2017120253101898',
            'id'     => '5',
        ];
        自动识别是否为电脑、手机端、扫码？
            paytype=cash|alipay|weixin
        标识，可判断表名
            action=insurance|seecar|openshop|recharge
        价格
            coin=(number)
        完成未付款的订单
            order_sn=out_trade_no(string,30),id=(int)
    */
    public function pay()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }

        $data = $this->request->param();
        if (empty($data)) {
            $this->error('非法数据集');
        }
        $action = $data['action'];

        if (!empty($openPay)) {
            /*未开放 展示*/
            $expression = ['insurance'=>'','seecar'=>'预约看车','openshop'=>'开店押金','recharge'=>'充值'];
            $this->success('支付中心 - 模拟 '.$expression[$action].' 支付',cmf_url('user/Funds/index'),$data,600);
            // $this->$action($data);
            exit;
        } else {
            /*开放后 正式运营*/
            $payModel = new PayModel();
            $paytype = $payModel->getPayment($data['paytype']);
            // $table = $payModel->getTableByAction($action);

            // 余额支付与在线支付
            if ($paytype=='cash') {
                // 发起余额支付
                $status = $payModel->cash($data);
                // dump($status);die;
                if ($status===true) {
                    $this->success('支付成功');
                    $this->success('恭喜！支付成功，页面跳转中……',$payModel->getJumpByAction($action),'',5);
                }
                if ($status==-1) {
                    $msg = '您的余额不足';
                } elseif ($status==-2) {
                    $msg = '请勿重复支付';
                } elseif ($status===false) {
                    $msg = '支付失败';
                }
                $this->error($msg);
            } else {
                // 发起在线支付
                $order_sn = empty($data['order_sn'])?cmf_get_order_sn($action.'_'):$data['order_sn'];
                $amount = $data['coin'];
                $amount = 0.01;
                import('paymentOld/'.$paytype.'/WorkPlugin',EXTEND_PATH);
                $work = new \WorkPlugin($order_sn,$amount);

                // $work->workForm();
                echo $work->workUrl();
                // $work->workCurl();
            }
        }
    }

    /*现金支付*/

    /*回调处理 支付宝*/
    public function callBack()
    {
        // 前置处理
        $method = $this->request->isGet() ? 'get' : ($this->request->isPost()?'post':'null');
        $jumpurl = url('user/Profile/center');

        // 实例化
        $payModel = new PayModel();
        $paytype = $payModel->getPayment('alipay');
        import('paymentOld/'.$paytype.'/WorkPlugin',EXTEND_PATH);
        $work = new \WorkPlugin();

        // 获取数据
        // if (!empty($_GET['out_trade_no'])) {
        //     $this->error('数据过期',url('user/Funds/index'));
        // }
        if ($method=='get') {
            $orz = $work->getReturn();
            // if (empty($orz)) $orz = $_GET;
            // else $orz = false;
        } elseif ($method=='post') {
            $orz = $work->getNotify();
        } else {
            $orz = false;
        }
        /*// 测试的
        $data = $this->request->param();
        $orz = [
            'status'        => 10,
            'out_trade_no'  => empty($data['order_sn'])?'':$data['order_sn'],
            'total_fee'     => $data['coin'],
        ];*/
// dump($orz);die;

        // 处理数据
        if (!empty($orz)) {
            $trade_status = $orz['trade_status'];//交易状态
            if($trade_status=='TRADE_FINISHED') {
                $statusCode = 10;//支付完成
            } elseif ($trade_status=='TRADE_SUCCESS') {
                $statusCode = 1;;//支付成功
            } else {
                $statusCode = 0;//支付失败
            }
            $out_trade_no = $orz['out_trade_no'];
            if (!empty($out_trade_no)) {
                $action = strstr($out_trade_no,'_',true);
                $jumpok = $payModel->getJumpByAction($action);
                $jumperr = $payModel->getJumpErrByAction($action);
                // 检查是否已支付过
                if ($payModel->checkOrderStatus($out_trade_no)) {
                    if ($method=='get') $this->error('请勿重复支付',$jumpok);
                    else return false;
                }
            } else {
                $this->error('注意：订单号丢失',$jumpurl);
            }
            // 按需选择
            // $action = 'openshop';//方便测试
            // dump($action);die;
            $status = $payModel->$action($orz,$statusCode,'alipay');
        } else {
            $this->error('数据获取失败',$jumpurl);
        }

        // 处理结果
        if ($method=='get') {
            echo "<br>以下是支付宝返回的数据：<br><hr>";
            dump($orz);
        }
// sleep(600);
        if ($status===true) {
            $this->success('恭喜！支付成功，页面跳转中……',$jumpok,'',30);
        }
        if ($status==0) {
            $msg = '该订单不存在';
        } elseif ($status===false) {
            $msg = '支付失败';
        } else {
            $msg = '意外~';
        }
        $this->error($msg,$jumperr);
    }

    /*
    * 微信扫码支付
    * 订单轮询
    * 微信回调 二次查单
    */
    public function ajaxWxpay()
    {
        echo 'ok';exit;
    }


    public function more()
    {
        // 支付宝 return返回结果
        array(
          'buyer_email' => '915273691@qq.com',
          'buyer_id' => '2088702363744512',
          'exterface' => 'create_direct_pay_by_user',
          'is_success' => 'T',
          'notify_id' => 'RqPnCoPT3K9%2Fvwbh3Ih30BdyClsK2NofpZAPy6W5XmUvRI%2Fu0BnH8fTq3xZAp3MOiGOJ',
          'notify_time' => '2017-12-18 14:05:23',
          'notify_type' => 'trade_status_sync',
          'out_trade_no' => '2017121857515310',
          'payment_type' => '1',
          'seller_email' => 'lvshi908@163.com',
          'seller_id' => '2088621675273401',
          'subject' => 'Order Sn : 2017121857515310 (大通车服)',
          'total_fee' => '0.01',
          'trade_no' => '2017121821001004510236530042',
          'trade_status' => 'TRADE_SUCCESS',
          'sign' => 'c3686956f8cfeaf2508798649f66d74a',
          'sign_type' => 'MD5',
        );
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