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

use think\Db;
use app\admin\model\ThemeModel;
use app\admin\model\NavMenuModel;
use app\admin\service\ApiService;
use app\admin\model\SlideItemModel;
use think\View;
use think\Request;

class HomeBaseController extends BaseController
{
    public function _initialize()
    {
        // 显示除了E_NOTICE(提示)和E_WARNING(警告)外的所有错误
        // error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        // 监听home_init
        hook('home_init');
        parent::_initialize();
        $siteInfo = cmf_get_site_info();
        if (isset($siteInfo['web_switch']) && $siteInfo['web_switch']=='0') {
            echo $siteInfo['web_switch_desc'];exit();
        }

        // 缓存
        $cbc = cache('cbc');
        if (empty($cbc)) {
            // 导航（手机端）
            $navMenuModel = new NavMenuModel();
            $navMenus = $navMenuModel->navMenusTreeArray(null,2);
            // 友链
            $apiModel = new ApiService();
            $friendLink = $apiModel->links('url,name,target,description');
            // 幻灯片
            $slideModel = new SlideItemModel();
            $slides = $slideModel->getLists(['cid'=>1]);
            // 用户数据
            // $this->user = cmf_get_current_user();

            $cbc = cache('cbc',[
                'navMenus'  => $navMenus,
                'friendLink'=> $friendLink,
                'slides'    => $slides,
            ],3600);
        }

        View::share('site_info', $siteInfo);
        View::share('navMenus', $cbc['navMenus']);
        View::share('friendLink', $cbc['friendLink']);
        View::share('slides', $cbc['slides']);
        // $this->assign('user',$this->user);
    }

    public function _initializeView()
    {
        $cmfThemePath    = config('cmf_theme_path');
        $cmfDefaultTheme = cmf_get_current_theme();

        $themePath = "{$cmfThemePath}{$cmfDefaultTheme}";

        $root = cmf_get_root();
        //使cdn设置生效
        $cdnSettings = cmf_get_option('cdn_settings');
        if (empty($cdnSettings['cdn_static_root'])) {
            $viewReplaceStr = [
                '__ROOT__'     => $root,
                '__TMPL__'     => "{$root}/{$themePath}",
                '__STATIC__'   => "{$root}/static",
                '__WEB_ROOT__' => $root
            ];
        } else {
            $cdnStaticRoot  = rtrim($cdnSettings['cdn_static_root'], '/');
            $viewReplaceStr = [
                '__ROOT__'     => $root,
                '__TMPL__'     => "{$cdnStaticRoot}/{$themePath}",
                '__STATIC__'   => "{$cdnStaticRoot}/static",
                '__WEB_ROOT__' => $cdnStaticRoot
            ];
        }

        $viewReplaceStr = array_merge(config('view_replace_str'), $viewReplaceStr);
        config('template.view_base', "{$themePath}/");
        config('view_replace_str', $viewReplaceStr);

        $themeErrorTmpl = "{$themePath}/error.html";
        if (file_exists_case($themeErrorTmpl)) {
            config('dispatch_error_tmpl', $themeErrorTmpl);
        }

        $themeSuccessTmpl = "{$themePath}/success.html";
        if (file_exists_case($themeSuccessTmpl)) {
            config('dispatch_success_tmpl', $themeSuccessTmpl);
        }
    }

