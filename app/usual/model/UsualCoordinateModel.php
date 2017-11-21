<?php
namespace app\usual\model;

use app\usual\model\UsualModel;

class UsualCoordinateModel extends UsualModel
{
    public function getLists($filter)
    {
        $join = [
            ['__USUAL_COMPANY__ b', 'a.company_id = b.id']
        ];
        // array_push($join, ['__DISTRICT__ d', 'a.city_id = d.id']);
        $field = 'a.*,b.name company';

        $where = [];

        if (!empty($filter['compId'])) {
            $where['a.company_id'] = $filter['compId'];
        }
        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['a.remark'] = ['like', "%$keyword%"];
        }

        $series = $this->alias('a')
            ->field($field)
            ->join($join)
            ->where($where)
            ->order('a.company_id')
            ->paginate(config('pagerset.size'));

        return $series;
    }

    public function getCoordinates($selectId=0, $condition=[], $option='请选择')
    {
        $where = ['status' => 1];
        if (!empty($condition)) {
            $where = array_merge($where,$condition);
        }
        // $data = $this->all()->toArray();
        $data = $this->field(['id','name','ucs_x','ucs_y'])
            ->where($where)
            ->order('id')
            ->select()->toArray();

        $options = $this->createOptions($selectId, $option, $data);
        return $options;
    }



// 前台
    /*车业务服务*/
    public function getPostList($where=[], $order=[], $limit=12)
    {
        $where = array_merge(['status' => 1],$where);
        $order = array_merge($order,['id'=>'DESC']);

        $lists = $this->field('id,name,ucs_x,ucs_y,remark')
            ->where($where)
            ->order($order)
            ->limit($limit)
            ->select()->toArray();
            // ->paginate($limit);

        return $lists;
    }
}