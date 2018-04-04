<?php
// \simplewind\cmf\common.php
use think\Config;
use think\Db;
// use think\Route;
use think\Image;
use think\Request;
use think\Url;
use think\View;

// 管理员操作日志
function lothar_admin_log($table='', $obj='', $action='', $description='', $type='goods')
{
    $adminLog = [
        'user_id'     => cmf_get_current_admin_id(),
        'type'        => $type,
        'obj_table'   => $table,
        'obj'         => $obj,
        'action'      => $action,
        'description' => $description,
        'create_time' => time(),
        'ip'          => get_client_ip(),
    ];
    Db::name('admin_log')->insert($adminLog);
}

/* 系统日志 */
// cmf_log()
function lothar_log($str, $filename = 'test.log')
{
    error_log(date('Y-m-d H:i:s') . $str . "\r\n", 3, 'log/' . $filename);
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

/*
 * 文件、图片处理
 * cmf_get_asset_url()
 * cmf_get_image_url()
 * cmf_get_image_preview_url()
 * cmf_get_file_download_url()
 * cmf_get_content_images()
 */

/**
 * 后台 JS 插件 处理上传图片、文件
 * 如何删除照片？在url('user/AdminAsset/index'),但缩略图仍在,可修改源码
 * $style = config('thumbnail_size');
 * 车详情图集 $style = [[580,384]]
 */
function lothar_dealFiles($files = ['names' => [], 'urls' => []], $style = [])
{
    $post = [];
    if (is_array($files)) {
        $names = isset($files['names']) ? $files['names'] : '';
        $urls  = $files['urls'];
        if (!empty($urls)) {
            foreach ($urls as $key => $url) {
                $relative_url = cmf_asset_relative_url($url);
                if (!empty($style)) {
                    $relative_url = lothar_thumb_make($relative_url, $style);
                }
                array_push($post, ["url" => $relative_url, "name" => $names[$key]]);
            }
        }
    } elseif (is_string($files)) {
        $relative_url = cmf_asset_relative_url($files);
        if (!empty($style)) {
            $post = lothar_thumb_make($relative_url, $style);
        }
    } else {
        # code...
    }

    return $post;
}
// 不一样的结构
function lothar_dealFiles2($files = [0 => ['url' => '', 'name' => '']], $style = [])
{
    $post = [];
    if (is_array($files)) {
        foreach ($files as $row) {
            $relative_url = cmf_asset_relative_url($row['url']);
            // dump($relative_url);die;
            if (!empty($style)) {
                $relative_url = lothar_thumb_make($relative_url, $style);
            }
            array_push($post, ["url" => $relative_url, "name" => $row['name']]);
        }
        // dump($post);die;
    } elseif (is_string($files)) {
        $relative_url = cmf_asset_relative_url($files);
        if (!empty($style)) {
            $post = lothar_thumb_make($relative_url, $style);
        }
    } else {
        # code...
    }

    return $post;
}

/**
 * [lothar_thumb_make 缩略图生成]
 * getcwd()
 * 车子、商品图： 565x385 283x195 160x109
 * 车子详情 580x384
 * banner图：
 * @param  string $imgpath [文件源:本地不带http，远程下载处理]
 * @param  array $style   config('thumbnail_size');
 * @param  number $type   [图片处理方式]
 * @return [type]          [description]
 */
function lothar_thumb_make($imgpath = 'http://hcfarm.wincomtech.cn/upload/admin/20180307/dfa2bfa304f350653f2f9389f3bb92f1.jpg', $style = [[600, 480], [600, 481], [601, 481], [602, 481]], $type = 6)
{
    $fork = true;
    // 如果是网络上的 当地址不是真实位置时，无法下载
    if (strpos($imgpath, 'http') === 0) {
        // $dirpath = request()->module().'/'.gmdate("Ymd").'/';
        /*$dirpath = 'test/'.gmdate("Ymd").'/';
        $savepath = $dirpath.time().cmf_random_string().'.jpg';
        if (is_file($imgpath)) {
        lothar_download($imgpath,$savepath);
        $imgpath = $savepath;
        } else {
        $fork = false;
        }*/
        $fork = false;
    } elseif (strpos($imgpath, '/') === 0) {
        $url = cmf_get_domain() . $imgpath;
        return $url;
    }

    if (empty($fork)) {
        $url = $imgpath;
    } else {
        // 预设
        $orginpath = "./upload/" . $imgpath;
        $savepath  = '';

        // 处理 is_file($savepath)
        // $fileArr    = pathinfo($orginpath);
        // $savepath   = $fileArr['dirname'] .'/'. $fileArr['filename'] .'_'. $width .'x'. $height .'.'. $fileArr['extension'];
        if (is_file($orginpath)) {
            foreach ($style as $key => $set) {
                $savepath  = $orginpath . '_' . $key . '.jpg';
                $avatarImg = Image::open($orginpath); //每次重新实例化
                $avatarImg->thumb($set[0], $set[1], $type)->save($savepath);
            }
        }

        // 原图，如果是远程则替换成下载到本地的原始图
        $url = $imgpath;
        // $url = $orginpath;
    }

    return $url;
}

function lothar_thumb_url($imgpath, $width = 135, $height = 135, $type = 6)
{
    if (strpos($imgpath, 'http') === 0) {
        return $imgpath;
    } else if (strpos($imgpath, "/") === 0) {
        return cmf_get_domain() . $imgpath;
    }

    $avatarPath = "./upload/" . $imgpath;
    $fileArr    = pathinfo($avatarPath);
    $filename   = $fileArr['dirname'] . '/' . $fileArr['filename'] . '_' . $width . 'x' . $height . '.' . $fileArr['extension'];
    // $filename = $avatarPath.$width.'x'.$height.'.jpg';
    if (is_file($filename)) {
        $url = $filename;
    } else {
        $avatarImg = Image::open($avatarPath);
        $avatarImg->thumb($width, $height, $type)->save($filename);
        $url = $filename;
    }
    $url = request()->domain() . $url;

    return $url;
}

/* 下载网络文件到本地 */
function lothar_download($url, $path = 'test/1.jpg')
{
    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL, $url);
    // curl_setopt($ch, CURLOPT_POST, 0);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    // $file = curl_exec($ch);
    // curl_close($ch);

    //$filename = pathinfo($url, PATHINFO_BASENAME);
    $path = getcwd() . '/upload/' . $path;
    // $path = './upload/'.$path;
    $dirname = pathinfo($path, PATHINFO_DIRNAME);
    if (!is_dir($dirname)) {
        mkdir($dirname, 0777, true);
    }

    // $resource = fopen($path, 'a');//a w
    // fwrite($resource, $file);
    // fclose($resource);

    // set_time_limit(10);
    $content = file_get_contents($url);
    file_put_contents($path, $content);
}

