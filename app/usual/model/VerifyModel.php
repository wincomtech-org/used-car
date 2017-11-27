<?php
namespace app\usual\model;

use think\Db;
// use think\Model;
use app\usual\model\UsualModel;

class VerifyModel extends UsualModel
{
    public function getLists($filter, $isPage = false)
    {
        $field = 'a.*,b.name model_name,c.user_nickname,c.user_login';
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
        if (!empty($uname)) {
            $uid = intval($uname);
            if (empty($uid)) {
                $uid = Db::name('user')->whereOr(['user_nickname|user_login|user_email|mobile'=>$uname])->value('id');
                $uid = intval($uid);
            }
            $where['a.user_id'] = $uid;
        }

        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order('a.is_top DESC,a.id DESC')
            ->paginate(config('pagerset.size'));

        return $series;
    }

    public function getPost($id)
    {
        // $post = $this->get($id)->toArray();
        // $field = 'a.*,b.name model_name,c.name company_name,d.user_nickname buyer_nickname,d.user_login buyer_login,e.user_nickname seller_nickname,e.user_login seller_login';
        $field = 'a.*,b.name model_name,c.user_nickname,c.user_login';
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
        $post['username'] = $post['user_nickname'] ? $post['user_nickname'] : $post['user_login'];

        return $post;
    }

    public function getVerifyStatus($status='')
    {
        return $this->getStatus($status,'verify_status');
    }

    // 获取用户认证资料
    public function userCertiSta($uid=0, $type='certification', $extra=null)
    {
        if ($extra!==null) {
            if (is_bool($extra)) {
                $data = $this->where(['user_id'=>$uid,'auth_code'=>$type])->find();
                // $identi = Db::name('verify')->where(['user_id'=>$user['id'],'auth_code'=>'certification'])->find();
            } else {
                $data = $this->where($extra)->find();
            }
        } else {
            $data = Db::name('verify')->where(['user_id'=>$uid,'auth_code'=>$type])->value('auth_status');
        }
        return $data;
    }



}