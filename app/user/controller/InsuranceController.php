<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
// use app\user\model\UserModel;
// use app\insurance\model\InsuranceOrderModel;
// use think\Validate;
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

        $page = model('insurance/InsuranceOrder')->getPost($orderId);
        if (empty($page)) {
            abort(404, ' 页面不存在!');
        }
        $page['statusV'] = config('insurance_order_status')[$page['status']];

        if (!empty($page['car_id'])) {
            $identiInfo = Db::name('usual_car')->where('id',$page['car_id'])->value('identi');
            $identiInfo = json_decode(Db::name('usual_car')->where('id',$page['car_id'])->value('identi'),true);
        } else {
            $identiInfo = $page['more'];
        }

        $this->assign('page',$page);
        $this->assign('identi',$identiInfo);
        return $this->fetch();
    }

    public function cancel()
    {
        $orderId = $this->request->param('id',0,'intval');
        $uid = cmf_get_current_user_id();

        $where = ['id'=>$orderId,'user_id'=>$uid];

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

    public function more()
    {
        return $this->fetch();
    }
}