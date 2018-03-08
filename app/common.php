<?php
// \simplewind\cmf\common.php
use think\Config;
use think\Db;
// use think\Route;
use think\Image;
use think\Request;
use think\Url;
use think\View;

function lothar_admin_log($action = '', $type = 'goods')
{
    $adminLog = [
        'user_id'     => cmf_get_current_admin_id(),
        'create_time' => time(),
        'ip'          => get_client_ip(),
        'type'        => $type,
        'action'      => $action,
    ];
    Db::name('admin_log')->insert($adminLog);
}

/**
 * 存放消息记录
 * @param $data 要写入的数据
$data = [
'title' => '预约保险',
'object'=> 'insurance_order'.$id,
'content'=>'客户ID：'.$userId.'保单ID：'.$id,
];
 * @param string $file 消息文件,在 web 入口目录
 * @return int
 */
function lothar_put_news($data, $file = null)
{
    // file_put_contents($file, $content, FILE_APPEND);
    // $request = Request::instance();

    if (empty($data['user_id'])) {
        $data['user_id'] = cmf_get_current_user_id();
    }

    if (empty($data['action'])) {
        $request        = request();
        $module         = $request->module();
        $controller     = $request->controller();
        $action         = $request->action();
        $data['action'] = strtolower($module . '/' . $controller . '/' . $action);
    }
    if (empty($data['app'])) {
        $data['app'] = request()->module();
    }

    if (empty($data['create_time'])) {
        $data['create_time'] = time();
    }

    return Db::name('news')->insertGetId($data);
    // Db::name('news')->insert($data);
    // return Db::name('news')->getLastInsID();
}
/*
 * 取出未处理消息 提醒
 * 二手车配置 $usualSettings = cmf_get_option('usual_settings');
 * __STATIC__ 可换成 /static
 */
