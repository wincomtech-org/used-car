<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;
// use think\Db;

/**
* 寄存点设置
*/
class AdminDepositController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        $id = $this->request->param('id',0,'intval');
        $data = model('usual_company')->where('id',$id)->value('name');
        return $data.'的寄存点：';
        return $this->fetch();
    }
}