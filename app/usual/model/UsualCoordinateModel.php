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

    public function getCoordinates($selectId=0, $companyId=0, $default_option=false)
    {
        $where = ['status' => 1];
        if (!empty($companyId)) {
            $where = array_merge($where,['company_id'=>$companyId]);
        }
        // $data = $this->all()->toArray();
        $data = $this->field(['id','name','ucs_x','ucs_y'])
            ->where($where)
            ->order('id')
            ->select()->toArray();
        $options = $default_option ?'<option value="0">--请选择--</option>':'';
        if (is_array($data)) {
            foreach ($data as $v) {
                $options .= '<option value="'.$v['id'].'" '.($selectId==$v['id']?'selected':'').' >'.$v['name'].'</option>';
            }
        }
        return $options;
    }

    public function getPostList($where=[], $order=[], $limit=12)
    {
        $where = array_merge(['status' => 1],$where);
        $order = array_merge($order,['id'=>'DESC']);

        $lists = $this->field('id,ucs_x,ucs_y,remark')
            ->where($where)
            ->order($order)
            ->limit($limit)
            ->select()->toArray();
            // ->paginate($limit);

        return $lists;
    }
}