function lothar_get_news($type = '', $dialog = false)
{
    $where['status'] = 0;
    if (!empty($type)) {
        $where['app'] = $type;
    }
    $news = Db::name('news')->where($where)->select();

    // 执行JS弹窗
    if ($dialog === true) {
        $usualSettings = cmf_get_option('usual_settings');
        if ($usualSettings['news_switch'] == 1) {
            $count = count($news);
            if ($count > 0) {
                $msg     = '您有 ' . $count . ' 条未处理消息！';
                $jumpurl = url('usual/AdminNews/index', ['status' => 0]);
                $audio   = '/static/audio/4182.mp3';
                $audio   = '';
                $html    = <<<EOT
                    <style type="text/css">
                        /*提示信息消息*/
                        .alert_msg{position:absolute;width:320px;right:0;bottom:0;background-color:#FCEFCF;color:#6A5128;font-size:16px;font-weight:bold;padding:25px 15px;box-sizing:border-box;box-sizing:-webkit-border-box;box-sizing:-moz-border-box;box-sizing:-ms-border-box;box-sizing:-o-border-box;}
                        .alert_msg a{display:block;margin-top:4px;}
                        .alert_msg b{position:absolute;top:3px;right:17px;font-size:23px;cursor:pointer;}
                    </style>
                    <script type="text/javascript">
                        $("#news_clock").append("<div class='alert_msg'><b>x</b>{$msg}<br/><a href='{$jumpurl}'>点击查看</a></div><audio id='sound' autoplay='autoplay' src='{$audio}'>");
                        // 消息提示弹窗
                        $(document).delegate(".alert_msg b","click",function(){
                            $(this).parent().hide(600);
                        })
                    </script>
EOT;
                echo $html;
            }
        }
    } else {
        return $news;
    }
}

/*用户资金流动 - 增加*/
function lothar_put_funds_log($data, $type = '', $coin = '', $remain = '--', $app = '--', $objId = '', $return = false)
{
    if (is_array($data)) {
        $count = count($data);
        if ($count != 8) {
            $data = [
                'user_id'     => (empty($data['user_id']) ? 0 : $data['user_id']),
                'type'        => (empty($data['type']) ? 0 : $data['type']),
                'coin'        => (empty($data['coin']) ? 0 : $data['coin']),
                'remain'      => (empty($data['remain']) ? 0.00 : $data['remain']),
                'app'         => (empty($data['app']) ? 'user' : $data['app']),
                'obj_id'      => (empty($data['obj_id']) ? 0 : $data['obj_id']),
                'create_time' => time(),
                'ip'          => get_client_ip(),
            ];
        }
    } else {
        $data = [
            'user_id'     => $data,
            'type'        => $type,
            'coin'        => $coin,
            'remain'      => $remain,
            'app'         => $app,
            'obj_id'      => $objId,
            'create_time' => time(),
            'ip'          => get_client_ip(),
        ];
    }

    if ($return === true) {
        return Db::name('user_funds_log')->insertGetId($data);
    } else {
        Db::name('user_funds_log')->insert($data);
    }
}
/*用户资金流动 - 获取*/
function lothar_get_funds_log($type = '', $dialog = false)
{
    $where['status'] = 0;
    if (!empty($type)) {
        $where['app'] = $type;
    }
    $news = Db::name('news')->where($where)->select();
}

/*
 * 用户认证状态信息
 * @param $uid 默认是当前用户
 * @param $code 默认是实名认证
 * @param $data 是否返回数据集、统计
 * @return boolean or array
 */
function lothar_verify($uid = null, $code = 'certification', $data = 'status')
{
    if (is_null($uid)) {
        $uid = cmf_get_current_user_id();
    }
    $where = [];
    if (!empty($uid)) {
        $where['user_id'] = $uid;
    }
    if (!empty($code)) {
        $where['auth_code'] = $code;
    }

    $result = null;
    $obj    = Db::name('verify');
    if ($data == 'status') {
        $result = $obj->where($where)->value('auth_status');
    } elseif ($data == 'count') {
        $result = $obj->where($where)->count();
    } elseif ($data == 'more') {
        $more = $obj->where($where)->value('more');
        if (!empty($more)) {
            $result = json_decode($more, true);
        }
    } elseif ($data == 'all') {
        $result = $obj->where($where)->find();
        if (!empty($result)) {
            $result['more'] = json_decode($result['more'], true);
        }
    }

    return $result;
}

/*
 * JSON
 * json_decode(json,true) 为true时返回array而非object
 */
function lothar_toJson($code = 0, $msg = '', $url = null, $data = '', $wait = 3)
{
    if (is_array($code)) {
        $result = json_encode($code);
    } else {
        $result = json_encode([
            'code' => $code,
            "msg"  => $msg,
            "data" => $data,
            "url"  => $url,
            'wait' => $wait,
        ]);
    }

    return $result;
}

/*弹窗*/
function lothar_popup($msg = '', $code = 1, $url = null, $data = '', $wait = 3)
{
    $result = [
        'code' => $code,
        "msg"  => $msg,
        "data" => $data,
        "url"  => $url,
        'wait' => $wait,
    ];

    $ViewTemplate = View::instance(Config::get('template'), Config::get('view_replace_str'));

    return $ViewTemplate->fetch('public@/popup', $result);
    // return $ViewTemplate->fetch(Config::get('dispatch_success_tmpl'), $result);
}

/*缩略图生成*/
function lothar_thumb_url($imgpath, $width = 350, $height = 350)
{
    if (strpos($imgpath,'http')===0) {
        return $imgpath;
    } else if (strpos($imgpath, "/") === 0) {
        return cmf_get_domain() . $imgpath;
    }

    $avatarPath = "./upload/" . $imgpath;
    $fileArr    = pathinfo($avatarPath);
    $filename   = $fileArr['dirname'] . $fileArr['filename'] . "-" . $width . "-" . $height . ".jpg";
    if (file_exists($filename)) {
        $url = $filename;
    } else {
        $avatarImg = Image::open($avatarPath);
        $avatarImg->thumb($width, $height)->save($filename);
        $url = $filename;
    }
    $url = request()->domain() . $url;

    return $url;
}

/**
 * 格式化数字
 * number_format()
 * @param  string $value [description]
 * @return [type]        [description]
 */
function lothar_num_format($value = '')
{
    if (is_numeric($value)) {
        return round($value, 2);
        // return sprintf("%.2f", $value);// 0.01;
    } else {
        return $value;
    }
}
