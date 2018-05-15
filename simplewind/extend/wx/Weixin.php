<?php
namespace wx;

/**
 * Request对象是受保护的
 * 需要在微型公众号里进行配置的项
    1、进入公众平台测试账号：登录公众账号=>“开发者中心”=>“公众平台测试账号”。
    2、配置网页授权（配置域名）: 开发 => 接口权限 => 网页服务 => 网页账号（网页授权，网页授权获取用户基本信息，不带http,二级域名即可）
        OAuth2.0网页授权    www.datongchefu.cn

    
    3、微信公众号接口必须以http://或https://开头，分别支持80端口和443端口。
    4、接口配置信息
        请填写接口配置信息，此信息需要你有自己的服务器资源，填写的URL需要正确响应微信发送的Token验证，请阅读消息接口使用指南。
        URL      http://www.datongchefu.cn/token.php
        Token    datong
    5、JS接口安全域名
        设置JS接口安全域后，通过关注该测试号，开发者即可在该域名下调用微信开放的JS接口，请阅读微信JSSDK开发文档。
        域名     http://www.datongchefu.cn
 */
class Weixin
{
    public function __construct()
    {
        $this->set = array(
            'appid'  => 'wx49d2b7814205f354', //第三方用户唯一凭证
            'secret' => 'c7fc916c313f96a1ba23fca4509f14cf', //第三方用户唯一凭证密钥，即appsecret
        );
        $this->config = array(
            'curl_proxy_host' => '0.0.0.0', //106.14.74.155
            'curl_proxy_port' => 0, //8080
        );
        // $this->access_token = '9_1DG6upsA7sZZH6A86A_UALWMwjTin_h9uUL4xE6nmINEiYf7YKFsofzKcNjpO1ZKZZfSV4qfh74-DJCpzHfzcHoKpmp5QmWW4qUcncnWFgZbgUFcEXs-jpGjQR43wfhpJNDsRydbs26qUVJIZSBgACAMFO';
        $this->access_token = $this->getToken();
    }

    /**
     * 获取openid
     * 会跳转一次
     * GET模式 array(1) { ["s"]=> string(20) "/test/test/openid" }
     * @param string $backUrl
     * 获取到code重定向到获取openid页面，可以是当前位置，也可以是其它位置
     * 为空时指向它自己
     * $backUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].'/index.php');
     * $backUrl = urlencode(url('test/Test/back','',true,true));
     * @return [type] [description]
     */
    public function getOpenid($backUrl = '')
    {
        // $openid = session('openid');
        // if (empty($openid)) {
            $param = request()->param();
            if (!isset($param['code'])) {
                //触发微信返回code码
                if (!empty($backUrl)) {
                    $backUrl = urlencode($backUrl);
                }
                // 获得一个鉴权链接
                $urlObj["appid"]         = $this->set['appid'];
                $urlObj["redirect_uri"]  = $backUrl;
                $urlObj["response_type"] = 'code';
                //$scope='snsapi_userinfo';//需要授权
                $urlObj["scope"] = "snsapi_base";
                $urlObj["state"] = "STATE" . "#wechat_redirect";
                // 拼接字符串
                $buff = $this->ToUrlParams($urlObj);
                // redirect_uri参数错误时，检查OAuth2.0网页授权的授权回调页面域名写对没。
                $url = "https://open.weixin.qq.com/connect/oauth2/authorize?" . $buff;
                Header("Location: $url"); // 跳转到微信授权页面，需要用户确认登录的页面
                exit();
            } else {
                //获取code码，以获取openid
                // $param = 'http://***?code=071SplLS0BpikX1bZYJS0G3lLS0SplLQ&state=STATE';
                $code   = $param['code'];
                $openid = $this->getOpenidFromMp($code);
                // session('openid',$openid);
            }
        // }
        return $openid;
    }

