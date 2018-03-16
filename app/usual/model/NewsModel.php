<?php
namespace app\usual\model;

// use app\usual\model\UsualModel;
use think\Model;
use think\Db;

class NewsModel extends Model
{
    // protected $type = [
    //     'more' => 'array',
    // ];
    // 开启自动写入时间戳字段
    // protected $autoWriteTimestamp = true;
    // function setCreateTimeAttr($value){ return strtotime($value);}

    public function getLists($filter=[], $order='', $limit='',$extra=[])
    {
        // $field = 'id,user_id,deal_uid,title,object,action,app,adminurl,create_time,content,status';

        // 筛选条件
        $where = [];
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }
        // 更多
        if (!empty($filter['status'])) {
            $where['status'] = $filter['status'];
        }
        if (!empty($filter['appId'])) {
            $where['app'] = $filter['appId'];
        }
        if (!empty($filter['userId'])) {
            $where['user_id'] = $filter['userId'];
        }
        $startTime = empty($filter['start_time']) ? 0 : strtotime($filter['start_time']);
        $endTime   = empty($filter['end_time']) ? 0 : strtotime($filter['end_time']);
        if (!empty($startTime) && !empty($endTime)) {
            $where['create_time'] = [['>= time', $startTime], ['<= time', $endTime]];
        } else {
            if (!empty($startTime)) {
                $where['create_time'] = ['>= time', $startTime];
            }
            if (!empty($endTime)) {
                $where['create_time'] = ['<= time', $endTime];
            }
        }
        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['title'] = ['like', "%$keyword%"];
        }

        // 排序
        $order = empty($order) ? 'id DESC' : $order;

        // 数据量
        $limit = model('usual/Usual')->limitCom($limit);

        // 查数据
        $series = $this->where($where)->order($order)->paginate($limit);

        return $series;
    }

    // 获取单条数据
    public function getPost($id)
    {
        $field = 'a.*,b.user_nickname,b.user_login,b.user_email,b.mobile';
        $join = [
            ['user b','a.user_id=b.id','LEFT'],
            // ['user e','a.deal_uid=e.id','LEFT'],
        ];
        $data = $this->alias('a')
            ->field($field)
            ->join($join)
            ->where('a.id',$id)
            ->find();
        if (!empty($data)) {
            $data = $data->toArray();
        }
        $data['username'] = model('Usual')->getUsername($data);

        // 处理对象操作地址
        $objurl = config('news_adminurl')[$data['adminurl']];
        if (!empty($data['object'])) {
            # insurance_order:1
            $objId = explode(':',$data['object'])[1];
            $data['objurl'] = cmf_url($objurl, ['id'=>$objId]);
        }

        return $data;
    }

    // 新增 系统消息
    public function inNews($data=[])
    {
        return lothar_put_news($data);
    }

    // 获取 系统消息
    public function outNews($type='')
    {
        return lothar_get_news($type);
    }

    public function getStatus($status='',$config=null)
    {
        $ufoconfig = empty($config) ? [0=>'未读',1=>'已读',2=>'已处理'] : config($config);
        $options = '';
        foreach ($ufoconfig as $key => $vo) {
            $options .= '<option value="'.$key.'" '.($status==$key?'selected':'').'>'.$vo.'</option>';
        }

        return $options;
    }

    // 获取筛选下拉框
    public function cateOptions($selectId=null, $option='请选择')
    {
        $data = $this->distinct(true)->field('app')->select()->toArray();
        $setName = [
            'trade'     => '车辆买卖',
            'insurance' => '保险模块',
            'service'   => '车辆业务',
            'register'  => '注册',
            'user'      => '用户中心',
            'funds'     => '资金管理',
        ];

        if ($option===false) {
            return $data;
        } else {
            $options = (empty($option)) ? '':'<option value="">--'.$option.'--</option>';
            if (is_array($data)) {
                foreach ($data as $row) {
                    $options .= '<option value="'.$row['app'].'" '.($selectId==$row['app']?'selected':'').' >'.$setName[$row['app']].'</option>';
                }
            }
            return $options;
        }
    }

    // 统计
    public function newsCounts($status='')
    {
        if (empty($status)) {
            $count[0] = Db::name('news')->where('status',0)->count();
            $count[1] = Db::name('news')->where('status',1)->count();
            $count[2] = Db::name('news')->where('status',2)->count();
        } elseif ($status==0) {
            $count[0] = Db::name('news')->where('status',0)->count();
            $count[1] = $count[2] = 0;
        } elseif ($status==1) {
            $count[1] = Db::name('news')->where('status',1)->count();
            $count[0] = $count[2] = 0;
        } elseif ($status==2) {
            $count[2] = Db::name('news')->where('status',2)->count();
            $count[0] = $count[1] = 0;
        }

        return $count;
    }

    /**
     * [newsObject 获取消息数组、组装] [参看 PayModel.php]
     * @param  string $obj [对象类型] 
     * [seecar:seeCar,openshop:deposit,recharge:recharge,insurance:insurStep6,] 
     * [insurance:insurStep2,regCar:regCar,service:service,withdraw:withdraw] 
     * [register:doRegister]
     * @param  string $oid [订单ID] 
     * @return [array]      [返回数据集] 
     * $status = lothar_put_news($log);
     * config('news_adminurl');
     */
    public function newsObject($obj='', $oid='', $uid='',$extra=[])
    {
        //动态数据应该尽量都是从外部传进来
        $uid = empty($uid) ? cmf_get_current_user_id() : $uid;

        $log = [];
        // 下面是用于支付的
        switch ($obj) {
            case 'seeCar': 
                $log = [
                    'title'     => '预约看车',
                    'object'    => 'trade_order:'. $oid,
                    'content'   => '用户ID：'.$uid,
                    'adminurl'  => 1,
                    'app'       => 'trade',
                ];
                break;
            case 'deposit': 
                $log = [
                    'title'     => '开店申请',
                    'object'    => 'funds_apply:'. $oid,
                    'content'   => '用户ID：'.$uid,
                    // 'content'   => '客户ID：'.$userId .'，支付方式：'.config('payment')[$paytype],
                    'adminurl'  => 8,
                    'app'       => 'trade',
                ];
                break;
            case 'recharge':  //user_funds_log
                $log = [
                    'title'     => '用户充值',
                    'object'    => 'funds_apply:'. $oid,
                    'content'   => '用户ID：'.$uid,
                    'adminurl'  => 9,
                    'app'       => 'funds',
                ];
                break;
            case 'insurStep6': // v2中已弃用
                $log = [
                    'title'     => '预约保险',
                    'object'    => 'insurance_order:'. $oid,
                    'content'   => '保单ID：'.$oid.'，客户ID：'.$uid,
                    'adminurl'  => 2,
                    'app'       => 'insurance',
                ];
                break;
            case 'insurStep2': 
                $log = [
                    'title'     => '保险订单',
                    'object'    => 'insurance_order:'. $oid,
                    'content'   => '保单ID：'.$oid.'，客户ID：'.$uid,
                    'adminurl'  => 2,
                    'app'       => 'insurance',
                ];
                break;
            case 'shop': 
                $log = [
                    'title'     => '服务商城订单',
                    'object'    => 'shop_order:'. $oid,
                    'content'   => '订单ID：'.$oid.'，客户ID：'.$uid,
                    'adminurl'  => 10,
                    'app'       => 'shop',
                ];
                break;
            // 下面是不用付钱的
            case 'regCar': 
                $log = [
                    'title'     => '免费登记卖车信息',
                    'object'    => 'usual_car:'. $oid,
                    'content'   => '车子ID：'.$oid.'，客户ID：'.$uid,
                    'adminurl'  => 1,
                    'app'       => 'trade',
                ];
                break;
            case 'service': 
                $log = [
                    'title'     => '预约车辆服务：'. $extra['name'],
                    'object'    => 'service:'. $oid,
                    'content'   => '服务点ID：'.$extra['service_point'].'，客户ID：'.$uid,
                    'adminurl'  => 3,
                    'app'       => 'service',
                ];
                break;
            case 'withdraw':
                $log = [
                    'title'     => '提现申请',
                    'object'    => 'funds_apply:'.$oid,
                    'adminurl'  => 5,
                    'app'       => 'funds',
                ];
                break;
            case 'register':
                $log = [
                    'title'     => '用户注册：'. $extra['username'],
                    'object'    => 'user:'. $uid,
                    'content'   => '用户ID：'. $uid,
                    'adminurl'  => 4,
                    'app'       => 'register',
                ];
                break;
        }

        $log['user_id'] = $uid;
        $log['action'] = $obj;

        return $log;
    }

}