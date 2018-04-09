<?php
namespace app\shop\controller;

use cmf\controller\UserBaseController;
use think\Db;

/**
 * 商品订单类
 * 需要登录的
 */
class OrderController extends UserBaseController
{
    // 下单页 立即购买
    public function buy()
    {
        $data = $this->request->param();
        if (empty($data)) {
            $this->redirect('Shop/Index/index');
        }
        // $data['user_id'] = cmf_get_current_user_id();

        $amount = bcmul($data['price'], $data['number']);
        // 附加项
        $this->buyop($amount);

        $this->assign('data', [$data]);
        $this->assign('amount', $amount);
        $this->assign('is_score', 0);
        $this->assign('flag', '元');
        return $this->fetch();
    }
    // 下单页 购物车结算
    public function buyCart()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param('cartol/a');
        } else {
            $this->redirect('shop/Cart/cartList');
        }

        // 做判断 购物车数据有变化
        // $carts = session('user_cart');
        // $a1 = array_column($data,'id');
        // $a2 = array_column($carts,'id');
        // $diff = array_diff($a2,$a1);

        $ids   = array_column($data, 'id');
        $carts = model('shop/ShopCart')->getCartList(['a.id' => ['in', $ids]]);

        // 更新变化的
        $map    = [];
        $amount = '0.00';
        foreach ($carts as $key => $row) {
            if ($data[$row['id']]['number'] != $row['number']) {
                $map[]                 = ['id' => $row['id'], 'number' => $data[$row['id']]['number']];
                $carts[$key]['number'] = $data[$row['id']]['number'];
                $amount                = bcadd($amount, bcmul($data[$row['id']]['number'], $row['price']));
            } else {
                $amount = bcadd($amount, bcmul($row['number'], $row['price']));
            }
        }
        if (!empty($map)) {
            model('shop/ShopCart')->saveAll($map);
        }

        // 附加项
        $this->buyop($amount);

        $this->assign('data', $carts);
        $this->assign('amount', $amount);
        $this->assign('is_score', 0);
        $this->assign('flag', '元');
        return $this->fetch('buy');
    }

    public function buyop($amount = 0, $is_score = 0)
    {
        $userId = cmf_get_current_user_id();
        // 防止重复
        session('timestamp', time());

        // 收货地址
        $address = Db::name('shop_shipping_address')->where('user_id', $userId)->order('is_main DESC')->select()->toArray();

        // 默认地址 省市区？
        $addrFirst = [];
        if (!empty($address)) {
            $addr      = $address[0];
            $addrFirst = [
                'id'   => $addr['id'],
                'addr' => $addr['address'] . ' ' . $addr['username'] . '收 ' . $addr['telephone'],
            ];
        }

        if (empty($is_score)) {
            // 优惠券
            $coupon        = Db::name('user_coupons_log')->field('id,coupon,reduce')->where(['status' => 0, 'user_id' => $userId, 'reduce' => ['elt', $amount]])->select();
            $usualSettings = cmf_get_option('usual_settings');
            $this->assign('coupon_switch', $usualSettings['coupon_switch']);
            $this->assign('coupon', $coupon);
        }

        $this->assign('addrFirst', $addrFirst);
        $this->assign('address', $address);
    }

    // 积分兑换 可用立即购买的 buy()
    public function buyScore()
    {
        // $this->error('暂未开放');

        $data = $this->request->param();
        if (empty($data)) {
            $this->redirect('Shop/Index/index');
        }
        // $data['user_id'] = cmf_get_current_user_id();
        // dump($data);die;

        $amount = bcmul($data['score'], $data['number']);
        // 附加项
        $this->buyop($amount);

        $this->assign('data', [$data]);
        $this->assign('amount', $amount);
        $this->assign('is_score', 1);
        $this->assign('flag', '积分');
        return $this->fetch('buy');

    }

    // PC端选地址
    public function pc_address()
    {
        $this->error('暂未开放');
        return $this->fetch();
    }
    //手机端选择地址页
    public function wap_address()
    {
        return $this->fetch();
    }

