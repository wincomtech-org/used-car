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
        $limit = $this->limitCom($limit);

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
        if (!empty($post)) {
            $post = $post->toArray();
        }
        $post['user_name'] = $this->getUsername($post);

        return $post;
    }

    // 统计
    public function counts($userId,$type='status',$extra=[])
    {
        if ($type=='time') {
            $time = [mktime(0, 0, 0, date('m'), date('d'), date('Y')),mktime(23, 59, 59, date('m'), date('d'), date('Y'))];
            $where = [
                'user_id'       => $userId,
                'create_time'   => [['>= time', $time[0]], ['<= time', $time[1]]]
            ];
        } else {
            $where = ['user_id'=>$userId,'status'=>0];
        }
        $count = $this->where($where)->count();
        return $count;
    }

    // 提现操作
    public function wdCancel($value='')
    {
        $transStatus = true;
        Db::startTrans();
        try{
            // $id = Db::name('usual_car')->insertGetId($post);
            // identi 需要被序列化，用模型处理
            // $result = model('usual/UsualCar')->adminAddArticle($post);
            // $id = $result->id;
            // $log = [
            //     'title' => '预约保险',
            //     'object'=> 'insurance_order:'.$id,
            //     'content'=>'客户ID：'.$userInfo['id'].'，保单ID：'.$id,
            //     'adminurl'=>5,
            // ];
            // $log = model('usual/News')->newsObject('wdCancel', $id, $userInfo['id']);
            // lothar_put_news($log);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $transStatus = false;
            // throw $e;
        }
    }


}