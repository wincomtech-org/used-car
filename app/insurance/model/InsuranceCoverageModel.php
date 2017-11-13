<?php
namespace app\insurance\model;

use app\insurance\model\InsuranceModel;

class InsuranceCoverageModel extends InsuranceModel
{
    public function getLists($filter)
    {
        $field = 'a.*,b.name AS bname,c.name AS cname';
        $where = [
            'a.delete_time' => 0
        ];
        $join = [
            ['__INSURANCE__ b','a.insurance_id=b.id','LEFT'],
            ['__USUAL_COMPANY__ c','b.company_id=c.id','LEFT']
        ];

        $insuranceId = empty($filter['insuranceId']) ? 0 : intval($filter['insuranceId']);
        if (!empty($insuranceId)) {
            $where['a.insurance_id'] = ['eq', $insuranceId];
        }
        $companyId = empty($filter['companyId']) ? 0 : intval($filter['companyId']);
        if (!empty($companyId)) {
            $where['b.company_id'] = ['eq', $companyId];
        }

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
            ->paginate(config('pagerset.size'));

        return $series;
    }

    /*
     * 获取 险种
     * ."\r\n"
    */
    public function getCoverage($checkedIds=[], $excludeIds=[])
    {
        $where = ['delete_time' => 0, 'insurance_id' => 0];
        $categories = model('InsuranceCoverage')->field('id,name')->order("list_order ASC")->where($where)->select()->toArray();

        $options = '';
        foreach ($categories as $v) {
            $options .= '<label><input type="checkbox" name="post[more][coverage][]" value="'.$v['id'].'" '.(in_array($v['id'],$checkedIds)?'checked':'').'>'. $v['name'] .'</label> &nbsp; &nbsp; ';
        }

        return $options;
    }



// 前台
    /*首页*/
    public function getIndexCoverageList($limit=3)
    {
        $ckey = 'gicoveragel'.$limit;

        $lists = cache($ckey);
        if (empty($lists)) {
            $lists = $this->field('id,name,description,more')
                    ->where('status',1)
                    ->order('is_rec desc,id')
                    ->limit($limit)
                    ->select()->toArray();
            cache($ckey, $lists, 3600);
        }

        return $lists;
    }

}