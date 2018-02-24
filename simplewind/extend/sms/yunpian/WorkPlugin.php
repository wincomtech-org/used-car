<?php
namespace sms\yunpian;

// use express\kuaidi100\custom\Express;
// import('sms/yunpian/custom/coreFunc',EXTEND_PATH);

/**
* 快递接口
*/
class WorkPlugin
{
    var $plugin_id = 'yunpian'; // 插件唯一ID
    private $p_set = [];
    private $notify_url = '';
    private $return_url = '';
    private $dir = '';// getcwd()
    private $host = '';

    public function __construct($typeCom='', $typeNu='')
    {
        $this->typeCom = $typeCom;//公司代码
        $this->typeNu = $typeNu;//运单号
        // $this->p_set = $set;
    }

    public function work()
    {
        return '云片';
    }

    /*配置信息*/
    public function p_set() {

        $set['AppKey'] = '82df35706dd02098';// 身份授权key
        $set['Binding_domain'] = 'http://usedcar.wincomtech.cn';// 绑定的域名

        // 返回类型：0返回json字符串，1返回xml对象，2返回html对象，3返回text文本。如果不填，默认返回json字符串。
        $set['show'] = 2;

        // 返回信息数量：0:只返回一行信息，1:返回多行完整的信息。不填默认返回多行。
        $set['muti'] = 1;

        // 排序：desc：按时间由新到旧排列，asc：按时间由旧到新排列。不填默认返回倒序（大小写不敏感）
        $set['order'] = 'desc';

        return $set;
    }

    /*请求参数*/
    public function parameter()
    {
        $set = $this->p_set();

        $param['AppKey']    = $set['AppKey'];
        $param['typeCom']   = $this->typeCom;
        $param['typeNu']    = $this->typeNu;

        return $param;
    }
}