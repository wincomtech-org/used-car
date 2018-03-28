<?php
namespace app\user\controller;

// use app\user\model\UserModel;
use cmf\controller\UserBaseController;
use express\WorkPlugin;
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
        $os     = $this->request->param('status');
        $userId = cmf_get_current_user_id();

        $where = ['b.delete_time' => 0, 'b.buyer_uid' => $userId];
        // $where['refund_status'] = 0;
        if ($os !== null) {
            $where['b.status'] = $os;
        }
        // config('shop_order_status');
        $orders = Db::name('shop_order')->alias('b')
            ->field('id,order_name,order_desc,order_sn,coupon_id,nums,product_amount,order_amount,refund_status,status,create_time,ip')
            ->where($where)->order('id DESC')->paginate(8);
        $orderToArr = $orders->items();
        foreach ($orderToArr as $key => $row) {
            $orderToArr[$key]['det'] = Db::name('shop_order_detail')->alias('a')
                ->field('spec_id,a.goods_id,goods_type,goods_name,thumbnail,number,a.price,spec_vars')
                ->join('shop_goods_spec b','a.spec_id=b.id','LEFT')
                ->where('order_id',$row['id'])
                ->select()->toArray();
        }
// dump($orderToArr);die;

        $this->assign('orders', $orderToArr);
        $this->assign('pager', $orders->appends('status',$os)->render());
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
            ->field('a.*,b.address,b.username,b.telephone,c.name as ename,c.code')
            ->join([
                ['shop_shipping_address b', 'a.address_id=b.id', 'LEFT'],
                ['shop_express c', 'a.shipping_id=c.id', 'LEFT'],
            ])
            ->where('a.id', $id)
            ->find();
        if (empty($order)) {
            $this->error('数据出错');
        }
        $detail_list = Db::name('shop_order_detail')->alias('a')
            ->field('a.*,b.spec_vars')
            ->join('shop_goods_spec b','a.spec_id=b.id','LEFT')
            ->where('order_id', $id)
            ->select();

        // 物流信息
        $express = new WorkPlugin($order['code'],$order['tracking_no']);
        $logistics = $express->workOrder();

// dump($order);
// dump($detail_list);
// die;
        // $order['status'] = 3;

        $this->assign('order', $order);
        $this->assign('list', $detail_list);
        $this->assign('logistics', $logistics);
        return $this->fetch();
    }
    // 取消订单
    public function cancel()
    {
        $id = $this->request->param('id/d');
        if (empty($id)) {
            $this->error('非法');
        }
        Db::name('shop_order')->where('id', $id)->setField('status', -1);
        $this->success('取消成功');
    }
    // 删除订单
    public function delete()
    {
        $id = $this->request->param('id/d');
        if (empty($id)) {
            $this->error('非法');
        }
        $find = Db::name('shop_order')->field('id,order_sn')->where('id',$id)->find();
        $data = [
            'object_id'   => $find['id'],
            'create_time' => time(),
            'table_name'  => 'ShopOrder',
            'name'        => $find['order_sn']
        ];
        // $result = Db::name('shop_order')->where(['id' => $id])->update(['delete_time' => time()]);
        $result = Db::name('shop_order')->where('id', $id)->setField('delete_time', time());
        if ($result) {
            Db::name('recycleBin')->insert($data);
        }
        $this->success('删除成功！','');
    }

/*积分兑换*/
    public function score()
    {
        $userId = cmf_get_current_user_id();
        $where = ['buyer_uid'=>$userId];
        $list = Db::name('shop_order_score')->where($where)->select();

        $this->assign('list',$list);
        return $this->fetch();
    }
    public function scoreEdit()
    {
        // return $this->fetch();
    }

