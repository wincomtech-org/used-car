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
        $usualSettings    = cmf_get_option('usual_settings');
        $alipaySettings    = cmf_get_option('alipay_settings');
        $weixinSettings    = cmf_get_option('weixin_settings');

        $this->assign('usual', $usualSettings);
        $this->assign('alipay', $alipaySettings);
        $this->assign('weixin', $weixinSettings);

        return $this->fetch();
    }
    public function configPost()
    {
        if ($this->request->isPost()) {
            $result = $this->validate($this->request->param(), 'UsualSet');
            if ($result !== true) {
                $this->error($result);
            }
            // 轮流保存
            $usual = $this->request->param('usual/a');
            cmf_set_option('usual_settings', $usual);

            $alipay = $this->request->param('alipay/a');
            cmf_set_option('alipay_settings', $alipay);

            $weixin = $this->request->param('weixin/a');
            cmf_set_option('weixin_settings', $weixin);

            $this->success("保存成功！", '');
        }
    }
}