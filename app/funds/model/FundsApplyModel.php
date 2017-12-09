<?php
namespace app\funds\model;

use think\Db;
use app\usual\model\UsualModel;

class FundsApplyModel extends UsualModel
{
    public function getLists($filter=[], $order='', $limit='', $extra=[])
    {
        $field = 'a.*,b.user_nickname,b.user_login,b.user_email,b.mobile';
        $join = [['user b','a.user_id=b.id']];
        $where = [];
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }

        // 更多
        if (!empty($filter['userId'])) {
            $where['a.user_id'] = intval($filter['userId']);
        }
        if (!empty($filter['type'])) {
            $where['a.type'] = $filter['type'];
        }
        // 创建时间
        $startTime = empty($filter['start_time']) ? 0 : strtotime($filter['start_time']);
        $endTime   = empty($filter['end_time']) ? 0 : strtotime($filter['end_time']);
        if (!empty($startTime) && !empty($endTime)) {
            $where['a.create_time'] = [['>= time', $startTime], ['<= time', $endTime]];
        } else {
            if (!empty($startTime)) {
                $where['a.create_time'] = ['>= time', $startTime];
            }
            if (!empty($endTime)) {
                $where['a.create_time'] = ['<= time', $endTime];
            }
        }

        // 用户ID
        if (!empty($filter['user_id'])) {
            $where['a.user_id'] = intval($filter['user_id']);
        }
        // 用户
        $uname = empty($filter['uname']) ? '' : $filter['uname'];
        if (!empty($uname)) {
            $uid = intval($uname);
            if (empty($uid)) {
                $uid = Db::name('user')->whereOr(['user_nickname|user_login|user_email|mobile'=>$uname])->value('id');
                $uid = intval($uid);
            }
            $where['a.user_id'] = $uid;
        }

        // 排序
        $order = empty($order) ? 'a.id DESC' : $order;

        // 数据量
        $limit = empty($limit) ? config('pagerset.size') : $limit;

        $series = $this->alias('a')
                ->field($field)
                ->join($join)
                ->where($where)
                ->order($order)
                ->paginate($limit);
                // ->select()->toArray();
                // ->fetchSql(true)->select();

        return $series;
    }

    public function getPost($id)
    {
        $field = 'a.*,b.user_nickname,b.user_login,b.user_email,b.mobile';
        $join = [['user b','a.user_id=b.id']];

        $post = $this->alias('a')->join($join)->field($field)->where('a.id',$id)->find();
        $post['user_name'] = empty($post['user_nickname']) ? $post['user_login'] : $post['user_nickname'];
        return $post;
    }
}