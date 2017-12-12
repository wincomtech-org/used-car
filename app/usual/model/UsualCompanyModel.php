<?php
namespace app\usual\model;

use app\usual\model\UsualModel;

class UsualCompanyModel extends UsualModel
{
    public function getLists($filter=[], $order='', $limit='',$extra=[])
    {
        $field = 'id,name,province_id,city_id,description,update_time,published_time,more,is_baoxian,is_yewu,status,list_order';

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
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }

        $series = $this->alias('a')->field($field)
            ->where($where)
            ->order('update_time DESC')
            ->paginate(config('pagerset.size'));

        return $series;
    }

    public function getCompanys($selectId=0, $parentId=0, $option='')
    {
        $where = ['delete_time' => 0];
        // $data = $this->all()->toArray();
        $data = $this->field(['id','name'])->where($where)->order("list_order ASC")->select()->toArray();

        $options = $this->createOptions($selectId, $option, $data);
        return $options;
    }

    public function getPostList($where=[], $order=[], $limit=12)
    {
        $where = array_merge([
            'delete_time'   => 0,
            // 'is_yewu'       => 1,
            'identi_status' => 1,
            'status'        => 1,
        ],$where);
        $order = array_merge($order,['is_rec'=>'DESC','update_time'=>'DESC']);

        $lists = $this->field('id,name,description,desc2,more')
            ->where($where)
            ->order($order)
            ->limit($limit)
            ->select()->toArray();
            // ->paginate($limit);

        return $lists;
    }
}