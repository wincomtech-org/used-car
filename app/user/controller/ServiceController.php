<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
use app\user\model\UserModel;
use app\service\model\ServiceModel;
use app\service\model\ServiceCategoryModel;
use app\usual\model\UsualCoordinateModel;
// use think\Validate;
use think\Db;

/**
* 个人中心 保险
*/
class ServiceController extends UserBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    // 列表页
    public function index()
    {
        // $param = $this->request->param();
        $mid = $this->request->param('mid/d',1,'intval');
        $userId = $this->user['id'];
        $extra = [
            'a.user_id'     => $userId,
            'a.model_id'    => $mid
        ];

        $sModel = new ServiceModel();
        $scModel = new ServiceCategoryModel();
        $serviceNav = cache('serviceNav');
        if (empty($serviceNav)) {
            $serviceNav = $scModel->serviceNav();
            cache('serviceNav',$serviceNav);
        }

        $list = $sModel->getLists([],'','',$extra);

        $this->assign('serviceNav',$serviceNav);
        $this->assign('mid',$mid);
        $this->assign('list', $list->items());// 获取查询数据并赋到模板
        // $list->appends($param);//添加分页URL参数
        $this->assign('pager', $list->render());// 获取分页代码并赋到模板
        return $this->fetch();
    }

    public function details()
    {
        $id = $this->request->param('id/d');
        $mid = $this->request->param('mid/d');

        $post = model('service/Service')->getPost($id);
        if (empty($post)) {
            abort(404,'数据不存在！');
        }
        $post['statusV'] = config('service_status')[$post['status']];
        $post['paystatusV'] = config('service_pay_status')[$post['pay_status']];

        // 分类模型
        $mid = $mid?$mid:$post['model_id'];
        $serviceNav = cache('serviceNav');
        $scModel = new ServiceCategoryModel();
        $define_data = $scModel->getDefineData($mid,false);
        $serviceCate = $scModel->field('name')->where('id',$mid)->find();

        // 处理服务点
        $servicePoint = Db::name('usual_coordinate')->where('id',$post['service_point'])->value('name');
        $servicePoints = model('usual/UsualCoordinate')->getCoordinates(0, ['id'=>$post['service_point']], false);

        // 如果需要支付
        $payUrl = '';
        if ($post['order_amount']>0) {
            $payUrl = url('service/Order/pay',['id'=>$id,'order_amount'=>$post['order_amount'],'modelId'=>$mid,'name'=>$serviceCate['name']]);
        }

        $this->assign('serviceNav',$serviceNav);
        $this->assign('define_data',$define_data);
        $this->assign('payUrl',$payUrl);
        $this->assign('servicePoint',$servicePoint);
        $this->assign('servicePointJson',json_encode($servicePoints));
        $this->assign('mid',$mid);
        $this->assign("post",$post);
        return $this->fetch();
    }

    public function cancel()
    {
        $id = $this->request->param('id/d');
        $mid = $this->request->param('mid/d');
        $result = Db::name('service')->where('id',$id)->setField('status',-1);
        if ($result) {
            $this->success('取消成功', url('index',['mid'=>$mid]));
        } else {
            $this->error('取消失败', url('index',['mid'=>$mid]));
        }

        return $this->fetch();
    }

    public function del()
    {
        parent::dels(Db::name('service'));
        $this->success("刪除成功！", '');

        // 传统
        // $id = $this->request->param('id/d');
        // $result = parent::dels(['id'=>$id],Db::name('service'));
        // if ($result) {
        //     $this->success('刪除成功');
        // } else {
        //     $this->error('删除失败！');
        // }
    }

    // 更多……  保留代码
    public function more()
    {
        return $this->fetch();
    }
}