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
        $field = 'a.*,b.name AS model_name,d.user_nickname AS buyer_nickname,d.user_login AS buyer_login,f.user_nickname AS deal_nickname,f.user_login AS deal_login,g.name AS servicePoint,g.ucs_x,g.ucs_y,h.name AS company_name';
        $join = [
            ['service_category b','a.model_id=b.id','LEFT'],
            // ['usual_company c','a.company_id=c.id','LEFT'],
            ['user d','a.user_id=d.id','LEFT'],
            // ['user e','a.seller_uid=e.id','LEFT'],
            ['user f','a.deal_uid=f.id','LEFT'],
            ['usual_coordinate g','a.service_point=g.id','LEFT'],
            ['usual_company h','g.company_id=h.id','LEFT'],
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
        $uid = $this->getUid($uname);
        if (!empty($uid)) {
            $where['a.user_id'] = $uid;
        }

        // 关键词
        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['a.description'] = ['like', "%$keyword%"];
        }

        // 排序
        $order = empty($order) ? 'a.is_top DESC,a.id DESC' : $order;

        // 数据量
        $limit = $this->limitCom($limit);

        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order($order)
            // ->fetchSql(true)->find();
            ->paginate($limit);

        return $series;
    }

    public function getPost($id)
    {
        // $field = 'a.*,b.name model_name,c.name company_name,d.user_nickname buyer_nickname,d.user_login buyer_login,e.user_nickname seller_nickname,e.user_login seller_login';
        $field = 'a.*,b.name model_name,d.user_nickname AS buyer_nickname,d.user_login AS buyer_login,g.name AS servicePoint,g.ucs_x,g.ucs_y,h.name AS company_name';
        $join = [
            ['service_category b','a.model_id=b.id','LEFT'],
            // ['usual_company c','a.company_id=c.id','LEFT'],
            ['user d','a.user_id=d.id','LEFT'],
            // ['user e','a.seller_uid=e.id','LEFT'],
            ['usual_coordinate g','a.service_point=g.id','LEFT'],
            ['usual_company h','g.company_id=h.id','LEFT'],
        ];

        // $where = ['a.id' => $id];
        // $post = $this->get($id)->toArray();
        $post = $this->alias('a')
            ->field($field)
            ->join($join)
            ->where('a.id',$id)
            ->find();
        if (!empty($post['buyer_login'])) {
            $post['buyer_username'] = $post['buyer_nickname'] ? $post['buyer_nickname'] : $post['buyer_login'];
        }
        if (!empty($post['seller_login'])) {
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