<?php
namespace app\trade\model;

use app\usual\model\UsualModel;

class TradeAttrModel extends UsualModel
{
    // protected $filter_var = config('usual_car_filter_var');
    protected $filter_var = 'car_gearbox,car_effluent,car_fuel,car_color';

    /*function _initialize()
    {
        parent::_initialize();
        // $this->filter_var = config('usual_car_filter_var');
    }*/

    public function getLists($filter=[], $order='', $limit='',$extra=[])
    {
        $field = 'a.*';
        $where = [
            'a.delete_time' => 0
        ];

        $startTime = empty($filter['start_time']) ? 0 : strtotime($filter['start_time']);
        $endTime   = empty($filter['end_time']) ? 0 : strtotime($filter['end_time']);
        if (!empty($startTime) && !empty($endTime)) {
            $where['a.update_time'] = [['>= time', $startTime], ['<= time', $endTime]];
        } else {
            if (!empty($startTime)) {
                $where['a.update_time'] = ['>= time', $startTime];
            }
            if (!empty($endTime)) {
                $where['a.update_time'] = ['<= time', $endTime];
            }
        }

        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['a.name'] = ['like', "%$keyword%"];
        }

        // 数据量
        $limit = $this->limitCom($limit);

        $series = $this->alias('a')->field($field)
            // ->join($join)
            ->where($where)
            ->order('a.is_top DESC,a.id DESC')
            ->paginate($limit);

        return $series;
    }
    /*
     * 获取 属性
     * ."\r\n"
    */
    public function getItems($selectId=0, $cateId=0, $option='请选择')
    {
        $where = ['cate_id'=>$cateId,'status'=>1];
        $data = $this->field('id,name,description')->where($where)->order('is_top','desc')->select()->toArray();

        $options = $this->createOptions($selectId, $option, $data);
        return $options;
    }


}