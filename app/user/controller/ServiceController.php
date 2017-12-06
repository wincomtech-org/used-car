<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
use app\user\model\UserModel;
use app\service\model\ServiceModel;
use app\service\model\ServiceCategoryModel;
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
        $userId = cmf_get_current_user_id();
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

        $scModel = new ServiceCategoryModel();
        $serviceNav = cache('serviceNav');
        $define_data = $scModel->getDefineData($mid,false);

        $page = model('service/Service')->getPost($id);
        if (empty($page)) {
            abort(404,'数据不存在！');
        }
        $page['statusV'] = config('service_status')[$page['status']];

        $servicePoint = Db::name('usual_coordinate')->where('id',$page['service_point'])->value('name');

        $this->assign('serviceNav',$serviceNav);
        $this->assign('define_data',$define_data);
        $this->assign('servicePoint',$servicePoint);
        $this->assign('mid',$mid);
        $this->assign('page',$page);
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

    public function more()
    {
        return $this->fetch();
    }
}