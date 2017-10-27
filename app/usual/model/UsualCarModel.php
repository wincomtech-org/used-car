<?php
namespace app\usual\model;

use app\usual\model\UsualModel;

class UsualCarModel extends UsualModel
{
    public function getLists($filter)
    {
        $field = 'a.*';
        $where = ['a.delete_time' => 0];
        $join = [
            ['insurance b','a.insurance_id=b.id'],
            ['usual_car c','a.car_id=c.id'],
            ['user AS d','a.user_id=d.id']
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
            ->join($join)
            ->where($where)
            ->order('update_time DESC')
            ->paginate(5);

        return $series;
    }

}