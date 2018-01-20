<?php
namespace app\trade\model;

use app\usual\model\UsualModel;
use app\trade\model\TradeReportCateModel;
use tree\Tree;

class TradeReportModel extends UsualModel
{
    public function getLists($filter=[], $order='', $limit='',$extra=[])
    {
        $field = 'a.*,b.name AS bname';
        $where = [
            'a.delete_time' => 0
        ];
        $join = [
            ['__USUAL_ITEM_CATE__ b','a.cate_id=b.id','LEFT'],
        ];

        $cateId = empty($filter['cateId']) ? 0 : intval($filter['cateId']);
        if (!empty($cateId)) {
            $where['a.cate_id'] = ['eq', $cateId];
        }

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
            ->join($join)
            ->where($where)
            ->order('is_top DESC,id DESC')
            ->paginate($limit);

        return $series;
    }


}