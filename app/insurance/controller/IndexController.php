<?php
namespace app\insurance\controller;

use cmf\controller\HomeBaseController;
use app\portal\service\PostService;
use app\usual\model\UsualCompanyModel;
use app\insurance\model\InsuranceModel;
use app\insurance\model\InsuranceCoverageModel;
use app\insurance\model\InsuranceOrderModel;
use think\Db;

class IndexController extends HomeBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    // 填资料，选意向公司
    public function index()
    {
        // 保险公司
        $where = [
            'delete_time'   => 0,
            'identi_status' => 1,
            'status'        => 1,
            'is_rec'        => 1,
            'is_baoxian'    => 1,
        ];
        $uModel = new UsualCompanyModel();
        $companys = $uModel->field('id,name')->where($where)->select()->toArray();
        // $companys = $uModel->createOptions(0, 0, $companys);

        // 获取用户资料 cmf_verify
        $verifyinfo = lothar_verify(null,'openshop','more');

        $postService = new PostService();
        // 投保流程
        // 理赔指引
        $claim_guidance = $postService->fromCateList(8);

        $this->assign('verifyinfo',$verifyinfo);
        $this->assign('companys',$companys);
        $this->assign('claim_guidance',$claim_guidance);
        return $this->fetch();
    }
    public function indexPost()
    {
        $data = $this->request->param();

        // 验证数据的完备性
        $result = $this->validate($data,'Order.step1');
        if ($result!==true) {
            $this->error($result);
        }

        session('insuranceFlow',$data);
        $this->success('进入险种选项',url('insurance/Index/step1'));
    }

    // 选险种
    public function step1()
    {
        // 险种
        $ufoModel = new InsuranceCoverageModel();
        // ['is_rec'=>1]
        $coverages = $ufoModel->fromCateList(null,20,',duty,compen_item,compen_total');
        // dump($coverages);die;
        // 保险
        $iModel = new InsuranceModel();
        $insurances = $iModel->getPostList();

        $this->assign('coverages', $coverages);
        $this->assign('insurances', $insurances);
        return $this->fetch();
    }

    public function step2()
    {
        $coverIds = $this->request->post('coverIds/a',[]);
        $userId = cmf_get_current_user_id();
        $map = session('insuranceFlow');
        $plateNo = $map['more']['plateNo'];

        $orderModel = new InsuranceOrderModel();

        // 查重 只查该用户的，避免不必要的麻烦
        // $count = $orderModel->checkOrder();
        $count = $orderModel->checkOrder(['user_id'=>$userId,'plateNo'=>$plateNo]);
        if ($count>0) {
            $this->error('您的保单已存在',url('user/Insurance/index'));
        }

        // 验证数据
        $data['coverIds'] = $coverIds;
        $data['plateNo'] = $plateNo;
        $data['user_id'] = $userId;
        $data['order_sn'] = cmf_get_order_sn('insurance_');
        // 验证数据的完备性
        $result = $this->validate($data,'Order.step2');
        if ($result!==true) {
            $this->error($result);
        }

        // 保存数据
        $data['compIds'] = json_encode($map['compIds']);
        $data['coverIds'] = json_encode($coverIds);
        $data['more'] = $map['more'];
        // 直接拿官版的
        if (!empty($map['identity_card'])) {
            $data['more']['identity_card'] = model('usual/Usual')->dealFiles($map['identity_card']);
        }

        // 事务处理
        $transStatus = true;
        Db::startTrans();
        try {
            $result = $orderModel->adminAddArticle($data);
            $log = [
                'title'     => '保险订单',
                'user_id'   => $userId,
                'object'    => 'insurance_order:'.$result->id,
                'content'   => '客户ID：'.$userId.'，保单ID：'.$result->id,
                'adminurl'  => 2,
            ];
            lothar_put_news($log);
            Db::commit();
        }catch(\Exception $e){
            Db::rollback();
            $transStatus = false;
        }

        if ($transStatus===false) {
            $this->error('提交失败了……');
        }
        session('insuranceFlow',null);
        $this->success('提交成功，请耐心等待后台人员审核',url('user/Insurance/index'));
    }



/*后续处理*/
    // 同意合同
    public function contract()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }
        $orderId = $this->request->param('id',0,'intval');
        // $down = $this->request->param('down/d');
        if (empty($orderId)) {
            $this->error('保单非法');
        }

        $findOrder = Db::name('insurance_order')->field('order_sn,amount,status,insurance_id')->where('id',$orderId)->find();
        if (empty($findOrder)) {
            $this->error('该保险已被关闭或者失效，请联系管理员');
        }

        // 保险通用条例
        // $option = Db::name('insurance_option')->where('id',1)->find();
        // $option['content'] = cmf_replace_content_file_url(htmlspecialchars_decode($option['content']));
        $option = model('InsuranceOption')->getPost(1);

        $this->assign('orderId',$orderId);
        $this->assign('order',$findOrder);
        $this->assign('option',$option);
        return $this->fetch();
    }


}