<?php
namespace app\trade\controller;

use cmf\controller\AdminBaseController;
// use app\usual\model\TradeOrderModel;
use think\Db;
// use think\Config;

/**
* 公司企业模块
*/
class AdminOrderController extends AdminBaseController
{
    /*function _initialize()
    {
        // parent::_initialize();
        // dump(config('database.database'));
        // dump(config('app_status'));
        // dump(config('trade_order_status'));
    }*/

    public function index()
    {
        $param = $this->request->param();//接收筛选条件

        $data = model('TradeOrder')->getLists($param);
        $data->appends($param);

        $this->assign('payId', isset($param['payId']) ? $param['payId'] : '');
        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('uname', isset($param['uname']) ? $param['uname'] : '');
        $this->assign('sn', isset($param['sn']) ? $param['sn'] : '');
        $this->assign('lists', $data->items());
        $this->assign('page', $data->render());

        return $this->fetch();
    }

    public function add()
    {
        return $this->fetch();
    }
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            // 获取买家
            $username = $this->request->param('buyer_username/s');
            $user_id = Db::name('user')->whereOr(['user_nickname|user_login|user_email|mobile'=>['eq', $username]])->value('id');
            if (empty($user_id)) {
                $this->error('系统未检测到该用户');
            }
            // 获取车子
            $car_title = $this->request->param('car_name/s');
            $car_id = Db::name('usual_car')->where(['name'=>['like', "%$car_title%"]])->value('id');
            if (empty($car_id)) {
                $this->error('车子标题不存在！');
            }

            $post   = $data['post'];
            $post['user_id'] = intval($user_id);
            $post['car_id'] = intval($car_id);
            $result = $this->validate($post,'Order.add');
            if ($result !== true) {
                $this->error($result);
            }
            model('TradeOrder')->adminAddArticle($post);

            // 钩子
            // $post['id'] = model('TradeOrder')->id;
            // $hookParam          = [
            //     'is_add'  => true,
            //     'article' => $post
            // ];
            // hook('portal_admin_after_save_article', $hookParam);

            $this->success('添加成功!', url('AdminOrder/edit', ['id' => model('TradeOrder')->id]));
        }
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        $post = model('TradeOrder')->getPost($id);

        $this->assign('order_status', model('TradeOrder')->getOrderStatus($post['status']));
        $this->assign('post', $post);
        return $this->fetch();
    }
    public function editPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();

            $post   = $data['post'];
            $result = $this->validate($post, 'Order.edit');
            if ($result !== true) {
                $this->error($result);
            }
            if ($post['status']==1 && empty($post['pay_time'])) {
                $this->error('支付时间不能为空 <br>或者 支付状态不能为未支付、取消！');
            }

            if (!empty($data['photo_names'])) {
                $post['more']['identity_card'] = model('TradeOrder')->dealFiles(['names'=>$data['photo_names'],'urls'=>$data['photo_urls']]);
            }
            if (!empty($data['file_names'])) {
                $post['more']['files'] = model('TradeOrder')->dealFiles(['names'=>$data['file_names'],'urls'=>$data['file_urls']]);
            }

            model('TradeOrder')->adminEditArticle($post);

            $this->success('保存成功!');
        }
    }

    public function delete()
    {
        $param = $this->request->param();

        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            $resultPortal = model('TradeOrder')
                ->where(['id' => $id])
                ->update(['delete_time' => time()]);
            if ($resultPortal) {
                $result       = model('TradeOrder')->where(['id' => $id])->find();
                $data         = [
                    'object_id'   => $result['id'],
                    'create_time' => time(),
                    'table_name'  => 'TradeOrder',
                    'name'        => $result['order_sn']
                ];
                Db::name('recycleBin')->insert($data);
            }
            $this->success("删除成功！", '');
        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $recycle = model('TradeOrder')->where(['id' => ['in', $ids]])->select();
            $result  = model('TradeOrder')->where(['id' => ['in', $ids]])->update(['delete_time' => time()]);
            if ($result) {
                foreach ($recycle as $value) {
                    $data = [
                        'object_id'   => $value['id'],
                        'create_time' => time(),
                        'table_name'  => 'TradeOrder',
                        'name'        => $value['order_sn']
                    ];
                    Db::name('recycleBin')->insert($data);
                }
                $this->success("删除成功！", '');
            }
        }
    }

    public function publish()
    {
        $param           = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('TradeOrder')->where(['id' => ['in', $ids]])->update(['status' => 1, 'published_time' => time()]);
            $this->success("启用成功！", '');
        }

        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('TradeOrder')->where(['id' => ['in', $ids]])->update(['status' => 0]);
            $this->success("禁用成功！", '');
        }
    }
    public function top()
    {
        $param           = $this->request->param();
        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('TradeOrder')->where(['id' => ['in', $ids]])->update(['is_top' => 1]);
            $this->success("置顶成功！", '');

        }
        if (isset($_POST['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('TradeOrder')->where(['id' => ['in', $ids]])->update(['is_top' => 0]);
            $this->success("取消置顶成功！", '');
        }
    }
    public function recommend()
    {
        $param           = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('TradeOrder')->where(['id' => ['in', $ids]])->update(['is_rec' => 1]);
            $this->success("推荐成功！", '');

        }
        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('TradeOrder')->where(['id' => ['in', $ids]])->update(['is_rec' => 0]);
            $this->success("取消推荐成功！", '');

        }
    }
    public function status()
    {
        $ids = $this->request->param('ids/a');
        $s = $this->request->param('s/d');
        if (!empty($ids) && isset($s)) {
            model('TradeOrder')->where(['id'=>['in',$ids]])->update(['status'=>$s]);
            $this->success('状态修改成功');
        }
    }


    public function listOrder()
    {
        parent::listOrders(Db::name('TradeOrder'));
        $this->success("排序更新成功！", '');
    }

    public function move()
    {

    }

    public function copy()
    {

    }

    public function orderExcel()
    {
        $ids = $this->request->param('ids/a');
        $where = [];
        if (!empty($ids)) {
            $where = ['id'=>['in',$ids]];
        }

        $title = '二手车订单';
        $head = ['订单号','订金','支付总额','买家','联系方式'];
        $field = 'order_sn,bargain_money,order_amount,buyer_username,buyer_contact';
        $dir = 'trade';
        
        model('TradeOrder')->excelPort($title, $head, $field, $where, $dir);
    }
}