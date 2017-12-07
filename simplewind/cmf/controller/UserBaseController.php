<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace cmf\controller;

// use think\View;

class UserBaseController extends HomeBaseController
{
    public function _initialize()
    {
        parent::_initialize();
        $this->checkUserLogin();

        $usernav = $this->request->controller();
        $this->assign('usernav',$usernav);
    }

    public function navAction()
    {
        // $navAction = $this->request->module().$this->request->controller().$this->request->action();
        // \simplewind\vendor\ezyang\htmlpurifier\library\HTMLPurifier\Encoder.php
        // $unichr = unichr($navAction);
        // $md5 = md5(sha1(crc32($navAction)));//唯一
        // $crc32 = crc32($navAction);//数字型，速度快，少碰撞，可结合数据长度减少碰撞 strlen($navAction)
        // View::share('crc32', $crc32);
    }
}