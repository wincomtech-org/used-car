<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
use app\user\model\UserModel;
use app\funds\model\UserFundsLogModel;
// use think\Validate;
use think\Db;

/**
* 个人中心 
* 财务管理 资金动向
*/
class FundsController extends UserBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    // 列表页
    public function index()
    {
        $param = $this->request->param();
        $type = $this->request->param('type',0,'intval');

        $fundsModel = new UserFundsLogModel();

        $list = $fundsModel->getLists($param);

        $categorys = $fundsModel->getTypes($type);

        $this->assign('categorys', $categorys);
        $this->assign('list', $list->items());
        $list->appends($param);
        $this->assign('pager', $list->render());

        return $this->fetch();
    }

    public function withdraw()
    {
        return $this->fetch();
    }

    public function recharge()
    {
        return $this->fetch();
    }

    public function apply()
    {
        return $this->fetch();
    }

    public function cancel()
    {
        return $this->fetch();
    }

    public function del()
    {
        parent::dels(Db::name('user_funds_log'));
        $this->success("刪除成功！", '');
    }

    public function more()
    {
        return $this->fetch();
    }
}