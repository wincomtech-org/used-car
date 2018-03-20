<?php
// +----------------------------------------------------------------------
// index.php(或者其它应用入口文件） 模块/控制器/操作/[参数名/参数值...]
// index.php(或者其它应用入口文件） 模块/控制器/操作?参数名=参数值&...
// index.php（或者其它应用入口文件）?s=/模块/控制器/操作
// var_dump($_REQUEST);
// url('Post/step1',['id'=>1,'h'=>'a'])
// url('Post/step1','id=1&h=a')
// url('http://tx.car/index.php/Insurance/Post/step1?id=1&h=a#AAA')
// var_dump(parse_url('http://tx.car/index.php/Insurance/Post/step1?id=1#AAA'));
// parse_str('module=home&controller=user&action=login&var=value',$a);
// var_dump($a);
// die;
// +----------------------------------------------------------------------

// [ 入口文件 ]

// 调试模式开关
// config.php中 APP_DEBUG 替换成 (defined('APP_DEBUG') && APP_DEBUG)
// define("APP_DEBUG", true);
define("APP_DEBUG", false);
// define("APP_TRACE", false);

// URL
// define('__HOST__', 'http://'.$_SERVER['HTTP_HOST']);

// 定义CMF根目录,可更改此目录
define('CMF_ROOT', __DIR__ . '/../');

// 定义应用目录
define('APP_PATH', CMF_ROOT . 'app/');

// 定义CMF核心包目录
define('CMF_PATH', CMF_ROOT . 'simplewind/cmf/');

// 定义插件目录
define('PLUGINS_PATH', __DIR__ . '/plugins/');

// 定义扩展目录
define('EXTEND_PATH', CMF_ROOT . 'simplewind/extend/');
define('VENDOR_PATH', CMF_ROOT . 'simplewind/vendor/');

// 定义应用的运行时目录
define('RUNTIME_PATH', CMF_ROOT . 'data/runtime/');

// 定义CMF 版本号
define('THINKCMF_VERSION', '5.0.170927');

// 加载框架基础文件
require CMF_ROOT . 'simplewind/thinkphp/base.php';

// 执行应用
\think\App::run()->send();
