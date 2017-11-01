<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;
use think\Db;
// use think\Model;
use app\usual\model\DistrictModel;

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
    public function configPost()
    {
        if ($this->request->isPost()) {
            $result = $this->validate($this->request->param(), 'SettingSite');
            if ($result !== true) {
                $this->error($result);
            }

            $options = $this->request->param('options/a');
            cmf_set_option('site_info', $options);

            $cmfSettings = $this->request->param('cmf_settings/a');
            $bannedUsernames                 = preg_replace("/[^0-9A-Za-z_\\x{4e00}-\\x{9fa5}-]/u", ",", $cmfSettings['banned_usernames']);
            $cmfSettings['banned_usernames'] = $bannedUsernames;
            cmf_set_option('cmf_settings', $cmfSettings);

            $cdnSettings = $this->request->param('cdn_settings/a');
            cmf_set_option('cdn_settings', $cdnSettings);

            $adminSettings = $this->request->param('admin_settings/a');
            $routeModel = new RouteModel();
            if (!empty($adminSettings['admin_password'])) {
                $routeModel->setRoute($adminSettings['admin_password'].'$', 'admin/Index/index', [], 2, 5000);
            } else {
                $routeModel->deleteRoute('admin/Index/index', []);
            }
            $routeModel->getRoutes(true);
            cmf_set_option('admin_settings', $adminSettings);

            $this->success("保存成功！", '');
        }
    }
}