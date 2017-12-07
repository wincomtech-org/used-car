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
    function _initialize()
    {
        parent::_initialize();
        $u_f_nav = $this->request->action();

        $this->user = cmf_get_current_user();
// dump($user);

        $this->assign('u_f_nav',$u_f_nav);
        $this->assign('user',$this->user);
    }

    // 列表页
    public function index()
    {
        $param = $this->request->param();
        $month = $this->request->param('month',0,'intval');
        // $type = $this->request->param('type',0,'intval');

        $param['userId'] = $this->user['id'];
        // vendor('topthink/think-helper/src/Time');
        // Time::today();
        $param['start_time'] = strtotime("-$month month");
        // $param['end_time'] = time();

        $fundsModel = new UserFundsLogModel();
        $list = $fundsModel->getLists($param);

        // 押金 需去除 -1,-3,-5,-6,-7
        // $deposit = $fundsModel->sumCoin($this->user['id'],'1,3,5,6,7');
        // $deposit2 = $fundsModel->sumCoin($this->user['id'],'-1,-3,-5,-6,-7');
        // 收入
        $income = $fundsModel->sumCoin($this->user['id'],'',$param['start_time'],'gt');
        // 支出
        $expense = $fundsModel->sumCoin($this->user['id'],'',$param['start_time'],'lt');
        // 类型
        // $categorys = $fundsModel->getTypes($type);

        // $this->assign('categorys', $categorys);
        $this->assign('income', $income);
        $this->assign('expense', $expense);
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

    public function rechargePost()
    {
        $data = $this->request->param();
        dump($data);
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