/*订单处理*/
    // 确认收货
    public function receipt()
    {
        $id = $this->request->param('id/d', 0, 'intval');
        // 检测状态

        Db::name('shop_order')->where('id', $id)->setField('status', 4);
        $this->success('确认成功');
    }

    // 评价
    public function evaluateList()
    {
        $userId = cmf_get_current_user_id();
        $list   = Db::name('shop_evaluate')->where('user_id', $userId)->select();

        $this->assign('list', $list);
        return $this->fetch();
    }
    public function evaluate()
    {
        $id = $this->request->param('id/d', 0, 'intval');//订单详情ID
        $eid = $this->request->param('eid/d', 0, 'intval');//商品评价ID
        if (empty($id)) {
            $this->error('非法请求');
        }

        $goods = Db::name('shop_order_detail')->alias('a')
            ->field('a.*,b.spec_vars')
            ->join('shop_goods_spec b','a.spec_id=b.id','LEFT')
            ->where('a.id', $id)
            ->find();
// dump($goods);die;
        // 是否有订单号、确认收货
        $find = Db::name('shop_order')->where('id',$goods['order_id'])->value('status');
        if ($find<4) {
            $this->error('请确认收货,再来评价');
        }

        // 评价内容 评价表
        $evaluate['star'] = 1;
        if (!empty($eid)) {
            $evaluate = Db::name('shop_evaluate')->where('id',$eid)->find();
            $evaluate['evaluate_image'] = json_decode($evaluate['evaluate_image'],true);
            // dump($evaluate);die;
        }

        $this->assign('goods', $goods);
        $this->assign('evaluate', $evaluate);
        return $this->fetch();
    }
    public function evaluatePost()
    {
        $data = $this->request->param();
        $post = $data['eval'];
// dump($data);die;
        // 数据验证 validate()
        if (!empty($data['evaluate_image'])) {
            $post['evaluate_image'] = lothar_dealFiles($data['evaluate_image']);
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
        $this->assign('logistics', $logistics);
        return $this->fetch();
    }

    // 退换货
    public function returns()
    {
        // $id     = $this->request->param('id/d', 0, 'intval'); //订单的ID
        $userId = cmf_get_current_user_id();

        $where = [
            'user_id'     => $userId,
        ];

        $list = Db::name('shop_returns')->alias('a')
            ->field('*')
            ->join('shop_order_detail b','a.detail_id=b.id')
            ->where($where)
            ->select();

        $this->assign('list', $list);
        return $this->fetch();
    }
    // 退换货详情
    public function returns_detail()
    {
        $id = $this->request->param('id/d', 0, 'intval'); //订单详情的ID
        $rid = $this->request->param('rid/d');// 申请退款的ID

        $returns = [
            'type'    => '',
            'reason'  => '',
            'amount'  => '',
        ];
        if (!empty($rid)) {
            $returns = Db::name('shop_returns')->where('id',$rid)->find();
            $id = isset($returns['detail_id'])?$returns['detail_id']:0;
        }
        
        $post = Db::name('shop_order_detail')->alias('a')
            ->field('a.*,b.spec_vars')
            ->join('shop_goods_spec b', 'a.spec_id=b.id', 'LEFT')
            ->where('a.id', $id)->find();

        // 合并处理？？
        // $post = Db::name('shop_returns')->alias('a')
        //     ->field('a.*,b.*,c.spec_vars')
        //     ->join('shop_order_detail b', 'a.detail_id=b.id')
        //     ->join('shop_goods_spec c', 'a.spec_id=c.id', 'LEFT')
        //     ->where('c.id', $id)->find();
// dump($post);
//         die;

        $this->assign('post', $post);
        $this->assign('returns', $returns);
        return $this->fetch();
    }
    public function returns_detailEdit()
    {
        // return $this->fetch('returns_detail');
    }
    public function returns_detailPost()
    {
        $data = $this->request->param();
        $rid = $this->request->param('rid/d');// 申请退款的ID
        $userId = cmf_get_current_user_id();

        // 数据验证 validate()
        $post = [
            'user_id'     => $userId,
            'detail_id'   => $data['id'],
            'type'        => $data['type'],
            'reason'      => $data['reason'],
            'description' => $data['description'],
            'amount'      => $data['amount'],
        ];

        if (!empty($data['photos'])) {
            $post['more'] = lothar_dealFiles($data['photos']);
        }
// dump($data);
// dump($post);
// die;
        $transStatus = true;
        Db::startTrans();
        try{
            if (empty($rid)) {
                Db::name('shop_returns')->insert($post);
            } else {
                Db::name('shop_returns')->where('id',$rid)->update($post);
            }
            Db::name('shop_order')->where('id', $data['order_id'])->setField('refund_status', 1);
            Db::commit();
        } catch(\Exception $e) {
            Db::rollback();
            $transStatus = false;
        }
        if ($transStatus===true) {
            $this->success('提交成功');
        }
        $this->error('提交失败');
    }

    // 消息管理
    public function news()
    {
        $userId = cmf_get_current_user_id();

        $where = [
            'to_uid' => $userId,
        ];
        $field = 'id,from_uid,to_uid,obj_type,obj_id,obj_name,obj_thumb,create_time,ip,status';
        $list = Db::name('shop_news')->where($where)->select();

        $this->assign('list', $list);
        return $this->fetch();
    }
    public function newsDel()
    {
        $id = $this->request->param('id');
        if (empty($id)) {
            $this->error('数据非法');
        }
        $result = Db::name('shop_news')->where('id',$id)->delete();
        if (empty($result)) {
            $this->error('删除失败');
        }
        $this->success('删除成功');
    }

/*收货地址管理*/
    public function address()
    {
        $userId = cmf_get_current_user_id();
        $list   = Db::name('shop_shipping_address')->where('user_id', $userId)->order('is_main DESC')->select();
// dump($list);
// die;
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

        // 数据验证 validate()
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
