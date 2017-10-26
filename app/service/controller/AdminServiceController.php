<?php
namespace app\service\controller;

use cmf\controller\AdminBaseController;
// use app\service\model\ServiceModel;
use think\Db;

class AdminServiceController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        $companyId = $this->request->param('companyId',0,'intval');
        $data = Db::name('usual_company')->where('id',$companyId)->value('name');
        return $data.'的车辆业务：';
        return $this->fetch();
    }
}