    /**
     * signature 签名验证
     * https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421135319
     * 开发者通过检验signature对请求进行校验（下面有校验方式）。若确认此次GET请求来自微信服务器，请原样返回echostr参数内容，则接入生效，成为开发者成功，否则接入失败。
     * signature    微信加密签名，signature结合了开发者填写的token参数和请求中的timestamp参数、nonce参数。
     * timestamp    时间戳
     * nonce    随机数
     * echostr  随机字符串
     * @return [type] [description]
     */
    public function checkSignature($token = 'lothar')
    {
        // define("TOKEN", "weixin");
        // 1. 将 timestamp,nonce,token 按照字典排序
        $param     = request()->param();
        $timestamp = $param['timestamp'];
        $nonce     = $param['nonce'];
        $signature = $param['signature'];
        $tmpArr    = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);

        // 2.将排序后的三个参数拼接后用sha1加密
        $hashcode = implode($tmpArr);
        $hashcode = sha1($hashcode);

        // 3. 将加密后的字符串与 signature 进行对比, 判断该请求是否来自微信
        if ($hashcode == $signature) {
            echo $param['echostr'];exit;
        }
    }

    /**
     * 基础支持: 获取access_token接口 /token
     * https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140183
     * @param  array  $set [description]
     * @return [type]      [description]
     */
    public function getToken($set = [])
    {
        // cache('weixin',null);//测试时用
        // 可以使用 session()为每个用户做标记,但没有过期设置
        $wxcache = cache('weixin');
        if (empty($wxcache['access_token'])) {
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential';
            $set = $this->set;

            $param = '&appid=' . $set['appid'] . '&secret=' . $set['secret'];
            $url .= $param;

            $output  = $this->http_post($url);
            $wxcache = json_decode($output, true);
            if (isset($wxcache['access_token'])) {
                cache('weixin', $wxcache, $wxcache['expires_in']); //默认7200s失效
            } else {
                return null;
            }
        }
        return $wxcache['access_token'];
    }
    public function getToken2($set = [])
    {
        $wxcache = session('weixin');
        $reget = empty($wxcache['access_token']) && (time()-$wxcache['starttime']>7199);
        if ($reget) {
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential';
            $set = $this->set;

            $param = '&appid=' . $set['appid'] . '&secret=' . $set['secret'];
            $url .= $param;

            $output  = $this->http_post($url);
            $wxcache = json_decode($output, true);
            if (isset($wxcache['access_token'])) {
                $wxcache['starttime'] = time();
                session('weixin', $wxcache);
            } else {
                return null;
            }
        }
        return $wxcache['access_token'];
    }

    /*
     * ---------------------------------------------------------------
     * 基础支持
     * ----------------------------------------------------------------
     */
    /**
     * 基础支持: 多媒体文件上传接口 /media/upload
     * @param $type [image,voice,video,thumb]
     * @param string $value [description]
     */
    public function upload($type = 'image')
    {
        $url = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?';
        // $param = [
        //     'access_token' => $this->access_token,
        //     'type'         => $type,
        //     'media'        => '',
        // ];
        // $param = $this->ToUrlParams($param);
        // $url .= $param;
    }

    /**
     * 基础支持: 下载多媒体文件接口 /media/get
     * @param string $value [description]
     */
    public function download($value = '')
    {
        $url          = 'http://file.api.weixin.qq.com/cgi-bin/media/get?';
        $access_token = $this->access_token;
        $media_id     = '';
        $param        = 'access_token=' . $access_token . '&media_id=' . $media_id;
    }

    /**
     * 基础支持: 上传logo接口 /media/uploadimg
     * @param string $value [description]
     */
    public function uploadimg($value = '')
    {
        $url = 'http://api.weixin.qq.com/cgi-bin/media/uploadimg?';
        $url .= 'access_token=' . $this->access_token . '&type=image';
    }

    /**
     * 向用户发送消息: 发送客服消息接口 /message/custom/send
     * @param string $value [description]
     */
    public function messageSend($value = '')
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?';
        $url .= 'access_token=' . $this->access_token;
    }

    /*用户管理*/
    /**
     * 用户管理: 获取用户基本信息接口 /user/info
     * @param  string $openid [description]
     * @return [type]         [description]
     */
    public function userInfo($openid = '', $token = '')
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?';

        if (empty($openid)) {
            // 先获取openid，因为有重定向
            $back = url('test/Test/userInfo', '', true, true);
            // $openid = 'osOyyw4YQfxpf2x2rstcBltxMo3s';
            $openid = $this->getOpenid($back);
        }
        if (empty($token)) {
            $token  = $this->getToken();
        }

        $param = 'access_token=' . $token . '&openid=' . $openid;
        $url .= $param;

        $user_info = $this->http_post($url);
        return $user_info;
    }

    /**
     * 用户管理: 获取关注者列表接口 /user/get
     * @param string $value [description]
     */
    public function userGet()
    {
        $url   = 'https://api.weixin.qq.com/cgi-bin/user/get?';
        $token = $this->getToken();

        $param = 'access_token=' . $token . '&next_openid=';
        $url .= $param;

        $gets = $this->http_post($url);
        return $gets;
    }

    /**
     * 用户管理: 查询分组接口 /groups/get
     * @param string $value [description]
     */
    public function getGroups()
    {
        $url   = 'https://api.weixin.qq.com/cgi-bin/groups/get?';
        $param = 'access_token=' . $this->access_token;
        $url .= $param;

        $gets = $this->http_post($url);
        return $gets;
    }

    /*自定义菜单*/
    /**
     * 自定义菜单创建接口 /menu/create
     * @param string $value [description]
     */
    public function menuCreate()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?';
        $url .= 'access_token=' . $this->access_token;

    }
    /**
     * 自定义菜单查询接口 /menu/get
     * @param string $value [description]
     */
    public function menuGet()
    {
        $access_token = '';
        $url          = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=' . $this->access_token;
        $gets         = $this->http_post($url);
        return $gets;
    }
    /**
     * 自定义菜单删除接口 /menu/delete
     * @param string $value [description]
     */
    public function menuDel()
    {
        $url = '';
    }

    /**
     * 推广支持: 创建二维码ticket接口 /qrcode/create
     * @param string $value [description]
     */
    public function qrcodeCreate()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?';
        $url .= 'access_token=' . $this->access_token;
    }

    /**
     * 推广支持: 换取二维码 /showqrcode
     * @param string $value [description]
     */
    public function showqrcode()
    {
        $ticket = $this->qrcodeCreate();
        $url    = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $ticket;
    }

    /**
     * 消息推送
     * @param string $value [description]
     */
    public function msg($value = '')
    {
        # code...
    }
    /**
     * 文本消息
     * ToUserName  开发者微信号
     * FromUserName    发送方帐号（一个OpenID）
     * CreateTime  消息创建时间 （整型）
     * MsgType text
     * Content 文本消息内容
     * MsgId   消息id，64位整型
     * @param string $value [description]
     */
    public function msgText($value = '')
    {
        $xml = "<xml><ToUserName><![CDATA[toUser] ]></ToUserName>  <FromUserName>< ![CDATA[fromUser] ]></FromUserName>  <CreateTime>1348831860</CreateTime>  <MsgType>< ![CDATA[text] ]></MsgType>  <Content>< ![CDATA[this is a test] ]></Content>  <MsgId>1234567890123456</MsgId></xml>";
    }
    /**
     * 地理位置消息
     * ToUserName   开发者微信号
     * FromUserName    发送方帐号（一个OpenID）
     * CreateTime  消息创建时间 （整型）
     * MsgType location
     * Location_X  地理位置维度
     * Location_Y  地理位置经度
     * Scale   地图缩放大小
     * Label   地理位置信息
     * MsgId   消息id，64位整型
     * @param string $value [description]
     */
    public function msgSite($value = '')
    {
        $xml = "<xml><ToUserName>< ![CDATA[toUser] ]></ToUserName><FromUserName>< ![CDATA[fromUser] ]></FromUserName><CreateTime>1351776360</CreateTime><MsgType>< ![CDATA[location] ]></MsgType><Location_X>23.134521</Location_X><Location_Y>113.358803</Location_Y><Scale>20</Scale><Label>< ![CDATA[位置信息] ]></Label><MsgId>1234567890123456</MsgId></xml>";
    }
    /**
     * 链接消息
     * ToUserName  接收方微信号
     * FromUserName    发送方微信号，若为普通用户，则是一个OpenID
     * CreateTime  消息创建时间
     * MsgType 消息类型，link
     * Title   消息标题
     * Description 消息描述
     * Url 消息链接
     * MsgId   消息id，64位整型
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function msglink($value = '')
    {
        $xml = "<xml><ToUserName>< ![CDATA[toUser] ]></ToUserName><FromUserName>< ![CDATA[fromUser] ]></FromUserName><CreateTime>1351776360</CreateTime><MsgType>< ![CDATA[link] ]></MsgType><Title>< ![CDATA[公众平台官网链接] ]></Title><Description>< ![CDATA[公众平台官网链接] ]></Description><Url>< ![CDATA[url] ]></Url><MsgId>1234567890123456</MsgId></xml>";
    }

    /**
     * 关注微信公众号
     * @param string $value [description]
     */
    public function guanzhu($value = '')
    {
        # code...
    }

    /**
     * 微信授权登录
     * @param string $value [description]
     */
    public function accessLogin($value = '')
    {
        # code...
    }

    /*
     * -----------------------------------------------------------------
     * ----------------------------------------------------------------
     */

    /**
     *
     * 通过code从工作平台获取openid机器access_token
     * @param string $code 微信跳转回来带上的code
     *
     * @return openid
     */
    public function GetOpenidFromMp($code)
    {
        $url    = 'https://api.weixin.qq.com/sns/oauth2/access_token?';
        $set    = $this->set;
        $urlObj = array(
            'appid'      => $set['appid'],
            'secret'     => $set['secret'],
            'code'       => $code,
            'grant_type' => 'authorization_code',
        );
        $bizString = $this->ToUrlParams($urlObj);
        $url .= $bizString;

        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($this->config['curl_proxy_host'] != '0.0.0.0' && $this->config['curl_proxy_port'] != 0) {
            curl_setopt($ch, CURLOPT_PROXY, $this->config['curl_proxy_host']);
            curl_setopt($ch, CURLOPT_PROXYPORT, $this->config['curl_proxy_port']);
        }
        //运行curl，结果以json形式返回
        $res = curl_exec($ch);
        curl_close($ch);
        //取出openid
        $data = json_decode($res, true);

        $openid = null;
        // 防止重复获取
        if (isset($data['openid'])) {
            $openid = $data['openid'];
        }

        return $openid;
    }

    /**
     * 通用 CURL 操作
     * @param [type] $url [description]
     * @param array $data [description]
     * @return [type]     [description]
     */
    public function http_post($url, $data = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $SSL = substr($url, 0, 8) == "https://" ? true : false;
        if ($SSL) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名
        }
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    /**
     *
     * 拼接签名字符串
     * @param array $urlObj
     *
     * @return 返回已经拼接好的字符串
     */
    public function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v) {
            if ($k != "sign") {
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    public function transCoding($str = '', $code = 'UTF-8')
    {
        $encode = mb_detect_encoding($str, array("ASCII", "GB2312", "BIG5", "GBK", "UTF-8"));
        if ($encode != $code) {
            // $str = iconv("GBK",$code,$str);
            $str = mb_convert_encoding($str, $code, "GBK");
        }

        return $str;
    }
}