/*function dlfile($file_url, $save_to)
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch,CURLOPT_URL,$file_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$file_content = curl_exec($ch);
curl_close($ch);
$downloaded_file = fopen($save_to, 'w');
fwrite($downloaded_file, $file_content);
fclose($downloaded_file);
}*/

/* 过滤HTML得到纯文本 */
function lothar_get_content($list, $len = 100)
{
    //过滤富文本
    $tmp = [];
    foreach ($list as $k => $v) {
        $content_01   = $v["content"]; //从数据库获取富文本content
        $content_02   = htmlspecialchars_decode($content_01); //把一些预定义的 HTML 实体转换为字符
        $content_03   = str_replace("&nbsp;", "", $content_02); //将空格替换成空
        $contents     = strip_tags($content_03); //函数剥去字符串中的 HTML、XML 以及 PHP 的标签,获取纯文本内容
        $con          = mb_substr($contents, 0, $len, "utf-8"); //返回字符串中的前100字符串长度的字符
        $v['content'] = $con . '...';
        $tmp[]        = $v;
    }
    return $tmp;
}

/*
 * 发送短信
 * yunpian
 * 惯例
    // vendor('sms/yunpian/WorkPlugin');
    // import('SqlBack',EXTEND_PATH);
    // $yun = new \WorkPlugin();
    // $yun = new yunpian();
    // dump($yun->work('18715511536'));die;
     * json
    // 成功时：{code:0,count:"1",fee:0.05,mobile:18715511536,msg:"发送成功",sid:"22712590140",unit:"RMB"}
    // 手机号为空：{code:2,detail:"参数 mobile 格式不正确，mobile不能为空",http_status_code:400,msg:"请求参数格式错误"}
 * 返回结果说明
    // $result = array(
    //     'code'=>0,
    //     'msg'=>'发送成功',
    //     'count'=>'1',
    //     'fee'=>0.05,
    //     'unit'=>'RMB',
    //     'mobile'=>18715511536,
    //     'sid'=>'22712590140'
    // );

    // dump($result);die;
    // if (!empty($result['code'])) {
    //     $this->success($result['msg']);
    // } else {
    //     $this->success('验证码已经发送成功!');
    // }
 */
function lothar_sms_send($mobile = '18715511536', $text = '')
{
    header("Content-Type:text/html;charset=utf-8");

    // 初始化
    $set = cmf_get_option('sms_yunpian');
    // $apikey = "8d5234d8f9302e69eb75c844fd40871f"; //修改为您的apikey(https://www.yunpian.com)登录官网后获取
    $code = rand(1000, 9999);
    // $_SESSION['sms_code'] = $code;
    session('sms_code', $code);

    // CURL操作
    $ch = curl_init();
    /* 设置验证方式 */
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
    /* 设置返回结果为流 */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    /* 设置超时时间*/
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    /* 设置通信方式 */
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // 数据集 组装
    if (empty($text)) {
        // $text = '【'. $set['sign'] .'】您的验证码是'. $code;
        $text = '【' . $set['sign'] . '】您的验证码是' . $code . '。如非本人操作，请忽略本短信';
    }
    $data = array(
        'mobile' => trim($mobile), //发送对象手机号
        'text'   => $text,
        'apikey' => $set['apikey'],
        // 'apikey' => $apikey,
    );
    curl_setopt($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $json_data = curl_exec($ch);
    $result    = json_decode($json_data, true);

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

/* 为网址补加 http:// */
function lothar_link($link)
{
    //处理网址，补加http://
    $exp = '/^(http|ftp|https):\/\/([\w.]+\/?)\S*/';
    if (preg_match($exp, $link) == 0) {
        $link = 'http://' . $link;
    }
    return $link;
}
