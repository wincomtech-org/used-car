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
        $id = $this->request->param('id',0,'intval');
        $data = Db::name('usual_company')->where('id',$id)->value('name');
        return $data.'的车辆业务：';
        return $this->fetch();
    }
}