<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
// use app\user\model\UserModel;
use app\shop\model\ShopGoodsModel;
use think\Db;
// use think\Validate;

/**
* 个人中心 服务商城
*/
class ShopController extends UserBaseController
{
    function _initialize()
    {
        parent::_initialize();
        $u_f_nav = $this->request->action();
        // $this->user = cmf_get_current_user();

        $this->assign('u_f_nav',$u_f_nav);
    }

    // 我的订单
    public function index()
    {
        $os = $this->request->param('status');

        $where = [];
        if ($os!==NULL) {
            $where['status'] = $os;
        }
        // config('shop_order_status');
        $orders = '';

        $this->assign('orders',$orders);
        $this->assign('os',$os);
        return $this->fetch();
    }
    // 订单详情
    public function detail()
    {
        return $this->fetch();
    }

    // 下单页 立即购买
    public function buy()
    {
        $data = $this->request->param();

        // 附加项
        $this->buyop();

        $this->assign('data',[$data]);
        return $this->fetch();
    }
    // 下单页 购物车结算
    public function buyCart()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param('cartol/a');
        } else {
            $this->redirect('shop/Order/cartList');
        }

        // 做判断 购物车数据有变化
        // $carts = session('user_cart');
        // $a1 = array_column($data,'id');
        // $a2 = array_column($carts,'id');
        // $diff = array_diff($a2,$a1);

        $ids = array_column($data,'id');
        $carts = model('shop/ShopCart')->getCartList(['a.id'=>['in',$ids]]);

        // 附加项
        $this->buyop();

        $this->assign('data',$carts);
        return $this->fetch('buy');
    }

    public function buyop()
    {
        $userId = cmf_get_current_user_id();
        // 收货地址
        $address = Db::name('shop_shipping_address')->where('user_id',$userId)->order('is_main DESC')->select()->toArray();

        // 默认地址 省市区？
        $addrFirst = [];
        if (!empty($address)) {
            $addr = $address[0];
            $addrFirst = [
                'id'    => $addr['id'],
                'addr'  => $addr['address'] .' '. $addr['username'] .'收 '. $addr['telephone'],
            ];
        }
        // 优惠券
        $coupon = Db::name('user_coupons_log')->where(['status'=>1,'user_id'=>$userId])->select();

        $this->assign('addrFirst',$addrFirst);
        $this->assign('address',$address);
        $this->assign('coupon',$coupon);
    }

    // 积分兑换
    public function score()
    {
        $data = $this->request->param();

        dump($data);
        
        // return $this->fetch();
    }

    // PC端选地址
    public function pc_address()
    {
        return '暂无';
    }
    //手机端选择地址页
    public function wap_address(){
        return $this->fetch();
    }

    // 支付页
    public function pay()
    {
        $data = $this->request->param();
dump($data);

        $this->assign('paysign','shop');
        $this->assign('orderId','null');

        return $this->fetch('pay');
    }




    // 确认收货
    public function receipt()
    {
        return $this->fetch();
    }

    // 评价
    public function evaluate()
    {
        $id = $this->request->param('id',0,'intval');
        if (empty($id)) {
            $this->error('非法请求');
        }

        // 是否有订单号、确认收货
        $goods = model('shop/ShopGoods')->getPost($id);
        // 评价表
        $evaluate = '';
        
        $this->assign('goods',$goods);
        $this->assign('evaluate',$evaluate);
        return $this->fetch();
    }
    public function evaluatePost()
    {
        $data = $this->request->param();
        $post = $data['eval'];
// dump($data);die;

        if (!empty($data['evaluate_image'])) {
            $post['evaluate_image'] = model('usual/Com')->dealFiles($data['evaluate_image']);
            $post['evaluate_image'] = json_encode($post['evaluate_image']);
        }
        $post['user_id'] = cmf_get_current_user_id();
        $post['create_time'] = time();
// dump($post);die;
        $result = Db::name('shop_evaluate')->insertGetId($post);
        if ($result>0) {
            $this->success('评价成功',url('index',['status'=>null]));
        }
        $this->error('评价失败',url('index',['status'=>3]));
    }

    // 物流信息
    public function logistics()
    {
        return $this->fetch();
    }



    // 退换货
    public function returns()
    {
        $list = Db::name('shop_order')->where('refund_status',1)->select();

        $this->assign('list',$list);
        return $this->fetch();
    }
    // 退换货详情
    public function returns_detail()
    {
        $id = $this->request->param('id',0,'intval');

        $post = Db::name('shop_order')->where('id',$id)->find();

        $this->assign('post',$post);
        return $this->fetch();
    }

    // 消息管理
    public function news()
    {
        return $this->fetch();
    }

    // 收货地址管理
    public function shipping_address()
    {
        return $this->fetch();
    }
}
