<?php
namespace app\service\model;

use think\Db;
// use think\Model;
use app\usual\model\UsualModel;

class ServiceModel extends UsualModel
{
    public function getLists($filter, $isPage = false)
    {
        $field = 'a.*,b.name model_name,c.name company_name,d.user_nickname buyer_nickname,d.user_login buyer_login';
        $where = ['a.delete_time' => 0];
        $join = [
            ['service_category b','a.model_id=b.id','LEFT'],
            ['usual_company c','a.company_id=c.id','LEFT'],
            ['user d','a.user_id=d.id','LEFT'],
            // ['user e','a.seller_uid=e.id','LEFT'],
        ];

        // 模型
        if (!empty($filter['modelId'])) {
            $where['a.model_id'] = $filter['modelId'];
        }
        // 预约时间
        $startTime = empty($filter['start_time']) ? 0 : strtotime($filter['start_time']);
        $endTime   = empty($filter['end_time']) ? 0 : strtotime($filter['end_time']);
        if (!empty($startTime) && !empty($endTime)) {
            $where['a.appoint_time'] = [['>= time', $startTime], ['<= time', $endTime]];
        } else {
            if (!empty($startTime)) {
                $where['a.appoint_time'] = ['>= time', $startTime];
            }
            if (!empty($endTime)) {
                $where['a.appoint_time'] = ['<= time', $endTime];
            }
        }
        // 公司
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
        // 关键词
        $sn = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($sn)) {
            $where['a.description'] = ['like', "%$keyword%"];
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
        $field = 'a.*,b.name model_name,c.name company_name,d.user_nickname buyer_nickname,d.user_login buyer_login';
        // $where = ['a.id' => $id];
        $join = [
            ['service_category b','a.model_id=b.id','LEFT'],
            ['usual_company c','a.company_id=c.id','LEFT'],
            ['user d','a.user_id=d.id','LEFT'],
            // ['user e','a.seller_uid=e.id','LEFT'],
        ];
        $post = $this->alias('a')
            ->field($field)
            ->join($join)
            ->where('a.id',$id)
            ->find();
        $post['buyer_username'] = $post['buyer_nickname'] ? $post['buyer_nickname'] : $post['buyer_login'];
        // $post['seller_username'] = $post['seller_nickname'] ? $post['seller_nickname'] : $post['seller_login'];

        return $post;
    }

    public function getServiceStatus($status='')
    {
        return $this->getStatus($status,'service_status');
    }
}