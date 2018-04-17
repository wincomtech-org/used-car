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
/*        set_time_limit(6000);
        // $ml = 'shop/ShopGoods';
        $ml = 'usual/UsualCar';
        // $ml = 'portal/';

        $list = model($ml)->field('id,thumbnail,photos')->where('id','gt',2200)->where('id','elt',3000)->order('id ASC')->select()->toArray();
        // $list = model($ml)->field('id,thumbnail,photos')->where('id',620)->order('id ASC')->select()->toArray();
// dump($list);die;
        $style = config('thumbnail_size');
        error_log(date('Y-m-d H:i:s')."\r\n",3,'data/log.txt');
        foreach ($list as $data) {
            if (!empty($data['thumbnail'])) {
                lothar_thumb_make($data['thumbnail'],$style);
            }

            if (!empty($data['photos'])) {
                lothar_dealFiles2($data['photos'],$style);
            }
            error_log(date('Y-m-d H:i:s').'_'.$data['id']."\r\n",3,'data/log.txt');
        }

        echo "ok";
        die;*/
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

    /*
     * H5支付测试
     * &nonce_str=$nonce_str¬ify_url=$notify_url
     */
    public function h5()
    {
        $result = $this->get_h5();

        $wx_return = U('Pay/wxh5return',$order,true,true);
        if (empty($result)) {
            echo '<div style="text-align:center"><button type="button" disabled>未获得移动支付权限</button></div>';exit;
        } else {
            // $url = $result;//如果不写则返回到之前的页面
            $url = $result . '&redirect_url='. $wx_return;//这个是指定用户操作后返回的页面
            // echo '<a href="'. $url .'" class="box-flex btn-submit" type="button">微信支付</a>';exit;
            $this->assign('wxh5Url',$url);
            $this->display('Pay/wxh5');
        }
    }
    public function get_h5()
    { 
        $appid = 'wxbf52fa26bb0c274f';//微信给的  
        $mch_id = '1497891742';//微信官方的  
        $key = 'EDWIJIijffirerfeOWERFI88ERFFVevF';//自己设置的微信商家key
        $web_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];

        $out_trade_no     = 'wxh5_20180413'.rand(0,9999);//平台内部订单号  
        $nonce_str        = MD5($out_trade_no);//随机字符串  
        $body             = "公众号开通服务";//内容  
        $total_fee        = 1; //金额  
        $spbill_create_ip = get_client_ip(); //IP 
        $notify_url       = U('Home/Pay/wxh5notify','',true,true);
        $trade_type       = 'MWEB';
        $scene_info       = '{"h5_info":{"type":"Wap","wap_url":"'.$web_url.'","wap_name":"公众号开通服务"}}';
        $signA            = "appid=$appid&body=$body&mch_id=$mch_id&nonce_str=$nonce_str&notify_url=$notify_url&out_trade_no=$out_trade_no&scene_info=$scene_info&spbill_create_ip=$spbill_create_ip&total_fee=$total_fee&trade_type=$trade_type";  
        $strSignTmp       = $signA."&key=$key";
        $sign             = strtoupper(MD5($strSignTmp));
        $post_data        = "<xml>  
            <appid>$appid</appid>  
            <body>$body</body>  
            <mch_id>$mch_id</mch_id>  
            <nonce_str>$nonce_str</nonce_str>  
            <notify_url>$notify_url</notify_url>  
            <out_trade_no>$out_trade_no</out_trade_no>  
            <scene_info>$scene_info</scene_info>  
            <spbill_create_ip>$spbill_create_ip</spbill_create_ip>  
            <total_fee>$total_fee</total_fee>  
            <trade_type>$trade_type</trade_type>  
            <sign>$sign</sign>  
        </xml>";

        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        // echo "<pre>"; 
        // var_dump(htmlspecialchars($post_data));
        // die;

        $dataxml = $this->http_post($url,$post_data);//后台POST微信传参地址同时取得微信返回的参数,POST方法我写下面了
        // var_dump($dataxml);die;
        $objectxml = (array)simplexml_load_string($dataxml, 'SimpleXMLElement', LIBXML_NOCDATA); //将微信返回的XML 转换成数组
        if (empty($objectxml)) {
            return false;
        } else {
            return $objectxml['mweb_url'];
        }
    }

    public function http_post($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    /**
     * [sql description]
     * query()读;execute()写;
     * @return [type] [description]
     */
    public function sql()
    {
        // 执行
        $sql = "DROP TABLE IF EXISTS `cmf_admin_log`;";
        $sql2 = "CREATE TABLE `cmf_admin_log` (
          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
          `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '操作者ID',
          `app` varchar(15) NOT NULL DEFAULT '' COMMENT '记录类型，应用层',
          `action` varchar(50) NOT NULL DEFAULT '' COMMENT '动作',
          `table` varchar(100) NOT NULL DEFAULT '' COMMENT '对象所使用的表',
          `obj` varchar(150) NOT NULL DEFAULT '' COMMENT '对象数据',
          `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
          `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
          `ip` char(15) NOT NULL DEFAULT '' COMMENT '操作者IP',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员操作记录';";
        $sql3 = "INSERT INTO cmf_admin_log (app) VALUES ('shop'),('service'),('user');";
        $result = Db::execute($sql);
        $result2 = Db::execute($sql2);
        $result3 = Db::execute($sql3);
        dump($result);
        dump($result2);
        dump($result3);

        // 查询
        $sql = "SELECT * from `cmf_admin_log`";
        $result = Db::query($sql);
        dump($result);
    }
}
?>