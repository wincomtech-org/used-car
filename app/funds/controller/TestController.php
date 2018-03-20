<?php
namespace app\funds\controller;

use cmf\controller\HomeBaseController;
// use cmf\controller\UserBaseController;
use think\Db;

use app\funds\model\PayModel;

// use paymentOld\alipay\WorkPlugin;
// use paymentOld\wxpaynative\lib\WxPayConfig;

use test\Test;
use test\Test1;
use test\Test2;//Test2继承Test时？
use test\Test3;//Test.php、Test3.php中都有时？

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

    public function file()
    {
        set_time_limit(6000);
        // $ml = 'shop/ShopGoods';
        $ml = 'usual/UsualCar';
        // $ml = 'portal/';

        $list = model($ml)->field('id,thumbnail,photos')->where('id','gt',1486)->where('id','elt',1700)->order('id ASC')->select()->toArray();
        // $list = model($ml)->field('id,thumbnail,photos')->where('id',620)->order('id ASC')->select()->toArray();
// dump($list);die;
        $style = config('thumbnail_size');

        foreach ($list as $k=> $data) {
            if (!empty($data['thumbnail'])) {
                lothar_thumb_make($data['thumbnail'],$style);
            }

            if (!empty($data['photos'])) {
                lothar_dealFiles2($data['photos'],$style);
            }
            error_log(date('Y-m-d H:i:s').'_'.$data['id']."\r\n",3,'data/log.txt');
        }

        echo "ok";
        die;
    }



    public function file2()
    {
        set_time_limit(1200);
        // $ml = 'shop/ShopGoods';
        $ml = 'usual/UsualCar';
        // $ml = 'portal/';

        // $list = model($ml)->field('id,thumbnail,more')->where('id','gt',0)->where('id','elt',1000)->select()->toArray();
        // $list = model($ml)->field('id,thumbnail,more')->where('id','gt',1000)->where('id','elt',2000)->select()->toArray();
        // $list = model($ml)->field('id,thumbnail,more')->where('id','gt',2000)->where('id','elt',2750)->select()->toArray();
        // $list = model($ml)->field('id,more')->where(['id'=>['gt',2000]])->where(['id'=>['elt',3000]])->select()->toArray();

        $list = model($ml)->field('id,thumbnail,photos,files')->where('id','gt',450)->where('id','elt',520)->select()->toArray();
        // $list = model($ml)->field('id,more')->where('id','gt',0)->where('id','elt',1000)->select()->toArray();
        // dump($list);
        // die;

        $style = config('thumbnail_size');
        $fdd = [];
        foreach ($list as $k=> $data) {

            // dump($data);die;
            // if (!empty($data['more']['thumbnail'])) {
            if (!empty($data['thumbnail'])) {
                // $map['thumbnail'] = $data['more']['thumbnail'];
                // // dump($map);die;
                // unset($data['more']['thumbnail']);
// echo "thumbnail";die;
                $thumbnail = cmf_asset_relative_url($data['thumbnail']);
                // $fdd['thumbnail'] = 
                lothar_thumb_make($thumbnail,$style);
            }

            // if (!empty($data['more']['photos'])) {
            if (!empty($data['photos'])) {
                // $map['photos'] = $data['more']['photos'];
                // // echo "photo";
                // // dump($map);die;
                // unset($data['more']['photos']);
// echo "photo";die;
                // $fdd['photos'] = 
                lothar_dealFiles2($data['photos'],$style);
            }

            if (!empty($data['more']['files'])) {
                // $map['files'] = $data['more']['files'];
                // // echo "file";
                // // dump($map);die;
                // unset($data['more']['files']);
            }

            // unset($data['more']['thumbnail'],$data['more']['photos'],$data['more']['files']);
            // $map['more'] = $data['more'];
            // $map['id'] = $data['id'];
            // $post[] = $map;
            
            // $deal[] = $fdd;
        }

        // dump($post);die;
        // $res=model($ml)->save($map,['id'=>$data['id']]);
        // $res = model($ml)->saveAll($post);
        // dump($res);
        
        // dump($deal);
        echo "ok";
        die;




        // $files = [
        //     'names'=>['a','b'],
        //     'urls'=>['usual/a.jpg','usual/b.jpg']
        // ];
        // lothar_dealFiles();

        // $url = lothar_thumb_make();
        // dump($url);
    }

    // 对Test类的测试
    public function test()
    {
        $data = $this->request->param();

        new Test();//空类，只是与文件名一致，不用则报错。
        /*对类载入方式的测试*/
        // 对象有命名空间
        $test = new Test1('父类构造');//通过use引入过的
        // $test = new \test\Test();//裸的
        // 对象没有命名空间
        // import('test/Test',EXTEND_PATH);
        // $test = new \Test('ok');

        // $result = $test->var;
        // $result = $test->out($data);
        // $result = $test->cmf();

        $test2 = new Test2('子类构造');
        $result = $test2->index();

        $test3 = new Test3();
        // $test3 = new test\Test\Test3();
        // $result = $test3->index();
        // $result = $test3->fromTest();

        dump($result);
        exit;
    }

    // 对支付的测试
    public function pay()
    {
        # code...
    }
    public function payOld()
    {
        // dump(cmf_get_order_sn());die;
        $data = $this->request->param();

        /*对方法体的测试*/
        // 加载公用方法
        // import('payment/common/wxpay/custom/coreFunc',EXTEND_PATH);//当WorkPlugin没有被实例化时
        // echo wxTest();
        // exit;
        // 加载工作类
        // import('paymentOld/wxpayjs/WorkPlugin',EXTEND_PATH);
        // $work = new \WorkPlugin();
        // $result = $work->work();
        // dump($result);die;


        /*对支付的测试*/
        $paymode = 'wxpaynative';// alipay,alipaywap,wxpayjs,wxpaynative
        $action = '';$amount=0.01;
        import('paymentOld/'.$paymode.'/WorkPlugin',EXTEND_PATH);
        $work = new \WorkPlugin(cmf_get_order_sn($action),$amount);

        // $dump = $work->p_set();
        // $dump = $work->parameter();

        // 调起支付
        $result = $work->work(false);
        // $result = $work->workForm(false);
        // $result = $work->workUrl(false);
        // $result = $work->workCurl();

        // $result = $work->log();
        // $result = $work->QRcode();


        // echo $result;
        dump($result);
        exit;
    }

    public function wxpay()
    {
        $paymode = 'wxpaynative';// alipay,alipaywap,wxpayjs,wxpaynative
        $action = '';$amount=0.01;
        import('payment/wxpaynative/WorkPlugin',EXTEND_PATH);

        $work = new \WorkPlugin(cmf_get_order_sn($action),$amount);
        $result = $work->work(false);

        // paylog('微信支付日志：');

        // echo $result;
        dump($result);
        exit;
    }
}
?>