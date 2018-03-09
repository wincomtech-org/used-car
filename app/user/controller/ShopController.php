<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
// use app\user\model\UserModel;
// use think\Validate;
use think\Db;

/**
* 个人中心 服务商城
*/
class ShopController extends UserBaseController
{
    // 我的订单
    public function index()
    {
        return $this->fetch();
    }
    // 订单详情
    public function detail()
    {
        return $this->fetch();
    }

    public function buy()
    {
        $data = $this->request->param();
        dump($data);
        $this->assign('paysign','shop');
        $this->assign('orderId','null');
        return $this->fetch();
    }
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
// dump($post);die;
        $result = Db::name('shop_evaluate')->insertGetId($post);
        if ($result==1) {
            $this->success('评价成功',url('index',['status'=>11]));
        }
        $this->error('评价失败',url('index',['status'=>10]));
    }

    // 物流信息
    public function logistics()
    {
        return $this->fetch();
    }

    // 退换货
    public function returns()
    {
        return $this->fetch();
    }
    // 退换货详情
    public function returns_detail()
    {
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