/*生成订单*/
    // 支付页
    public function pay()
    {
        // dump($GLOBALS);die;
        $orderId = $this->request->param('orderId');

        if (empty($orderId)) {
            // 防止非POST方式
            if (!$this->request->isPost()) {
                $this->redirect('shop/Index/index');
            }

            // 由积分兑换、立即购买、购物车结算发起
            $data = $this->request->param();
            // 防止重复提交
            if (empty($data)) {
                $this->redirect('shop/Index/index');
            }
            // if ($data['timestamp'] == session('timestamp')) {
            //     session('timestamp', null);
            // } else {
            //     $this->redirect('user/Shop/Index', ['status' => 0]);
            // }
            $userId = cmf_get_current_user_id();

            // 判断是否为购物车传过来的
            // 检查购物车里有没有 有则需要在提交订单成功后删除,没有就不用管
            $ids      = $data['ids'];
            $cart_ids = array_column($ids, 'cart_id');
            if (empty($cart_ids)) {
                $jumpurl = url('shop/Post/details', ['id' => $ids[0]['goods_id']]);
                if (empty($ids[0]['spec_id'])) {
                    $goods = Db::name('shop_goods')->field('id as goods_id,name as goods_name,thumbnail,price')->where('id', $ids[0]['goods_id'])->find();
                } else {
                    $goods = model('shop/ShopGoodsSpec')->getGoodsBySpec(['a.id' => $ids[0]['spec_id']]);
                }
            } else {
                $jumpurl = url('shop/Cart/cartList');
                $goods   = model('shop/ShopCart')->getCartList(['a.id' => ['in', $cart_ids]]);
            }
// dump($goods);
            // dump($data);
            // dump($cart_ids);
            // die;

            // shop_order ： id 或 order_sn 决定，索引 buyer_uid,seller_uid
            // shop_order_detail ： id 或 goods_id,spec_id 决定，索引 order_id
            $post = $data['order'];
            if (empty($post['address_id'])) {
                $this->error('请选择收货地址');
            }

            $amount = $post['order_amount'];

            // 满减优惠券 没有排除积分兑换的情况
            $coupId = isset($post['coupId']) ? intval($post['coupId']) : 0;
            if ($coupId > 0) {
                $coupon = Db::name('user_coupons_log')->field('id,coupon,reduce,user_id,status')->where('id', $coupId)->find();
                if (!empty($coupon)) {
                    $amount = (bccomp($coupon['reduce'], $amount) == -1) ? bcsub($amount, $coupon['coupon']) : $this->error('您的优惠券不符合满减', $jumpurl);
                }
            }
            // 是否为积分兑换
            $is_score = isset($post['is_score']) ? intval($post['is_score']) : 0;
            if ($is_score == 1) {
                $user = cmf_get_current_user();
                if (bccomp($user['score'], $amount) == -1) {
                    $this->error('你的积分不足', url('user/Funds/score'));
                } else {
                    $score         = bcsub($user['score'], $amount);
                    $user['score'] = $score;
                }
            }
// dump($post);
            // dump($coupon);
            // dump($amount);
            // dump($is_score);
            // die;
            $order_sn = cmf_get_order_sn('shop_');
            // 订单表
            $order = [
                'is_score'       => $post['is_score'],
                'buyer_uid'      => $userId,
                'address_id'     => $post['address_id'],
                // 'seller_uid'  => '',
                // 'seller_username'  => '',
                'order_sn'       => $order_sn,
                'nums'           => $post['nums'],
                'product_amount' => $post['order_amount'],
                'order_amount'   => $amount,
                'coupon_id'      => $coupId,
                // 'shipping_id'  => '',
                // 'shipping_fee'  => '',
                // 'description'  => '',//买家留言
                'ip'             => get_client_ip(),
                'create_time'    => $_SERVER['REQUEST_TIME'],
            ];
// dump($goods);
            // dump($order);
            // die;


            // 订单详情表
            $details = [];

            // 启动事务 回滚原则？
            $tranStatus = true;
            Db::startTrans();
            try {
                if ($is_score == 1) {
                    Db::name('user')->where('id', $userId)->setField('score', $score);
                    $log = [
                        'user_id'     => $userId,
                        'action'      => 'shop',
                        'score'       => -$amount,
                        'create_time' => time(),
                    ];
                    Db::name('user_score_log')->insert($log);
                    $order['pay_time'] = time();
                    $order['status']   = 2;
                }
                $orderId = Db::name('shop_order')->insertGetId($order);
                if (empty($cart_ids)) {
                    $details[0] = [
                        'order_id'   => $orderId,
                        'spec_id'    => (isset($goods['spec_id']) ? $goods['spec_id'] : 0),
                        'goods_id'   => $goods['goods_id'],
                        'goods_type' => '1',
                        'goods_name' => $goods['goods_name'],
                        'thumbnail'  => $goods['thumbnail'],
                        'number'     => $post['nums'],
                        'price'      => $goods['price'],
                    ];
                } else {
                    foreach ($goods as $val) {
                        $details[] = [
                            'order_id'   => $orderId,
                            'spec_id'    => (isset($val['spec_id']) ? $val['spec_id'] : 0),
                            'goods_id'   => $val['goods_id'],
                            'goods_name' => $val['goods_name'],
                            'thumbnail'  => $val['thumbnail'],
                            'number'     => $val['number'],
                            'price'      => $val['price'],
                        ];
                    }
                    Db::name('shop_cart')->where('id', 'in', $cart_ids)->delete();
                    session('user_cart', null);
                }
                Db::name('shop_order_detail')->insertAll($details);
                if (!empty($coupId)) {
                    Db::name('user_coupons_log')->where('id', $coupId)->setField('status', 1);
                }
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                $tranStatus = false;
            }

            // 不用try{}catch(){}，但是变量如何传入？
            // Db::transaction(function(){
            //     Db::name('shop_order')->insertGetId($order);
            //     Db::name('shop_order_detail')->insertAll($details);
            // });

            // die('END');
            if ($tranStatus == true) {
                if ($is_score == 1) {
                    cmf_update_current_user($user);
                    $this->success('积分扣除成功！', url('user/Shop/score'));
                }
            } else {
                if ($is_score == 1) {
                    $this->error('积分扣除失败');
                } else {
                    $this->error('数据错误，请检查');
                }
            }
        } else {
            $order = Db::name('shop_order')->field('order_sn,order_amount')->where('id', $orderId)->find();
            // $order_list = Db::name('shop_order_detail')->field('*')->where('order_id', $orderId)->select();
            // dump($order_list);
            // die;
        }

// dump($order);
        // dump($orderId);
        $this->assign('order', $order);
        $this->assign('paysign', 'shop');
        $this->assign('orderId', $orderId);
        // $this->assign('is_score', $is_score);//积分的话直接扣除跳转，无支付页

        return $this->fetch('pay');
    }

}
