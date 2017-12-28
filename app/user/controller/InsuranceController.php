<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
use app\insurance\model\InsuranceOrderModel;
use think\Db;

/**
* 个人中心 保险
*/
class InsuranceController extends UserBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    // 列表页
    public function index()
    {
        // $param = $this->request->param();
        $filter['user_id'] = cmf_get_current_user_id();
        $policy = model('insurance/InsuranceOrder')->getLists($filter);

        $this->assign('policy', $policy->items());// 获取查询数据并赋到模板
        // $policy->appends($param);添加分页URL参数
        $this->assign('pager', $policy->render());// 获取分页代码并赋到模板
        return $this->fetch();
    }

    public function details()
    {
        $orderId = $this->request->param('id',0,'intval');

        $order = model('insurance/InsuranceOrder')->getPost($orderId);
        if (empty($order)) {
            abort(404, ' 页面不存在!');
        }
        $order['statusV'] = config('insurance_order_status')[$order['status']];

        // 认证资料
        $auerbach = $order['more'];
        // 险种
        $coverages = model('insurance/InsuranceCoverage')->getCoverageByOrder($orderId);
        // 意向公司
        $compIds = json_decode($order['compIds'],true);
        $companys = model('usual/UsualCompany')->getCompanys(0,0,false,['id'=>['in',$compIds]]);
        // 指定公司
        if (!empty($order['company_id'])) {
            $companyNmae = Db::name('usual_company')->where('id',$order['company_id'])->value('name');
            $this->assign('companyNmae',$companyNmae);
        }

        $this->assign('order',$order);
        $this->assign('auerbach',$auerbach);
        $this->assign('coverages',$coverages);
        $this->assign('companys',$companys);
        return $this->fetch();
    }

    // auerbach
    public function detailsPost()
    {
        $data = $this->request->param();
        if (empty($data['type'])) {
            $this->error('请选择领取保单方式');
        }

        $orderModel = new InsuranceOrderModel();
        $where = ['id'=>intval($data['id'])];

        if (!empty($data['more']['address'])) {
            $more = $orderModel->where($where)->value('more');
            $more = json_decode($more,true);
            $data['more'] = array_merge($more,$data['more']);
        }

        $orderModel->adminEditArticle($data);

        $this->success('进入合同页面……',url('insurance/Index/contract',$where));
    }

    public function cancel()
    {
        $orderId = $this->request->param('id',0,'intval');
        $uid = cmf_get_current_user_id();

        $where = ['id'=>$orderId,'user_id'=>$uid];

        // 预约金处理

        $result = Db::name('insurance_order')->where($where)->setField('status',-1);
        if ($result) {
            $this->success('您已取消预约保单');
        }
        $this->error('取消失败');
    }

    public function del()
    {
        // $orderId = $this->request->param('id',0,'intval');
        parent::dels(Db::name('insurance_order'));
        $this->success("刪除成功！", '');
    }

    // 更多……  保留代码
    public function more()
    {
        return $this->fetch();
    }
}