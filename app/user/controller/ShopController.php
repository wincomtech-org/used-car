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

    // 立即购买
    public function buy()
    {
        $data = $this->request->param();
        dump($data);
        $this->assign('paysign','shop');
        $this->assign('orderId','null');
        return $this->fetch();
    }
    // 购物车结算
    public function buyCart()
    {
        $this->assign('paysign','shop');
        $this->assign('orderId','null');
        return $this->fetch('buy');
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

    // 下单页
    public function  buy_detail(){
        return $this->fetch();
    }
}
