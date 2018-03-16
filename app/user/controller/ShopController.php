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

        $where = [];
        if ($os !== null) {
            $where['status'] = $os;
        }
        // config('shop_order_status');
        $orders = '';

        $this->assign('orders', $orders);
        $this->assign('os', $os);
        return $this->fetch();
    }
    // 订单详情
    public function detail()
    {
        return $this->fetch();
    }



/*订单处理*/
    // 确认收货
    public function receipt()
    {
        return $this->fetch();
    }

    // 评价
    public function evaluate()
    {
        $id = $this->request->param('id', 0, 'intval');
        if (empty($id)) {
            $this->error('非法请求');
        }

        // 是否有订单号、确认收货
        $goods = model('shop/ShopGoods')->getPost($id);
        // 评价表
        $evaluate = '';

        $this->assign('goods', $goods);
        $this->assign('evaluate', $evaluate);
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
        return $this->fetch();
    }

    // 退换货
    public function returns()
    {
        $list = Db::name('shop_order')->where('refund_status', 1)->select();

        $this->assign('list', $list);
        return $this->fetch();
    }
    // 退换货详情
    public function returns_detail()
    {
        $id = $this->request->param('id', 0, 'intval');

        $post = Db::name('shop_order')->where('id', $id)->find();

        $this->assign('post', $post);
        return $this->fetch();
    }

    // 消息管理
    public function news()
    {
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
