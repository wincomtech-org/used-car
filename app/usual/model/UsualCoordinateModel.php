<?php
namespace app\usual\model;

use app\usual\model\UsualModel;

class UsualCoordinateModel extends UsualModel
{
    public function getLists($filter=[])
    {
        $join = [
            ['__SERVICE_CATEGORY__ b', 'a.sc_id = b.id', 'LEFT'],
            // ['__USUAL_COMPANY__ b', 'a.company_id = b.id'],
        ];
        // array_push($join, ['__DISTRICT__ d', 'a.city_id = d.id']);
        // $field = 'a.*,b.name company';
        $field = 'a.*,b.name scname';

        $where = [];
        // 所属公司
        // if (!empty($filter['compId'])) {
        //     $where['a.company_id'] = $filter['compId'];
        // }
        // 所属业务模型
        if (!empty($filter['scId'])) {
            $where['a.sc_id'] = $filter['scId'];
        }
        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['a.remark'] = ['like', "%$keyword%"];
        }

        $series = $this->alias('a')
            ->field($field)
            ->join($join)
            ->where($where)
            ->order('a.sc_id')
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
        $data = $this->field('id,name,ucs_x,ucs_y,tel,addr,remark')
            ->where($where)
            ->order('id')
            ->select()->toArray();

        $options = $this->createOptions($selectId, $option, $data);
        return $options;
    }



// 前台
    /*车业务服务点*/
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