<?php
namespace app\funds\controller;

use cmf\controller\HomeBaseController;
// use cmf\controller\UserBaseController;
use think\Db;

use app\funds\model\PayModel;

// use paymentOld\alipay\WorkPlugin;
use paymentOld\wxpaynative\lib\WxPayConfig;

// use test\Test;
use test\Test2;

import('paymentOld/common/wxpay/coreFunc',EXTEND_PATH);

/**
* 测试专区
*/
class TestController extends HomeBaseController
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

    // 对支付的测试
    public function index()
    {
        // dump(cmf_get_order_sn());die;
        $data = $this->request->param();

        /*对方法体的测试*/
        // import('paymentOld/wxpayjs/WorkPlugin',EXTEND_PATH);
        // $work = new \WorkPlugin();
        // $work->work();
        // import('paymentOld/common/wxpay/coreFunc',EXTEND_PATH);//当WorkPlugin没有被实例化时
        // echo wxTest();
        // exit;


        /*对支付的测试*/
        $paymode = 'wxpaynative';$action = '';$amount=0.01;
        import('paymentOld/'.$paymode.'/WorkPlugin',EXTEND_PATH);
        $work = new \WorkPlugin(cmf_get_order_sn($action),$amount);

        $dump = $work->p_set();
        // $dump = $work->parameter();

        // 调起支付
        // $echo = $work->work(false);
        // $echo = $work->workForm(false);
        // $echo = $work->workUrl(false);
        // $echo = $work->workCurl();

        // $echo = $work->log();
        // $echo = $work->QRcode();


        // echo $echo;
        dump($dump);
        exit;
    }

    public function wxpay()
    {
        paylog();

        echo "string";
        die;
    }

    // 对Test类的测试
    public function test()
    {
        /*对类载入方式的测试*/
        // 对象有命名空间
        // $test = new Test('父类构造');//通过use引入过的
        // $test = new \test\Test();//裸的
        // 对象没有命名空间
        // import('test/Test',EXTEND_PATH);
        // $test = new \Test('ok');
        // $post = $test->out($data);
        // dump($post);
        // $test->cmf();
        // dump($test->cmf());

        $test2 = new Test2('子类构造');
        $result = $test2->index('test2');

        dump($result);
        exit;
    }
}
?>