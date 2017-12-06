<?php
namespace app\service\model;

use think\Db;
// use think\Model;
use app\usual\model\UsualModel;

class ServiceModel extends UsualModel
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function getLists($filter=[], $order='', $limit='', $extra=[])
    {
        $field = 'a.*,b.name AS model_name,c.name AS company_name,d.user_nickname AS buyer_nickname,d.user_login AS buyer_login,f.user_nickname AS deal_nickname,f.user_login AS deal_login';
        $join = [
            ['service_category b','a.model_id=b.id','LEFT'],
            ['usual_company c','a.company_id=c.id','LEFT'],
            ['user d','a.user_id=d.id','LEFT'],
            // ['user e','a.seller_uid=e.id','LEFT'],
            ['user f','a.deal_uid=f.id','LEFT'],
        ];


        // 筛选条件
        $where = ['a.delete_time' => 0];
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }

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

        // 排序
        // $order = empty($order) ? 'is_top DESC,is_rec DESC,update_time DESC' : $order;

        // 数据量
        // $limit = empty($limit) ? config('pagerset.size') : $limit;

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
        $field = 'a.*,b.name model_name,c.name company_name,d.user_nickname buyer_nickname,d.user_login buyer_login,g.name AS servicePoint';
        // $where = ['a.id' => $id];
        $join = [
            ['service_category b','a.model_id=b.id','LEFT'],
            ['usual_company c','a.company_id=c.id','LEFT'],
            ['user d','a.user_id=d.id','LEFT'],
            // ['user e','a.seller_uid=e.id','LEFT'],
            ['usual_coordinate g','a.service_point=g.id','LEFT'],
        ];
        $post = $this->alias('a')
            ->field($field)
            ->join($join)
            ->where('a.id',$id)
            ->find();
        if (!empty($post)) {
            $post['buyer_username'] = $post['buyer_nickname'] ? $post['buyer_nickname'] : $post['buyer_login'];
            $post['seller_username'] = $post['seller_nickname'] ? $post['seller_nickname'] : $post['seller_login'];
        }

        return $post;
    }

    public function getServiceStatus($status='')
    {
        return $this->getStatus($status,'service_status');
    }



/*前台*/
    // 用户提交预约单
    public function addAppoint($post)
    {
        $data = [
            'create_time'   => time(),
        ];
        $data = array_merge($data,$post);

        $this->allowField(true)->data($data, true)->isUpdate(false)->save();
        // $data['more'] = json_encode($data['more']);
        // $id = Db::name("service")->insertGetId($data);

        return $this->id;
        // return $id;
        // return $this->adminAddArticle($data);
    }
}