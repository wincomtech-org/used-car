<?php
namespace app\funds\controller;

use cmf\controller\AdminBaseController;
use app\funds\model\UserFundsLogModel;
// use think\Db;

/**
* 后台 
* 财务管理 资金动向
*/
class AdminFundsController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

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

    public function more()
    {
        # code...
    }
}