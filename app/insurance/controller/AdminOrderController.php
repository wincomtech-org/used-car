<?php
namespace app\insurance\controller;

use cmf\controller\AdminBaseController;
use app\insurance\model\InsuranceOrderModel;
use app\usual\model\UsualCompanyModel;
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
        $compId = $this->request->param('compId',0,'intval');

        $data = model('InsuranceOrder')->getLists($param);
        // $insurances = model('Insurance')->getInsurance($insuranceId);
        $companys = model('usual/UsualCompany')->getCompanys($compId);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('uname', isset($param['uname']) ? $param['uname'] : '');
        $this->assign('sn', isset($param['sn']) ? $param['sn'] : '');
        // $this->assign('insurances', $insurances);
        $this->assign('insuranceId', $insuranceId);
        $this->assign('companys', $companys);
        $this->assign('compId', $compId);
        $this->assign('lists', $data->items());
        $data->appends($param);
        $this->assign('pager', $data->render());

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
            $this->success('添加成功!', url('AdminOrder/edit', ['id' => model('InsuranceOrder')->id]));
        }
    }

    // 编辑保险单
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');

        $orderModel = new InsuranceOrderModel();
        $post = $orderModel->getPost($id);
        if (!empty($post['compIds'])) {
            $post['compIds'] = json_decode($post['compIds'],true);
        }
        if (!empty($post['coverIds'])) {
            $post['coverIds'] = json_decode($post['coverIds'],true);
        }

        // 公司企业
        $compModel = new UsualCompanyModel();
        $selcomp   = $compModel->getCompanys(0,0,false,['id'=>['in',$post['compIds']]]);
        $companys = $compModel->getCompanys($post['company_id']);
        // 险种
        $selcover = model('InsuranceCoverage')->field('id,name')->order("list_order ASC")->where(['id'=>['in',$post['coverIds']]])->select()->toArray();

        // 状态
        $order_status = $orderModel->getOrderStatus($post['status']);

        $this->assign('selcomp', $selcomp);
        $this->assign('companys', $companys);
        $this->assign('selcover', $selcover);
        $this->assign('order_status', $order_status);
        $this->assign('post', $post);
        return $this->fetch();
    }
    public function editPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $post['amount'] = floatval($post['amount']);

            // 验证保单
            $result = $this->validate($post, 'Order.edit');
            if ($result !== true) {
                $this->error($result);
            }
            if ($post['status']>=1 && empty($post['amount'])) {
                $this->error('请填写保险金');
            }
            if ($post['status']==6 && empty($post['pay_time'])) {
                $this->error('支付时间不能为空 <br> 或者 支付状态为未支付！');
            }

            $orderModel = new InsuranceOrderModel();
            // 直接拿官版的
            if (!empty($data['identity_card'])) {
                $post['more']['identity_card'] = $orderModel->dealFiles($data['identity_card']);
            }
            if (!empty($data['file'])) {
                $post['more']['file'] = $orderModel->dealFiles($data['file']);
            }

            $orderModel->adminEditArticle($post);

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