<?php
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
// use app\admin\model\DistrictModel;
use think\Db;

/**
 * Class DistrictController 地区管理控制器
 * @package app\admin\controller
 */
class DistrictController extends AdminBaseController
{
    // public function _initialize()
    // {
    //     parent::_initialize();
    // }

    /**
     * 地区管理
     * @adminMenu(
     *     'name'   => '地区管理',
     *     'parent' => 'admin/District/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '地区管理',
     *     'param'  => ''
     * )
    */
    public function index()
    {
        return '地区管理';
        $this->fetch();
    }

    public function getCitys()
    {
        if ($this->request->isAjax()) {
            $parentId = $this->request->param('parentId',0,'intval');
            return model('District')->getDistricts(0,$parentId);
        }


        // $parentId = request();
        // $parentId = $this->request->param();
        // return $parentId['parentId'];
        // return request('parentId',0,'intval');
        // return $this->request->param('parentId',0,'intval');
        // echo "kill2";die;
        // echo $this->request->param('parentId');die;
    }
}