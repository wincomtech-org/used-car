<?php
namespace app\insurance\model;

// use think\Model;
use think\Db;
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
            ->paginate(5);

        return $series;
    }

    public function getInsurance($selectId = 0, $companyID)
    {
        $where = ['delete_time' => 0];
        if (isset($companyID)&&$companyID>0) {
            $where = ['company_id'=>$companyID];
        }
        $categories = Db::name('insurance')->field('id,name')->order("list_order ASC")->where($where)->select()->toArray();
        $options = '';
        foreach ($categories as $item) {
            $options .= '<option value="'.$item['id'].'" '.($selectId==$item['id']?'selected':'').'>'.$item['name'].'</option>';
        }

        return $options;
    }

}

