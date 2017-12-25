<?php
namespace app\user\controller;

use app\user\controller\TradeController;
// use app\trade\model\TradeOrderModel;
// use think\Validate;
use think\Db;

/**
* 个人中心 保险
*/
class BuyerController extends TradeController
{
    // 买家订单列表页
    public function index()
    {
        $param = $this->request->param();
        $id = $this->request->param('id/d');
        $userId = cmf_get_current_user_id();

        $extra['a.buyer_uid'] = $userId;
        if (!empty($id)) {
            $extra['a.id'] = $id;
        }

        $list = model('trade/TradeOrder')->getLists($param,'','',$extra);

        $this->assign('list', $list->items());// 获取查询数据并赋到模板
        // $list->appends($param);//添加分页URL参数
        $this->assign('pager', $list->render());// 获取分页代码并赋到模板
        return $this->fetch();
    }

    // 支付 剩余金额 product_amount ，总价order_amount，预约价bargain_money
    public function pay()
    {
        $this->error('暂未开放……');
        // 前置数据
        $orderId = $this->request->param('id/d');
        if (empty($orderId)) {
            $this->error('订单非法 或 已失效，请联系管理员');
        }
        $order = Db::name('trade_order')->field('order_sn,product_amount,pay_id')->where('id',$orderId)->find();
        $paytype = $order['pay_id'];
        if (empty($paytype)) {
            $this->error('支付方式缺失，请联系管理员');
        }
        $map = [
            'paytype'   => $paytype,
            'action'    => 'seecar',
            'order_sn'  => $order['order_sn'],
            'coin'      => $order['product_amount'],
            // 'id'        => $orderId,
        ];

        // 判断是否二次支付：支付剩余金额
        // 转向支付接口
        $this->success('前往支付中心……',cmf_url('funds/Pay/pay',$map));

    }

    public function cancel()
    {
        $id = $this->request->param('id/d');
        $user = cmf_get_current_user();

        // $order = model('trade/TradeOrder')->getPost($id);
        $order = Db::name('trade_order')->field('bargain_money,product_amount')->where('id',$id)->find();

        bcscale(2);
        $refunds = 0;
        if (bccomp($order['bargain_money'],0) == 1) {
            $refunds = $order['bargain_money'];
        }
        if (bccomp($order['product_amount'], 0) == 1) {
            $refunds = bcadd($refunds,$order['product_amount']);
        }

        // 启动事务
        $transStatus = true;
        Db::startTrans();
        try{
            Db::name('trade_order')->where('id',$id)->setField('status',-1);
            Db::name('user')->where('id',$user['id'])->setInc('coin',$refunds);
            $user['coin'] = bcadd($user['coin'], $refunds);
            lothar_put_funds_log($user['id'],-6,$refunds,$user['coin'],'user');
            Db::commit();
        } catch(\Exception $e) {
            Db::rollback();
            $transStatus = false;
        }

        if ($transStatus === false) {
            $this->error('取消失败！');
        }
        cmf_update_current_user($user);
        $this->success('取消成功');
    }
}