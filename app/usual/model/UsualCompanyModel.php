<?php
namespace app\usual\model;

// use think\Db;
// use think\Model;
use app\usual\model\UsualModel;

class UsualCompanyModel extends UsualModel
{
    public function getLists($filter)
    {
        // $join = [
        //     ['__USUAL_MODELS__ m', 'a.model_id = m.id']
        // ];
        // $field = 'a.*,m.name mname';
        // array_push($join, ['__USUAL_BRAND__ b', 'a.brand_id = b.id']);
        // $field .= ',b.id AS bid,b.name bname';
        $field = 'id,name,province_id,city_id,brief,content,update_time,published_time,more,is_baoxian,is_yewu,status,list_order';

        $where = [
            'a.delete_time' => 0
        ];
        $startTime = empty($filter['start_time']) ? 0 : strtotime($filter['start_time']);
        $endTime   = empty($filter['end_time']) ? 0 : strtotime($filter['end_time']);
        if (!empty($startTime) && !empty($endTime)) {
            $where['a.published_time'] = [['>= time', $startTime], ['<= time', $endTime]];
        } else {
            if (!empty($startTime)) {
                $where['a.published_time'] = ['>= time', $startTime];
            }
            if (!empty($endTime)) {
                $where['a.published_time'] = ['<= time', $endTime];
            }
        }

        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['a.name'] = ['like', "%$keyword%"];
        }

        $series = $this->alias('a')->field($field)
            ->where($where)
            ->order('update_time DESC')
            ->paginate(5);

        return $series;
    }

    public function getPost($id)
    {
        $post = $this->get($id)->toArray();
        // $post = model('UsualCompany')->where('id', $id)->find();
        if (isset($post['content'])) {
            $post['content'] = cmf_replace_content_file_url(htmlspecialchars_decode($post['content']));
        }
        if (isset($post['information'])) {
            $post['information'] = cmf_replace_content_file_url(htmlspecialchars_decode($post['information']));
        }
        return $post;
    }

}