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
        $Ord = Db::name($table);
        $sta = $Ord->where($where)->value('status');
        if ($sta == 1) {
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


    /*对应支付模块*/
    // 保险
    public function insurance($data)
    {
        $status = $data['status'];//1 or 10
        $status = $status==1?6:$status;
        $userId = cmf_get_current_user_id();
        $id = Db::name('insurance_order')->where('order_sn',$data['out_trade_no'])->value('id');

        Db::startTrans();
        $transStatus = true;
        try{
            if (empty($id)) {
                $post['more'] = json_encode(['payreturn'=>$data]);
                Db::name('insurance_order')->insertGetId($post);
            } else {
                Db::name('insurance_order')->where('id',$id)->setField('status',$status);
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $transStatus = false;
        }

        return $transStatus;
    }
    // 看车
    public function seecar($data)
    {

    }
    // 开店
    public function deposit($data)
    {
        $status = intval($data['status']);//1 or 10
        $status = $status==1?10:$status;
        $userId = cmf_get_current_user_id();
        $id = Db::name('funds_apply')->where('order_sn',$data['out_trade_no'])->value('id');

        Db::startTrans();
        $transStatus = true;
        try{
            if (empty($id)) {
                $post = [
                    'type'      => 'openshop',
                    'user_id'   => $userId,
                    'order_sn'  => $data['out_trade_no'],
                    'coin'      => $data['total_fee'],
                    'payment'   => $data['paytype'],
                    'create_time' => time(),
                    'status'    => $data['paytype'],
                    'more'      => json_encode(['payreturn'=>$data]),
                ];
                Db::name('funds_apply')->insertGetId($post);
            } else {
                Db::name('funds_apply')->where('id',$id)->setField('status',$status);
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $transStatus = false;
        }

        return $transStatus;
    }
    // 充值
    public function recharge($data)
    {
        $status = $data['status'];//1 or 10
        $status = $status==1?10:$status;
        $user = cmf_get_current_user();
        // $userId = cmf_get_current_user_id();
        $id = Db::name('funds_apply')->where('order_sn',$data['out_trade_no'])->value('id');

        bcscale(2);
        Db::startTrans();
        $transStatus = true;
        try{
            if (empty($id)) {
                $post = [
                    'type'      => 'openshop',
                    'user_id'   => $user['id'],
                    'order_sn'  => $data['out_trade_no'],
                    'coin'      => $data['total_fee'],
                    'payment'   => $data['paytype'],
                    'create_time' => time(),
                    'status'    => $data['paytype'],
                    'more'      => json_encode(['payreturn'=>$data]),
                ];
                Db::name('funds_apply')->insertGetId($post);
            } else {
                Db::name('funds_apply')->where('id',$id)->setField('status',$status);
            }
            $remain = bcadd($user['coin'],$data['total_fee']);
            Db::name('user')->where('id',$user['id'])->setInc('coin',$data['total_fee']);
            Db::name('user_funds_log')->insert([
                'type'      => 8,
                'user_id'   => $user['id'],
                'coin'      => $data['total_fee'],
                'remain'    => $remain,
                'create_time' => time(),
                'ip' => get_client_ip(),
            ]);
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
                }
            } elseif ($paytype='weixin') {
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
    * 获取支付类型
    * 标识，可判断表名
        action=insurance|seecar|openshop|recharge
    * 'funds/Pay/pay'
    */
    public function getTableByType($type='')
    {
        switch ($type) {
            case 'seecar':
                $table = 'trade_order';
                break;
            case 'openshop':
                $table = 'funds_apply';
                break;
            case 'recharge':
                $table = 'funds_apply';
                break;
            case 'insurance':
                $table = 'insurance_order';
                break;
            default:
                $table = $type;
                break;
        }

        return $table;
    }




}


