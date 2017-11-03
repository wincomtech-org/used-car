<?php
namespace app\usual\model;

use app\usual\model\UsualModel;

class UsualCarModel extends UsualModel
{
    public function getLists($filter)
    {
        $field = 'a.*,b.name AS bname,c.name AS cname,d.name AS dname,e.name ename,f.user_nickname,f.user_login';
        $where = ['a.delete_time' => 0];
        $join = [
            ['usual_brand b','a.brand_id=b.id','LEFT'],
            ['usual_series c','a.serie_id=c.id','LEFT'],
            ['usual_models d','a.model_id=d.id','LEFT'],
            ['district e','a.model_id=e.id','LEFT'],
            ['user f','a.user_id=f.id','LEFT']
        ];
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

        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['a.name'] = ['like', "%$keyword%"];
        }

        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order('update_time DESC')
            ->paginate(config('pagerset.pagesize'));

        return $series;
    }

}