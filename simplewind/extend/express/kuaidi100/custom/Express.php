<?php
namespace express\kuaidi100\custom;

/**
* 快递100 自定义接口
* 接口与key的使用办法(Key适用于以下两种接口）：
    1、快递查询API（适用于除EMS、顺丰、申通、圆通、中通、韵达之外的公司，可自定义公司与单号，返回xml与json数据，有几家快递公司不支持）：http://www.kuaidi100.com/openapi/api_post.shtml
    2、HtmlAPI（适用于所有包括EMS、顺丰、申通、圆通、中通、韵达在内的公司，可自定公司与单号，请求后返回一个url，需要通过iframe来嵌套该url来显示最终结果，结果下方有快递100手机端的广告banner）：http://www.kuaidi100.com/download/html_api(20140729).doc
    3、如果既希望支持所有的公司又能返回XML/JSON数据，还没有次数与频率的限制，需要转用另一种方案，要了解或开通请直接至 http://www.kuaidi100.com/openapi/applypoll.shtml【企业版】下提交申请，提交后5分钟内给您发电子邮件，您收到邮件后阅读详细说明并按说明操作即可。也可咨询企业QQ：800036857 转“小佰”
* 常见物流公司代码：
    shentong 申通(HtmlAPI)
    shunfeng 顺丰(HtmlAPI)
    shunfengen 顺丰（英文结果）(HtmlAPI)
    yuantong 圆通速递(HtmlAPI)
    yunda 韵达快运(HtmlAPI)
    zhongtong 中通速递(HtmlAPI)

    huitongkuaidi 百世汇通
    guotongkuaidi 国通快递
    huitongkuaidi 汇通快运
    tiantian 天天快递
    zhaijisong 宅急送
    ems EMS(中文结果)(HtmlAPI)
    youzhengguonei 国内邮件(HtmlAPI)
    youzhengguonei 邮政小包（国内），邮政包裹（国内）、邮政国内给据（国内）(HtmlAPI)

    tiandihuayu 天地华宇
    ##rrs 日日顺
    debangwuliu 德邦物流
    tiandihuayu 华宇物流
*/
class Express
{
    private $api_url = 'http://api.kuaidi100.com/api?';
    var $p_set = [];
    function __construct($p_set)
    {
        $this->p_set = $p_set;
    }

    /**
    * 快递单号查询
    * http://api.kuaidi100.com/api?id=[]&com=[]&nu=[]&valicode=[]&show=[0|1|2|3]&muti=[0|1]&order=[desc|asc]
    * id 身份授权key。您在http://kuaidi100.com/app/reg.html申请到的KEY
    * com 要查询的快递公司代码，不支持中文
    * nu 要查询的快递单号，请勿带特殊符号，不支持中文（大小写不敏感）
    * show 返回类型：0:返回json字符串，1:返回xml对象，2:返回html对象，3:返回text文本。如果不填，默认返回json字符串。
    * muti 返回信息数量：0:只返回一行信息，1:返回多行完整的信息。不填默认返回多行。
    * order 排序：desc:按时间由新到旧排列，asc:按时间由旧到新排列。不填默认返回倒序（大小写不敏感）
    * valicode 已弃用字段，无意义，请忽略。
    * 
    * @param string $AppKey 身份授权key
    * @param string $typeCom 快递公司代码
    * @param string $typeNu 快递单号
    * 
    * @return json|xml|html|text 
    * com 物流公司编号
    * nu  物流单号
    * time 每条跟踪信息的时间
    * context 每条跟综信息的描述
    * state 快递单当前的状态：
        0：在途，即货物处于运输过程中
        1：揽件，货物已由快递公司揽收并且产生了第一条跟踪信息
        2：疑难，货物寄送过程出了问题
        3：签收，收件人已签收
        4：退签，即货物由于用户拒签、超区等原因退回，而且发件人已经签收
        5：派件，即快递正在进行同城派件
        6：退回，货物正处于退回发件人的途中
    * status 查询结果状态：0：物流单暂无结果。1：查询成功。2：接口出现异常。
    * message   无意义，请忽略
    * condition   无意义，请忽略
    * ischeck 无意义，请忽略
    */
    public function orderQuery($typeCom='', $typeNu='')
    {
        $url = 'http://api.kuaidi100.com/api?';
        $url .= 'id='. $this->p_set['AppKey']
                .'&com='. $typeCom
                .'&nu='. $typeNu
                .'&show='. $this->p_set['show']
                .'&muti='. $this->p_set['muti']
                .'&order='. $this->p_set['order'];

        //请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
        $powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';

        //优先使用curl模式发送数据
        if (function_exists('curl_init') == 1){
          $curl = curl_init();
          curl_setopt ($curl, CURLOPT_URL, $url);
          curl_setopt ($curl, CURLOPT_HEADER,0);
          curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
          curl_setopt ($curl, CURLOPT_TIMEOUT,5);
          $get_content = curl_exec($curl);
          curl_close ($curl);
        } else {
          include("snoopy.php");
          $snoopy = new snoopy();
          $snoopy->referer = 'http://www.google.com/';//伪装来源
          $snoopy->fetch($url);
          $get_content = $snoopy->results;
        }

        return $get_content;
        // return [$get_content,$powered];
        // print_r($get_content . '<br/>' . $powered);
        // exit();
    }

    public function FunctionName($value='')
    {
        # code...
    }
}
?>