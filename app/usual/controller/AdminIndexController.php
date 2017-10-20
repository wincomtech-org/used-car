<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;
// use app\usual\model\UsualModel;
// use think\Db;

/**
 * Class AdminIndexController
 * @package app\usual\controller
 * @adminMenuRoot(
 *     'name'   =>'统配管理',
 *     'action' =>'default',
 *     'parent' =>'',
 *     'display'=> true,
 *     'order'  => 30,
 *     'icon'   =>'th',
 *     'remark' =>'管理'
 * )
 */
class AdminIndexController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function config()
    {
        return '二手车统一配置';
        return $this->fetch();
    }

}