<?php
namespace app\funds\controller;

use cmf\controller\AdminBaseController;
use app\funds\model\FundsApplyModel;
// use think\Db;

/**
* 后台 
* 财务管理 充值管理
*/
class AdminRechargeController extends AdminBaseController
{
    public function index()
    {
        $param = $this->request->param();
        $param['type'] = 'recharge';

        $fundsModel = new FundsApplyModel();
        $list = $fundsModel->getLists($param);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('list', $list->items());
        $list->appends($param);
        $this->assign('pager', $list->render());
        return $this->fetch();
    }

    public function edit()
    {
        # code...
    }

    public function more()
    {
        # code...
    }
}