    /**
     * 加载模板输出
     * @access protected
     * @param string $template 模板文件名
     * @param array $vars 模板输出变量
     * @param array $replace 模板替换
     * @param array $config 模板参数
     * @return mixed
     */
    protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
        $template = $this->parseTemplate($template);
        $more     = $this->getThemeFileMore($template);
        $this->assign('theme_vars', $more['vars']);
        $this->assign('theme_widgets', $more['widgets']);
        return parent::fetch($template, $vars, $replace, $config);
    }

    /**
     * 自动定位模板文件
     * @access private
     * @param string $template 模板文件规则
     * @return string
     */
    private function parseTemplate($template)
    {
        // 分析模板文件规则
        $request = $this->request;
        // 获取视图根目录
        if (strpos($template, '@')) {
            // 跨模块调用
            list($module, $template) = explode('@', $template);
        }

        $viewBase = config('template.view_base');

        if ($viewBase) {
            // 基础视图目录
            $module = isset($module) ? $module : $request->module();
            $path   = $viewBase . ($module ? $module . DS : '');
        } else {
            $path = isset($module) ? APP_PATH . $module . DS . 'view' . DS : config('template.view_path');
        }

        $depr = config('template.view_depr');
        if (0 !== strpos($template, '/')) {
            $template   = str_replace(['/', ':'], $depr, $template);
            $controller = cmf_parse_name($request->controller());
            if ($controller) {
                if ('' == $template) {
                    // 如果模板文件名为空 按照默认规则定位
                    $template = str_replace('.', DS, $controller) . $depr . $request->action();
                } elseif (false === strpos($template, $depr)) {
                    $template = str_replace('.', DS, $controller) . $depr . $template;
                }
            }
        } else {
            $template = str_replace(['/', ':'], $depr, substr($template, 1));
        }
        return $path . ltrim($template, '/') . '.' . ltrim(config('template.view_suffix'), '.');
    }

    /**
     * 获取模板文件变量
     * @param string $file
     * @param string $theme
     * @return array
     */
    private function getThemeFileMore($file, $theme = "")
    {

        //TODO 增加缓存
        $theme = empty($theme) ? cmf_get_current_theme() : $theme;

        // 调试模式下自动更新模板
        if (APP_DEBUG) {
            $themeModel = new ThemeModel();
            $themeModel->updateTheme($theme);
        }

        $themePath = config('cmf_theme_path');
        $file      = str_replace('\\', '/', $file);
        $file      = str_replace('//', '/', $file);
        $file      = str_replace(['.html', '.php', $themePath . $theme . "/"], '', $file);

        $files = Db::name('theme_file')->field('more')->where(['theme' => $theme])->where(function ($query) use ($file) {
            $query->where(['is_public' => 1])->whereOr(['file' => $file]);
        })->select();

        $vars    = [];
        $widgets = [];
        foreach ($files as $file) {
            $oldMore = json_decode($file['more'], true);
            if (!empty($oldMore['vars'])) {
                foreach ($oldMore['vars'] as $varName => $var) {
                    $vars[$varName] = $var['value'];
                }
            }

            if (!empty($oldMore['widgets'])) {
                foreach ($oldMore['widgets'] as $widgetName => $widget) {

                    $widgetVars = [];
                    if (!empty($widget['vars'])) {
                        foreach ($widget['vars'] as $varName => $var) {
                            $widgetVars[$varName] = $var['value'];
                        }
                    }

                    $widget['vars']       = $widgetVars;
                    $widgets[$widgetName] = $widget;
                }
            }
        }

        return ['vars' => $vars, 'widgets' => $widgets];
    }

    public function checkUserLogin()
    {
        $userId = cmf_get_current_user_id();
        if (empty($userId)) {
            $this->error("用户尚未登录", url("user/login/index"));
        }
    }



// 以下为自定义的
    /**
     * 面包屑导航
     * @param string $table 分类表名
     * @param int $pid 分类id
     * @param string $title 当前标题
     * @param array $data 循环数据
     * @param string $tpl 模板
     * @return string
    */
    public function getCrumbs($pid=0,$title='',$table='portal_category', $data=[], $tpl='')
    {
        if (empty($tpl)) {
            $tpl = '<ul class="brash"><li>当前位置：</li>';
            if (!empty($table) && !empty($pid)) {
                $tpl .= $this->parInfo($table, $pid, $title);
            } elseif (!empty($data)) {
                $count = count($data)-1;
                foreach ($data as $k => $v) {
                    $tpl .= '<li class="'. ($k==$count?'active':'') .'"><a href="'. $v['url'] .'">'. $v['name'] .'</a></li>';
                }
            }
            if (!empty($title)) {
                $tpl .= '<li class="active"><a href="#">'. $title .'</a></li>';
            }
            $tpl .= '</ul>';
        } else {
            # code...
        }

        return $tpl;
    }
    public function parInfo($table='', $pid=0, $title='', $recurId=0)
    {
        $par = Db::name($table)->field('parent_id,name')->where('id',$pid)->find();
        $url = cmf_url('List/index',['id'=>$pid]);
        if (!empty($par['name'])) {
             $tpl = '<li class="'.((empty($title) && $recurId==0)?'active':'').'"><a href="'. $url .'">'. $par['name'] .'</a></li>';
        }
        // $tpl = $pid.'('.$par['parent_id'].'-'.$recurId.');';
        $recurId++;
        if ($par['parent_id']>0) {
            $tpl = $this->parInfo($table,$par['parent_id'], $title, $recurId) . $tpl;
        }
        return $tpl;
    }


    /*
    * 支付模板展示 微信、支付宝
    * 初始化： import('paymentOld/wxpaynative/WorkPlugin',EXTEND_PATH);
    * url加密： cmf_str_encode($url)
    * urlencode('weixin://wxpay/bizpayurl?pr=cTQpvMv')
    * url('funds/Pay/createQRcode',['data'=>urlencode($qrcode)])
    * 直接用官网： http://paysdk.weixin.qq.com/example/qrcode.php?data={:urlencode($qrcode)}
    */
    public function showPay($data='')
    {
        $alipay_show = 'pc';
        $wxpay_show  = 'native';
        if (cmf_is_mobile()) {
            $alipay_show = 'wap';
        }
        if (cmf_is_wechat()) {
            $alipay_show = 'ban';
            $wxpay_show  = 'js';
        }

        // 微信的扫码支付
        if ($wxpay_show=='native') {
            import('payment/wxpaynative/WorkPlugin',EXTEND_PATH);
            $work = new \WorkPlugin($data['order_sn'],$data['coin'],$data['id'],$data['action']);
            $qrcode = $work->work();
            $this->assign('qrcode',$qrcode);
        }
        // 支付宝的扫码支付？
        if ($alipay_show=='qr') {
            
        }

        $this->assign('alipay_show',$alipay_show);
        $this->assign('wxpay_show',$wxpay_show);
    }



}