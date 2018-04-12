// +----------------------------------------------------------------------
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\portal\controller;
use cmf\controller\HomeBaseController;
use think\db;
/*处理每日定时任务  */
class TimeController extends HomeBaseController
{
    /*处理每日定时任务，crontab每3秒执行一次  */
    /*
     * 获取创业板、深圳、上海股票大盘指数
     * 接口：http://hq.sinajs.cn/list=
     * 参数含义
    var hq_str_s_sh000001="上证指数,3094.668,-128.073,-3.97,436653,5458126";
    数据含义分别为：指数名称，当前点数，当前价格，涨跌率，成交量（手），成交额（万元）；
     * 单个获取
    string(60) "var hq_str_s_sh000001="上证指数,3190.3216,0.0000,0.00,0,0";
    "
     * 获取多个
    string(168) "var hq_str_s_sh000001="上证指数,3190.3216,0.0000,0.00,0,0";
    var hq_str_s_sz399001="深证成指,0.00,0.000,0.00,0,0";
    var hq_str_s_sz399006="创业板指,0.00,0.000,0.00,0,0";
    "
     */
    public function indice()
    {
        $m = Db::name('stock_indice');
        //上证指数、深证成指、创业板指
        $url = 'http://hq.sinajs.cn/list=s_sh000001,s_sz399001,s_sz399006';

        // $content=zz_curl($url);
        // $content = cmf_curl_get($url);
        $content = file_get_contents($url);
        $data    = explode(';', $content);
        unset($data[3]);
        $pattern = '/(?<==").*?(?=")/ism';
        foreach ($data as $key => $val) {
            preg_match($pattern, $val, $arr);
            $tmp    = explode(',', $arr[0]);
            $post[] = [
                'count'   => round($tmp[1], 2),
                'num'     => round($tmp[2], 2),
                'percent' => round($tmp[3], 2),
            ];
            // 不使用模型层时
            // $m->where('id', $key+1)->update([
            //     'count'   => round($tmp[1], 2),
            //     'num'     => round($tmp[2], 2),
            //     'percent' => round($tmp[3], 2),
            // ]);
        }
        dump($post);die;

        // $m->insertAll($post);
        // model('StockIndice')->isUpdate(true)->saveAll($post);
        exit('股市指数获取结束');
    }

    /*处理每日定时任务，crontab每日凌晨1点执行一次  */
    /* 获取股票列表，更新 */
    public function stock_list()
    {
        //股票列表
        $appKey      = '32258';
        $sign        = '813e13dfe768c1d9c75eaaba70d42c1a';
        $nowapi_parm = [
            'app'      => 'finance.stock_list',
            'category' => 'hs',
            'appkey'   => $appKey,
            'sign'     => $sign,
            'format'   => 'json',
        ];
        $result = $this->nowapi_call($nowapi_parm);

        if (empty($result['lists'])) {
            cmf_log('获取股票列表失败', 'stock_list.log');
            exit('获取股票列表错误');
        }
        $data_update = [];
        $data_insert = [];
        $time        = time();
        $m           = Db::name('stock');
        $data0       = $m->column('code0,name');

        foreach ($result['lists'] as $k => $v) {
            if (isset($data0[$v['symbol']])) {
                if ($v['sname'] != $data0[$v['symbol']]) {
                    //股票更名
                    $data_update[$v['symbol']] = $v['sname'];
                }
            } else {
                $data_insert[] = [
                    'code0' => $v['symbol'],
                    'name'  => $v['sname'],
                    'time'  => $time,
                    'code'  => substr($v['symbol'], 2),
                ];
            }

        }
        $row_insert = 0;
        $row_update = count($data_update);
        if (!empty($data_insert)) {
            $row_insert = $m->insertAll($data_insert);
        }

        if (!empty($data_update)) {
            foreach ($data_update as $k => $v) {
                $m->where('code0', $k)->update(['name' => $v, 'time' => $time]);
            }
        }

        cmf_log('获取股票列表执行完成，新增' . $row_insert . '条，更新' . $row_update . '条', 'stock_list.log');
        exit('执行完成');
    }
    public function nowapi_call($a_parm)
    {
        if (!is_array($a_parm)) {
            return false;
        }
        //combinations
        $a_parm['format'] = empty($a_parm['format']) ? 'json' : $a_parm['format'];
        $apiurl           = empty($a_parm['apiurl']) ? 'http://api.k780.com/?' : $a_parm['apiurl'] . '/?';
        unset($a_parm['apiurl']);
        foreach ($a_parm as $k => $v) {
            $apiurl .= $k . '=' . $v . '&';
        }
        $apiurl = substr($apiurl, 0, -1);
        if (!$callapi = file_get_contents($apiurl)) {
            return false;
        }
        //format
        if ($a_parm['format'] == 'base64') {
            $a_cdata = unserialize(base64_decode($callapi));
        } elseif ($a_parm['format'] == 'json') {
            if (!$a_cdata = json_decode($callapi, true)) {
                return false;
            }
        } else {
            return false;
        }
        //array
        if ($a_cdata['success'] != '1') {
            return false;
        }
        return $a_cdata['result'];
    }
}
