<?php
namespace app\funds\model;

use think\Db;
use app\usual\model\UsualModel;

class UserFundsLogModel extends UsualModel
{
    public function getLists($filter=[], $order='', $limit='3', $extra=[])
    {
        $where = [];
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }

        // 更多
        if (!empty($filter['userId'])) {
            $where['user_id'] = intval($filter['userId']);
        }
        if (!empty($filter['type'])) {
            $where['type'] = $filter['type'];
        }
        // 创建时间
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
        // 关键词
        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['app'] = ['like', "%$keyword%"];
        }

        // 排序
        $order = empty($order) ? 'id DESC' : $order;

        // 数据量
        $limit = empty($limit) ? config('pagerset.size') : $limit;

        $series = $this->where($where)->order($order)->paginate($limit);

        return $series;
    }

    public function getTypes($selectId=0, $parentId=0, $option='')
    {
        $options = $this->getStatus($selectId,'funds_type');
        return $options;
    }

    // 统计 余额
    public function sumCoin($uid=0, $type='', $startTime=0, $compare='')
    {
        $where = [];
        if (!empty($uid)) {
            $where['user_id'] = $uid;
        }
        if (!empty($type)) {
            if (is_numeric($type)) {
                $where['type'] = $type;
            } else {
                 $where['type'] = ['in',$type];
            }
        }
        if (!empty($startTime)) {
            $where['create_time'] = ['>= time', $startTime];
        }
        if (!empty($compare)) {
            $where['coin'] = [$compare,0];
        }

        $sum = Db::name('user_funds_log')->where($where)->sum('coin');
        return $sum;
    }

}