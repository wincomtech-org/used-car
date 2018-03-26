<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;

// use think\Model;

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
        $usualSettings  = cmf_get_option('usual_settings');
        $sms_yunpian    = cmf_get_option('sms_yunpian');
        $alipaySettings = cmf_get_option('alipay_settings');
        $weixinSettings = cmf_get_option('weixin_settings');

        $this->assign('usual', $usualSettings);
        $this->assign('yunpian', $sms_yunpian);
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

            $yunpian = $this->request->param('yunpian/a');
            cmf_set_option('sms_yunpian', $yunpian);

            $alipay = $this->request->param('alipay/a');
            cmf_set_option('alipay_settings', $alipay);

            $weixin = $this->request->param('weixin/a');
            cmf_set_option('weixin_settings', $weixin);

            $this->success("保存成功！", '');
        }
    }
}
