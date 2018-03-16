<?php
namespace app\user\controller;

// use app\user\model\UserModel;
use cmf\controller\UserBaseController;
use think\Db;

// use think\Validate;

/**
 * 个人中心 服务商城
 * 需要登录验证的
 */
class ShopController extends UserBaseController
{
    public function _initialize()
    {
        parent::_initialize();
        $u_f_nav = $this->request->action();
        // $this->user = cmf_get_current_user();

        $this->assign('u_f_nav', $u_f_nav);
    }

    // 我的订单
    public function index()
    {
        $os = $this->request->param('status');
        $userId = cmf_get_current_user_id();

        $where = [];
        if ($os !== null) {
            $where['status'] = $os;
        }
        // config('shop_order_status');
        $orders = Db::name('shop_order')->where(['delete_time'=>0,'buyer_uid'=>$userId])->select();

        $this->assign('orders', $orders);
        $this->assign('os', $os);
        return $this->fetch();
    }

    // 订单详情
    public function detail()
    {
        $id = $this->request->param('id/d');
        if (empty($id)) {
            $this->error('非法');
        }
        $order = Db::name('shop_order')->alias('a')
            ->field('a.*,b.address,b.username,b.telephone')
            ->join('shop_shipping_address b','a.address_id=b.id')
            ->where('a.id',$id)
            ->find();
        $order_list = Db::name('shop_order_detail')->where('order_id',$id)->select();
// dump($order);
// dump($order_list);
        // $order['status'] = 3;
        $this->assign('order',$order);
        $this->assign('list',$order_list);
        return $this->fetch();
    }
    // 取消订单
    public function cancel()
    {
        $id = $this->request->param('id/d');
        if (empty($id)) {
            $this->error('非法');
        }

        $this->success('取消成功');
    }


/*积分兑换*/
public function exchange()
{
    return $this->fetch();
}



/*订单处理*/
    // 确认收货
    public function receipt()
    {
        $id = $this->request->param('id/d', 0, 'intval');

        Db::name('shop_order')->where('id',$id)->setField('status',4);
        $this->success('确认成功');
    }

    // 评价
    public function evaluateList()
    {
        $userId = cmf_get_current_user_id();
        $list = Db::name('shop_evaluate')->where('user_id',$userId)->select();

        $this->assign('list',$list);
        return $this->fetch();
    }
    public function evaluate()
    {
        $id = $this->request->param('id/d', 0, 'intval');
        if (empty($id)) {
            $this->error('非法请求');
        }

        // 是否有订单号、确认收货
        $goods = model('shop/ShopGoods')->getPost($id);
        // 评价表
        // $evaluate = '';

        $this->assign('goods', $goods);
        // $this->assign('evaluate', $evaluate);
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
        $post['user_id']     = cmf_get_current_user_id();
        $post['create_time'] = time();
// dump($post);die;
        $result = Db::name('shop_evaluate')->insertGetId($post);
        if ($result > 0) {
            $this->success('评价成功', url('index', ['status' => null]));
        }
        $this->error('评价失败', url('index', ['status' => 3]));
    }

    // 物流信息
    public function logistics()
    {
        $id = $this->request->param('id/d');
        if (empty($id)) {
            $this->error('该订单不存在');
        }
        // 
        $logistics = [];
        $this->assign('logistics',$logistics);
        return $this->fetch();
    }

    // 退换货
    public function returns()
    {
        $id = $this->request->param('id/d',0,'intval');//订单的ID
        $userId = cmf_get_current_user_id();

        $where = [
            'refund_status' => 1,
            'buyer_uid' => $userId,
        ];
        if (!empty($id)) {
            $where['id'] = $id;
        }
        $list = Db::name('shop_order')->where($where)->select();

        $this->assign('list', $list);
        return $this->fetch();
    }
    // 退换货详情
    public function returns_detail()
    {
        $id = $this->request->param('id/d', 0, 'intval');//订单详情的ID

        $post = Db::name('shop_order')->where('id', $id)->find();

        $this->assign('post', $post);
        return $this->fetch();
    }
    public function returns_detailPost()
    {
        $data = $this->request->param();
        // $id = $this->request->param('id/d');
        $post = [
            'oid' => $id,
            'type'=>$data['type'],
            'reason'=>$data['reason'],
            'description'=>$data['description'],
            'amount'=>$data['amount'],
        ];

        if (!empty($data['photos'])) {
            $post['more'] = '';
        }

        Db::name('shop_returns')->insert($post);
        Db::name('shop_order')->where('id',$id)->setField('refund_status',1);
    }

    // 消息管理
    public function news()
    {
        $userId = cmf_get_current_user_id();

        $where = [
            'user_id' => $userId,
        ];
        $list = [];
        $this->assign('list',$list);
        return $this->fetch();
    }



/*收货地址管理*/
    public function address()
    {
        $userId = cmf_get_current_user_id();
        $list   = Db::name('shop_shipping_address')->where('user_id', $userId)->order('is_main DESC')->select();
// dump($list);die;
        $this->assign('list', $list);
        return $this->fetch();
    }

    public function addressEdit()
    {
        $id   = $this->request->param('id/d');
        $post = Db::name('shop_shipping_address')->where('id', $id)->find();
        if (empty($post)) {
            $this->error('数据不存在了');
        }
        $this->assign($post);
        return $this->fetch();
    }

    public function addressPost()
    {
        $data    = $this->request->param();
        $id      = $this->request->param('id/d', 0, 'intval');
        $is_main = $this->request->param('is_main/d', 0, 'intval');
        // 验证数据
        // dump($data);die;
        $addrSql = Db::name('shop_shipping_address');
        if ($is_main == 1) {
            $find = $addrSql->where('is_main', 1)->value('id');
        }

        $post = [
            'province_id' => '0',
            'city_id'     => '0',
            'area_id'     => '0',
            'address'     => $data['address'],
            'username'    => $data['username'],
            'telephone'   => $data['telephone'],
            'is_main'     => $is_main,
            'user_id'     => cmf_get_current_user_id(),
        ];

        Db::startTrans();
        try {
            if ($id > 0) {
                $addrSql->where('id', $id)->update($post);
            } else {
                $addrSql->insert($post);
            }
            if ($find > 0) {
                $addrSql->where('id', $find)->setField('is_main', 0);
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
        }

        $this->success('添加成功', url('address'));
    }

    public function addressDelete()
    {
        $id = $this->request->param('id/d');
        if (empty($id)) {
            $this->error('数据非法');
        }
        Db::name('shop_shipping_address')->where('id', $id)->delete();
        $this->success('删除成功');
    }
}
