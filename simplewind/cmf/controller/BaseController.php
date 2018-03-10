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

use think\Config;
use think\Controller;
use think\Request;
use think\View;

class BaseController extends Controller
{
    /**
     * 构造函数
     * @param Request $request Request对象
     * @access public
     */
    public function __construct(Request $request = null)
    {
        if (!cmf_is_installed() && $request->module() != 'install') {
            header('Location: ' . cmf_get_root() . '/?s=install');
            exit;
        }

        if (is_null($request)) {
            $request = Request::instance();
        }

        $this->request = $request;

        $this->_initializeView();
        $this->view = View::instance(Config::get('template'), Config::get('view_replace_str'));

        // 控制器初始化
        $this->_initialize();

        // 前置操作方法
        if ($this->beforeActionList) {
            foreach ($this->beforeActionList as $method => $options) {
                is_numeric($method) ?
                $this->beforeAction($options) :
                $this->beforeAction($method, $options);
            }
        }
    }

    // 初始化视图配置
    protected function _initializeView()
    {
    }

    /**
     * 排序 排序字段为list_orders数组 POST 排序字段为：list_order
     * @param $model object
     */
    protected function listOrders($model)
    {
        if (!is_object($model)) {
            return false;
        }

        $pk  = $model->getPk(); //获取主键名称
        $ids = $this->request->post("list_orders/a");

        // 循环更新 感觉这样效率好低
        if (!empty($ids)) {
            foreach ($ids as $key => $r) {
                $data['list_order'] = $r;
                $model->where([$pk => $key])->update($data);
            }
        }
        // 拼接成一次性操作
        // $query = 'UPDATE ';

        return true;
    }

    /**
     *  刪除 回收机制
     *  通用的
     */
    protected function dels($model, $obj = '')
    {
        if (is_array($model)) {
            $result = $obj->where($model)->delete();
        } elseif (is_object($model)) {
            $pk     = $model->getPk(); //获取主键名称
            $id     = $this->request->param($pk . '/d');
            $result = $model->where($pk, $id)->delete();
        } else {
            return false;
        }

        if ($result) {
            // $data = [];
            // Db::name('recycleBin')->insert($data);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 缩略图生成
     * 模板中：{:url('thumbUrl',['img'=>urlencode('default/20171225/logo_lucency.png')])}
     * urlencode() 、 urldecode()解决特殊字符转义问题
     * @param  string  $image  [description]
     * @param  integer $width  [description]
     * @param  integer $height [description]
     * @return [type]          [description]
     */
    public function thumbUrl($image = 'default/20171225/logo_lucency.png', $width = 135, $height = 135)
    {
        $data   = $this->request->param();
        $image  = empty($data['img']) ? '' : urldecode($data['img']);
        $width  = empty($data['w']) ? 135 : $data['w'];
        $height = empty($data['h']) ? 135 : $data['h'];
        $type   = empty($data['t']) ? 6 : $data['t'];

        $url = lothar_thumb_url($image, $width, $height, $type);

        // redirect($url);
        return redirect($url);
    }

}
