<?php
namespace app\insurance\controller;

use cmf\controller\AdminBaseController;
use app\insurance\model\InsuranceOrderModel;
use app\usual\model\UsualCarModel;
use think\Db;

class AdminOrderController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $insuranceId = $this->request->param('insuranceId',0,'intval');

        $data = model('InsuranceOrder')->getLists($param);
        $insurances = model('Insurance')->getInsurance($insuranceId);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('uname', isset($param['uname']) ? $param['uname'] : '');
        $this->assign('sn', isset($param['sn']) ? $param['sn'] : '');
        $this->assign('insuranceId', $insuranceId);
        $this->assign('insurances', $insurances);
        $this->assign('lists', $data->items());
        $data->appends($param);
        $this->assign('page', $data->render());

        return $this->fetch();
    }

    public function add()
    {
        $this->assign('order_status', model('InsuranceOrder')->getOrderStatus());
        return $this->fetch();
    }
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $result = $this->validate($post,'Order.add');
            if ($result !== true) {
                $this->error($result);
            }
            model('InsuranceOrder')->adminAddArticle($post);

            // 钩子
            // $post['id'] = model('InsuranceOrder')->id;
            // $hookParam          = [
            //     'is_add'  => true,
            //     'article' => $post
            // ];
            // hook('portal_admin_after_save_article', $hookParam);

            $this->success('添加成功!', url('AdminOrder/edit', ['id' => model('InsuranceOrder')->id]));
        }
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');

        $iOrderModel = new InsuranceOrderModel();
        $post = $iOrderModel->getPost($id);
        $order_status = $iOrderModel->getOrderStatus($post['status']);
        $car = model('usual/UsualCar')->getPost($post['car_id']);

        $this->assign('order_status', $order_status);
        $this->assign('post', $post);
        $this->assign('car', $car);
        return $this->fetch();
    }
    public function editPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $cardata= $data['car'];

            $car_id = DB::name('usual_car')->where('plateNo',$cardata['identi']['plateNo'])->value('id');
            if (!empty($car_id)) {
                $post['car_id'] = $car_id;
            } else {
                $cardata['plateNo'] = $cardata['identi']['plateNo'];

                $carModel = new UsualCarModel();
                $result = $this->validate($cardata, 'usual/Car.insurance');
                if ($result !== true) {
                    $this->error($result);
                }
                // 身份证
                if (!empty($cardata['identi']['identity_card'])) {
                    $cardata['identi']['identity_card'] = $carModel->dealFiles($cardata['identi']['identity_card']);
                }
                // 行驶证 单图不需要额外处理
                // $cardata['identi']['driving_license'];

                $carModel->adminAddArticle($cardata);
                $post['car_id'] = $carModel->id;
                // model('usual/UsualCar')->adminEditArticle($cardata);
                // $post['car_id'] = Db::name('usual_car')->insertGetId($cardata);
            }

            $result = $this->validate($post, 'Order.edit');
            if ($result !== true) {
                $this->error($result);
            }

            if ($post['status']==1 && empty($post['pay_time'])) {
                $this->error('支付时间不能为空 <br>或者 支付状态不能为未支付、取消！');
            }
            $iOrderModel = new InsuranceOrderModel();
            if (!empty($data['file_names'])) {
                $post['more']['files'] = $iOrderModel->dealFiles(['names'=>$data['file_names'],'urls'=>$data['file_urls']]);
            }

            $iOrderModel->adminEditArticle($post);

            // 钩子
            // $hookParam = [
            //     'is_add'  => false,
            //     'article' => $post
            // ];
            // hook('portal_admin_after_save_article', $hookParam);

            $this->success('保存成功!');
        }
    }

    public function delete()
    {
        $param = $this->request->param();

        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            $resultPortal = model('InsuranceOrder')
                ->where(['id' => $id])
                ->update(['delete_time' => time()]);
            if ($resultPortal) {
                $result       = model('InsuranceOrder')->where(['id' => $id])->find();
                $data         = [
                    'object_id'   => $result['id'],
                    'create_time' => time(),
                    'table_name'  => 'InsuranceOrder',
                    'name'        => $result['order_sn']
                ];
                Db::name('recycleBin')->insert($data);
            }
            $this->success("删除成功！", '');
        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $recycle = model('InsuranceOrder')->where(['id' => ['in', $ids]])->select();
            $result  = model('InsuranceOrder')->where(['id' => ['in', $ids]])->update(['delete_time' => time()]);
            if ($result) {
                foreach ($recycle as $value) {
                    $data = [
                        'object_id'   => $value['id'],
                        'create_time' => time(),
                        'table_name'  => 'InsuranceOrder',
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
            model('InsuranceOrder')->where(['id' => ['in', $ids]])->update(['status' => 1, 'published_time' => time()]);
            $this->success("启用成功！", '');
        }

        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('InsuranceOrder')->where(['id' => ['in', $ids]])->update(['status' => 0]);
            $this->success("禁用成功！", '');
        }
    }
    public function top()
    {
        $param           = $this->request->param();
        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('InsuranceOrder')->where(['id' => ['in', $ids]])->update(['is_top' => 1]);
            $this->success("置顶成功！", '');

        }
        if (isset($_POST['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('InsuranceOrder')->where(['id' => ['in', $ids]])->update(['is_top' => 0]);
            $this->success("取消置顶成功！", '');
        }
    }
    public function recommend()
    {
        $param  = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('InsuranceOrder')->where(['id' => ['in', $ids]])->update(['is_rec' => 1]);
            $this->success("推荐成功！", '');

        }
        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('InsuranceOrder')->where(['id' => ['in', $ids]])->update(['is_rec' => 0]);
            $this->success("取消推荐成功！", '');

        }
    }
    public function status()
    {
        $ids = $this->request->param('ids/a');
        $s = $this->request->param('s/d');
        if (!empty($ids) && isset($s)) {
            model('InsuranceOrder')->where(['id'=>['in',$ids]])->update(['status'=>$s]);
            $this->success('状态修改成功');
        }
    }


    public function listOrder()
    {
        parent::listOrders(Db::name('InsuranceOrder'));
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

        $title = '保险订单';
        $head = ['订单号','投保金额','投保车子','投保人'];
        $field = 'order_sn,amount,car_id,user_id';
        $dir = 'insurance';

        // $field = Db::name('insurance_order')->alias('a')
        //       ->join('user b')
        //       ->field($field)
        //       ->where($where)
        //       ->select();

        model('InsuranceOrder')->excelPort($title, $head, $field, $where, $dir);
    }
}