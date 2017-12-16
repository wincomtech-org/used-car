<?php
namespace app\funds\controller;

use cmf\controller\AdminBaseController;
use app\funds\model\UserFundsLogModel;
use think\Db;

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

    // Excel 导出
    public function orderExcel()
    {
        $ids = $this->request->param('ids/a');
        $where = [];
        if (!empty($ids)) {
            $where = ['a.id'=>['in',$ids]];
        }

        $title = '资金动向';
        $head = ['类型','余额变动','用户ID','IP地址','创建时间'];
        $field = 'a.type,a.coin,a.user_id,a.ip,a.create_time';
        $dir = 'funds';
        $types = config('user_funds_log_type');

        $data = Db::name('user_funds_log')->alias('a')
        ->join('user b','a.user_id=b.id')
        ->field($field)
        ->where($where)
        ->select()->toArray();
        if (empty($data)) {
            $this->error('数据为空！');
        }

        $new = [];
        foreach ($data as $key => $value) {
            $value['type'] = $types[$value['type']];
            $value['create_time'] = date('Y-m-d H:i',$value['create_time']);
            $new[] = $value;
        }

        model('UserFundsLog')->excelPort($title, $head, $new, $where, $dir);
    }

    public function more()
    {
        # code...
    }
}