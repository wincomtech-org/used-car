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

    // 点券操作
    public function ticket()
    {
        $data = $this->request->param();


        return '点券';
        return $this->fetch();
    }
    public function ticketAdd()
    {

        // 判断是否为新用户
        $count = Db::name('user_funds_log')->where('user_id')->count();
        if ($count>0) {
            $this->error('不是新用户');
        }
    }

    // 给用户加钱
    public function coin()
    {
        # code...
    }
    public function coinAdd()
    {
        # code...
    }

    public function more()
    {
        # code...
    }
}