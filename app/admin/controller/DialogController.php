<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use cmf\controller\AdminBaseController;

class DialogController extends AdminBaseController
{

    public function map()
    {
        $location = $this->request->param('location');
        $location = explode(',', $location);
        $lng      = empty($location[0]) ? 117.241405 : $location[0];
        $lat      = empty($location[1]) ? 31.819577 : $location[1];

        $this->assign(['lng' => $lng, 'lat' => $lat]);
        return $this->fetch();
    }

}