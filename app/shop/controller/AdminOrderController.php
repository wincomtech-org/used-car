<?php
namespace app\shop\controller;

use think\Db;
use cmf\controller\AdminBaseController;
use app\shop\model\ShopOrderModel;
use app\shop\model\ShopNewsModel;
use express\WorkPlugin;

/**
* 服务商城 独立模块
* 订单
*/
class AdminOrderController extends AdminBaseController
{
    public function index()
    {
        /*// OK
        $typeCom = 'rrs';
        $typeNu = '6080943656';
        // 异常
        $typeCom = 'zhongtong';
        $typeNu = '474184190064';
        $typeNu = '471791993640';
        // 异常
        $typeCom = 'yuantong';
        $typeNu = '888017949354264875';
        $typeNu = '888017061034034049';
        // 异常
        $typeCom = 'yunda';
        $typeNu = '3912633749099';
        // OK
        $typeCom = 'huitongkuaidi';
        $typeNu = '70523393645614';
        // OK
        $typeCom = 'youzhengguonei';
        $typeNu = '9891835741800';

        $express = new WorkPlugin($typeCom,$typeNu);
        $result = $express->workOrder();
        echo $result;die;*/


        $param = $this->request->param();

        $scModel = new ShopOrderModel;

        // $list = Db::name('shop_order')->paginate(10);
        $list = $scModel->getLists($param);
// dump($list->toArray());

        $this->assign('keyword',(isset($param['keyword'])?$param['keyword']:''));
        $this->assign('list',$list->items());
        $list->appends($param);
        $this->assign('pager',$list->render());
        return $this->fetch();
    }

    public function add()
    {
        $this->error('暂未开放');
        // 订单号自动生成
    }
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');

        $scModel = new ShopOrderModel();
        $join = [
            ['shop_shipping_address b','a.address_id=b.id','LEFT'],
            ['express c','a.shipping_id=c.id','LEFT'],
            ['shop_returns d','a.returns_id=d.id','LEFT'],
            ['user e','a.buyer_uid=e.id','LEFT'],
        ];
        $order = $scModel->alias('a')
            ->field('a.*,b.username,b.telephone,b.contact,b.address,c.name,c.code,d.amount re_amount,d.status re_status,d.more re_more,e.user_nickname,e.user_login,e.mobile')
            ->join($join)
            ->where('a.id', $id)
            ->find();
        $xd = [
            'user_nickname' => $order['user_nickname'],
            'user_login'    => $order['user_login'],
            'mobile'        => $order['mobile']
        ];
        $order['buyer_name'] = $scModel->getUsername($xd);

        // 详情数据
        $detail_list = Db::name('shop_order_detail')->alias('a')
            ->field('a.*,b.spec_vars')
            ->join('shop_goods_spec b','a.spec_id=b.id','LEFT')
            ->where('order_id', $id)
            ->select();

        // 物流
        $logistics = Db::name('shop_express')->field('id,name,code')->where('status',1)->order('list_order')->select();
        // 退换货
        $refundV = config('shop_refund_status');
        $returnsV = $scModel->getStatus($order['re_status'],'shop_returns_status');
        $statusV = $scModel->getStatus($order['status'],'shop_order_status');

// dump($detail_list);
// dump($logistics);
// die;

        $this->assign('order', $order);
        $this->assign('list', $detail_list);

        $this->assign('logistics', $logistics);
        $this->assign('refundV', $refundV);
        $this->assign('returnsV', $returnsV);
        $this->assign('statusV', $statusV);
        return $this->fetch();
    }

    public function editPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $post = $data['post'];

            // 验证
            // $result = $this->validate($post, 'Order');
            // if ($result !== true) {
            //     $this->error($result);
            // }
            $buyer_uid = intval($post['buyer_uid']);
            if (empty($buyer_uid)) {
                $this->error('用户数据丢失');
            }

            if ($post['status']==3) {
                $nModel = new ShopNewsModel();
                $wh = [
                    'to_uid'    => $buyer_uid,
                    'obj_type'  => 'order3',
                    'obj_id'    => $post['id'],
                ];
                $find = Db::name('shop_news')->where($wh)->count();
                if ($find==0) {
                    $news = [
                        'buyer_uid'  => $buyer_uid,
                        'obj_type'  => 'order3',
                        'obj_id'  => $post['id'],
                        'obj_name'  => '您的商品已发货。',
                    ];
                }
            } elseif ($post['status']==10) {
                // 完成返积分
                $fw = [
                    'user_id'   => $buyer_uid,
                    'action'    => 'shop_order',
                    'obj_id'    => $post['id']
                ];
                $find = Db::name('user_score_log')->where($fw)->count();
                if ($find==0) {
                    $order = Db::name('shop_order')->where('id',$post['id'])->value('order_amount');
                    $score = [
                        'user_id'     => $buyer_uid,
                        'action'      => 'shop_order',
                        'obj_id'      => $post['id'],
                        'score'       => $order,
                        'create_time' => time(),
                    ];
                    $user = [];
                    if ($order > 0) {
                        $user['score'] = ['exp', 'score+' . $order];
                    }
                    if ($order < 0) {
                        $user['score'] = ['exp', 'score-' . abs($order)];
                    }
                }
            }
// dump($find);
// dump($post);
// dump($news);
// die;

            $scModel = new ShopOrderModel();

            $transStatus = true;
            Db::startTrans();
            try {
                $scModel->editDataCom($post);
                if (!empty($news)) {
                    $nModel->addSN($news);
                }
                if (!empty($score)) {
                    Db::name('user_score_log')->insert($score);
                    Db::name('user')->where('id', $buyer_uid)->update($user);
                }
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                $transStatus = false;
            }
            
            if ($transStatus==true) {
                $this->success('保存成功！', url('index'));
            }
            $this->error('保存失败！');
        }
    }

    public function delete()
    {
        //查看有无关联
        $this->error("删除功能暂不开放");
        // $scModel = new ShopOrderModel();
        $m1        = Db::name('shop_order');
        $m2        = Db::name('recycleBin');

        $param     = $this->request->param();

        if (isset($param['id'])) {
            $id   = $this->request->param('id', 0, 'intval');
            $result = $m1->where('id',$id)->setField('delete_time',time());
            $log = [
                'object_id' => $id,
                'create_time'=>time(),
                'table_name'=>'shop_order',
                'name'=>''
            ];
            $m2->insert($log);
            $this->success("删除成功！", '');
        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $recycle = $m1->where(['id' => ['in', $ids]])->select();
            $result  = $m1->field('id,order_sn')->where(['id' => ['in', $ids]])->update(['delete_time' => time()]);
            if ($result) {
                foreach ($recycle as $value) {
                    $log[] = [
                        'object_id'   => $value['id'],
                        'create_time' => time(),
                        'table_name'  => 'shop_order',
                        'name'        => $value['order_sn'],
                    ];
                }
                $m2->insertAll($log);
                $this->success("删除成功！", '');
            }
        }
    }

    public function changeStatus()
    {

        $data = $this->request->param();

        $attrModel = new ShopOrderModel();

        if (isset($data['ids'])) {
            $ids = $this->request->param('ids/a');

            $attrModel->where(['id' => ['in', $ids]])->update([$data["type"] => $data["value"]]);

            $this->success("更新成功！");

        }
        $this->success("更新失败！");
    }

    public function listOrder()
    {
        parent::listOrders($this->m);
        $this->success("排序更新成功！", '');
    }

    
}