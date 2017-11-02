<?php
namespace app\service\model;

use think\Model;
// use app\usual\model\UsualModel;

class ServiceModel extends Model
{
    public function getLists($filter, $isPage = false)
    {
        $field = 'a.*,b.name cate_name';
        $where = ['a.delete_time' => 0];
        $join = [
            ['service_category b','a.model_id=b.id','LEFT'],
        ];

        // 模型
        if (!empty($filter['modelId'])) {
            $where['a.model_id'] = $filter['modelId'];
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
        // 公司
        // 用户
        $uname = empty($filter['uname']) ? '' : $filter['uname'];
        if (!empty($uname)) {
            $uid = intval($uname);
            if (empty($uid)) {
                $uid = Db::name('user')->whereOr(['user_nickname|user_login|user_email|mobile'=>$uname])->value('id');
                $uid = intval($uid);
            }
            $where['a.buyer_uid'] = $uid;
        }
        // 关键词
        $sn = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($sn)) {
            $where['a.description'] = ['like', "%$keyword%"];
        }

        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order('a.id DESC')
            ->paginate(5);

        return $series;
    }

    public function getPost($id)
    {
        // $post = $this->get($id)->toArray();
        $field = 'a.*,b.name car_name,c.user_nickname buyer_nickname,d.user_nickname seller_nickname,e.title pay_name';
        // $where = ['a.id' => $id];
        $join = [
            ['usual_car b','a.car_id=b.id','LEFT'],
            ['user c','a.buyer_uid=c.id','LEFT'],
            ['user d','a.seller_uid=d.id','LEFT'],
            ['plugin e','a.pay_id=e.name','LEFT']
        ];
        $post = $this->alias('a')
            ->field($field)
            ->join($join)
            ->where('a.id',$id)
            ->find();
        $post['buyer_username'] = $post['buyer_nickname'] ? $post['buyer_nickname'] : $post['buyer_username'];
        $post['seller_username'] = $post['seller_nickname'] ? $post['seller_nickname'] : $post['seller_username'];
        return $post;
    }
}