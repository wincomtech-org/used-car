<?php
namespace app\usual\model;

use think\Db;
// use think\Model;
use app\usual\model\UsualModel;

class VerifyModel extends UsualModel
{
    public function getLists($filter=[], $order='', $limit='',$extra=[])
    {
        $field = 'a.*,b.name model_name,c.user_nickname,c.user_login,c.user_email,c.mobile';
        $where = [];
        $join = [
            ['verify_model b','a.auth_code=b.code','LEFT'],
            ['user c','a.user_id=c.id','LEFT'],
        ];

        // 模型
        if (!empty($filter['auth_code'])) {
            $where['a.auth_code'] = $filter['auth_code'];
        }
        // 认证状态
        if (!empty($filter['auth_status'])) {
            $where['a.auth_status'] = $filter['auth_status'];
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
        // 用户
        $uname = empty($filter['uname']) ? '' : $filter['uname'];
        $uid = $this->getUid($uname);
        if (!empty($uid)) {
            $where['a.user_id'] = $uid;
        }

        // 数据量
        $limit = $this->limitCom($limit);

        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order('a.is_top DESC,a.id DESC')
            ->paginate($limit);

        return $series;
    }

    public function getPost($id)
    {
        $field = 'a.*,b.name model_name,c.user_nickname,c.user_login,c.user_email,c.mobile';
        // $where = ['a.id' => $id];
        $join = [
            ['verify_model b','a.auth_code=b.code','LEFT'],
            ['user c','a.user_id=c.id','LEFT'],
        ];
        $post = $this->alias('a')
            ->field($field)
            ->join($join)
            ->where('a.id',$id)
            ->find();
        if (!empty($post)) {
            $post = $post->toArray();
        }
        $post['username'] = $this->getUsername($post);

        return $post;
    }

    public function getVerifyStatus($status='')
    {
        return $this->getStatus($status,'verify_status');
    }

    /*
    * 用户认证状态信息
    * @param $uid 默认是当前用户
    * @param $code 默认是实名认证
    * @param $data 是否返回数据集、统计
    * @return boolean or array
    */
    public function outVerify($uid=null, $code='certification', $data='status')
    {
        $result = lothar_verify($uid, $code, $data);
        return $result;
    }

    // 提交认证数据
    public function inVerify($data,$userId)
    {
        # code...
    }


}