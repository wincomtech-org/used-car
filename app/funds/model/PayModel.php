<?php
namespace app\funds\model;

use think\Db;
use think\Model;
use think\Request;

/**
* paytype
*/
class PayModel extends Model
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    /*
    * 对应支付模块
        $data = [
            'paytype'=> 'cash',
            'action' => 'seecar',
            'coin'   => '0.01',
            'order_sn' => 'seecar_2017120253101898',
            'id'     => '5',
        ];
    */
    // 现金支付
    public function cash($data=[])
    {
        $action = $data['action'];
        $order_sn = empty($data['order_sn'])?'':$data['order_sn'];
        $coin = empty($data['coin'])?0:$data['coin'];
        $user = cmf_get_current_user();
        $user_coin = $user['coin'];

        // 检查是否已支付过
        if ($this->checkOrderStatus($order_sn)) {
            return -2;
        }
        bcscale(2);
        // 检查余额是否充足
        if (bccomp($user_coin, $coin) < 0) {
            return -1;
        }

        Db::startTrans();
        $transStatus = true;
        try{
            // 更改用户余额
            Db::name('user')->where(['id'=>$user['id']])->setDec('coin',$coin);
            // 按需选择
            $orz = [
                'out_trade_no'  => $order_sn,
                'total_fee'     => $coin,
            ];
            $s = $this->$action($orz,10,$data['paytype']);
            // return $s;//如果$s不为true？
            // 资金记录
            $remain = bcsub($user_coin, $coin);
            $log = [
                'user_id' => $user['id'],
                'type' => $this->getTypeByAction($action),
                'coin' => $coin,
                'remain' => $remain,
                'app' => '--',
            ];
            lothar_put_funds_log($log);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $transStatus = false;
        }

        if ($transStatus===true) {
            $user['coin'] = $remain;
            // return $user;
            cmf_update_current_user($user);
            // return 'coin';
        }
        return $transStatus;
    }

    /*
    * 以下两种情况：余额支付 和 在线支付
    * @param $data 第三方支付数据返回结果。  payreturn
    * @param $statusCode=0|1|10
    * @param $paytype
    * 余额
    * 支付宝
    * 微信
    */
    // 保险 payreturn
    public function insurance($data,$statusCode,$paytype)
    {
        $status = $statusCode==1?6:$status;
        // $userId = cmf_get_current_user_id();

        if ($paytype=='cash') {
            Db::name('insurance_order')->where('order_sn',$data['out_trade_no'])->setField('status',$status);
        } else {
            $id = Db::name('insurance_order')->where('order_sn',$data['out_trade_no'])->value('id');
            if (empty($id)) return 0;
            Db::startTrans();
            $transStatus = true;
            try{
                if (empty($id)) {
                    $post = [];
                    $post['more'] = json_encode(['payreturn'=>$data]);
                    Db::name('insurance_order')->insertGetId($post);
                } else {
                    Db::name('insurance_order')->where('id',$id)->setField('status',$status);
                }
                // lothar_put_news($log);
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                $transStatus = false;
            }
            return $transStatus;
        }
    }
    // 看车
    public function seecar($data,$statusCode,$paytype)
    {
        $status = $statusCode==10?1:$status;
        // $userId = cmf_get_current_user_id();
        $info = Db::name('trade_order')->field('id,car_id')->where('order_sn',$data['out_trade_no'])->find();

        if ($paytype=='cash') {
            Db::name('trade_order')->where('id',$info['id'])->setField('status',$status);
            Db::name('usual_car')->where('id',$info['car_id'])->setDec('inventory',1);
        } else {
            if (empty($info['id'])) return 0;
            Db::startTrans();
            $transStatus = true;
            try{
                Db::name('trade_order')->where('id',$info['id'])->setField('status',$status);
                Db::name('usual_car')->where('id',$info['car_id'])->setDec('inventory',1);//减库存
                // lothar_put_news($log);
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                $transStatus = false;
            }
            return $transStatus;
        }
    }
    // 开店 payreturn
    public function openshop($data,$statusCode,$paytype)
    {
        $status = $statusCode==1?10:$status;
        $userId = cmf_get_current_user_id();
        $id = Db::name('funds_apply')->where('order_sn',$data['out_trade_no'])->value('id');
        $newData = [
            'pay_time'  => time(),
            'status'    => $status
        ];
        $log = [
            'title'     => '开店申请',
            'object'    => 'funds_apply:'.$id,
            'content'   => '客户ID：'.$userId .'，支付方式：'.config('payment')[$paytype],
            'adminurl'  => 8,
        ];

        if ($paytype=='cash') {
            Db::name('funds_apply')->where('id',$id)->update($newData);
            lothar_put_news($log);
        } else {
            if (empty($id)) return 0;
            Db::startTrans();
            $transStatus = true;
            try{
                Db::name('funds_apply')->where('id',$id)->update($newData);
                // Db::name('funds_apply')->where('id',$id)->setField('status',$status);
                lothar_put_news($log);
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                $transStatus = false;
            }
            return $transStatus;
        }
    }
    // 充值 payreturn ，不存在余额充值
    public function recharge($data,$statusCode,$paytype)
    {
        if ($paytype=='cash') return false;
        $status = $statusCode==1?10:$status;
        $user = cmf_get_current_user();
        // $userId = cmf_get_current_user_id();
        $id = Db::name('funds_apply')->where('order_sn',$data['out_trade_no'])->value('id');
        $total_fee = $data['total_fee'];

        bcscale(2);
        Db::startTrans();
        $transStatus = true;
        try{
            if (empty($id)) {
                $post = [
                    'type'      => 'recharge',
                    'user_id'   => $user['id'],
                    'order_sn'  => $data['out_trade_no'],
                    'coin'      => $total_fee,
                    'payment'   => $paytype,
                    'create_time' => time(),
                    'pay_time'  => time(),
                    'status'    => $status,
                    'more'      => json_encode(['payreturn'=>$data]),
                ];
                Db::name('funds_apply')->insertGetId($post);
            } else {
                $newData = [
                    'pay_time'  => time(),
                    'status'    => $status
                ];
                Db::name('funds_apply')->where('id',$id)->update($newData);
            }
            $remain = bcadd($user['coin'],$total_fee);
            Db::name('user')->where('id',$user['id'])->setInc('coin',$total_fee);
            Db::name('user_funds_log')->insert([
                'type'      => 8,
                'user_id'   => $user['id'],
                'coin'      => $total_fee,
                'remain'    => $remain,
                'create_time' => time(),
                'ip' => get_client_ip(),
            ]);
            // lothar_put_news($log);
            $user['coin'] = $remain;
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            // throw $e;
            $transStatus = false;
        }

        if ($transStatus===true) {
            cmf_update_current_user($user);
        }
        return $transStatus;
    }



    /*
    * 生成订单
    * 获取一个随机且唯一的订单号； cmf_get_order_sn()
    * $table 不带前缀的表名
    */
    public function pay($data=[], $table='')
    {
        $Ord = Db::name($table);

        $Ord->insert($data);
        // $result = $Ord->insert($data,false,true);
    }

    /*
    * 查询订单状态
    * $table 不带前缀的表名
    * $where=['ordid',$ordid]
    */
    function checkOrderStatus($table='', $where=[])
    {
        if (empty($where)) {
            $where['order_sn'] = $table;
            $action = strstr($table,'_',true);
            $table = $this->getTableByAction($action);
        }
        $Ord = Db::name($table);
        $status = $Ord->where($where)->value('status');
        if ($status==$this->getStatusByAction($action) || $status==10) {
            return true;
        } else {
            return false;
        }
    }

    /*
    * 处理订单函数
    * 更新订单状态，写入订单支付后返回的数据
    * $data  待更新的数据
    * $table 不带前缀的表名
    */
    function orderHandle($data=[], $table='', $where=[])
    {
        $ordid = $parameter['out_trade_no'];

        // $data = $data;
        $data = [
            'trade_no'      => $data['trade_no'],
            'trade_status'  => $data['trade_status'],
            'notify_id'     => $data['notify_id'],
            'notify_time'   => $data['notify_time'],
            'buyer_email'   => $data['buyer_email'],
            'status'        => 1,
            // 'ordstatus'     => 1;
        ];

        $Ord = Db::name($table);
        $Ord->where('order_sn='.$ordid)->update($data);
        // $result = $Ord->where('order_sn='.$ordid)->update($data);
    }




    /*
    * 获取支付方式
    * 自动识别是否为电脑、手机端、扫码？
        paytype=cash|alipay|weixin
    */
    public function getPayment($paytype='', $pay_id='')
    {
        if (!empty($pay_id)) {
            $paytype = $pay_id;
        } elseif (!empty($paytype)) {
            if ($paytype=='alipay') {
                if (cmf_is_mobile()) {
                    $paytype = 'alipaywap';
                    // $paytype = 'alipay';//不是RSA
                }
            } elseif ($paytype=='weixin') {
                if (cmf_is_wechat()) {
                    $paytype = 'wxpayjs';
                } else {
                    $paytype = 'wxpaynative';
                }
            }
        }

        return $paytype;
    }

    /*
    * 获取表名
    * 标识，可判断表名
        action=insurance|seecar|openshop|recharge
    * 'funds/Pay/pay'
    */
    public function getTableByAction($action)
    {
        switch ($action) {
            case 'seecar':$table = 'trade_order';break;
            case 'openshop':$table = 'funds_apply';break;
            case 'recharge':$table = 'funds_apply';break;
            case 'insurance':$table = 'insurance_order';break;
            default:$table = $action;break;
        }
        return $table;
    }

    /*
    * 订单支付成功状态
    * 不包含 完成状态
    */
    public function getStatusByAction($action)
    {
        switch ($action) {
            case 'seecar':$status = 1;break;
            case 'openshop':$status = 10;break;
            case 'recharge':$status = 10;break;
            case 'insurance':$status = 6;break;
            default:$status = 1;break;
        }
        return $status;
    }

    /*获取类型*/
    public function getTypeByAction($action)
    {
        switch ($action) {
            case 'seecar':$type = 6;break;
            case 'openshop':$type = 5;break;
            case 'recharge':$type = 8;break;
            case 'insurance':$type = 2;break;
            default:$type = 0;break;
        }
        return $type;
    }

    /*
    * 支付成功时的跳转链接
    * $where=['id'=>$oId]
    */
    public function getJumpByAction($action,$where='')
    {
        switch ($action) {
            case 'seecar':$jumpurl = url('user/Buyer/index',$where);break;
            case 'openshop':$jumpurl = url('user/Funds/apply',$where);break;
            case 'recharge':$jumpurl = url('user/Funds/index',$where);break;
            case 'insurance':$jumpurl = url('user/Insurance/index',$where);break;
            default:$jumpurl = url('user/Funds/index');break;
        }
        return $jumpurl;
    }

    /*
    * 支付失败时的跳转链接
    * $where=['id'=>$oId]
    */
    public function getJumpErrByAction($action,$where='')
    {
        switch ($action) {
            case 'seecar':$jumpurl = url('trade/Index/index',$where);break;
            case 'openshop':$jumpurl = url('trade/Post/deposit',$where);break;
            case 'recharge':$jumpurl = url('user/Funds/recharge',$where);break;
            case 'insurance':$jumpurl = url('insurance/Index/index',$where);break;
            default:$jumpurl = url('user/Funds/index');break;
        }
        return $jumpurl;
    }




}


