<?php
namespace app\insurance\model;

use app\insurance\model\InsuranceModel;
use think\Db;

class InsuranceCoverageModel extends InsuranceModel
{
    public function getLists($filter=[], $order='', $limit='',$extra=[])
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
     * 获取 公用险种
     * ."\r\n"
    */
    public function getCoverage($checkedIds=[], $excludeIds=[])
    {
        $where = ['delete_time' => 0, 'insurance_id' => 0];
        $categories = $this->field('id,name')->order("list_order ASC")->where($where)->select()->toArray();

        $options = '';
        foreach ($categories as $v) {
            $options .= '<label><input type="checkbox" name="post[more][coverage][]" value="'.$v['id'].'" '.(in_array($v['id'],$checkedIds)?'checked':'').'>'. $v['name'] .'</label> &nbsp; &nbsp; ';
        }

        // $options = $this->createOptions($selectId, $option, $data);
        return $options;
    }
    public function getCoverageByOrder($orderId='')
    {
        // $coverIds = model('insurance/InsuranceOrder')->where('id',$orderId)->value('coverIds');
        $coverIds = Db::name('insurance_order')->where('id',$orderId)->value('coverIds');
        $coverIds = json_decode($coverIds,true);
        // ->toArray()
        $coverages = $this->field('id,name')->where(['id'=>['in',$coverIds]])->select();
        return $coverages;
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

    public function fromCateList($Ids=0,$limit=20, $field=',description,duty,compen_item,compen_total,content',$filter=[],$order='is_top DESC')
    {
        $where = [
            'delete_time' => 0,
            'status' => 1,
        ];
        if (is_array($Ids)) {
            $where = array_merge($where,['id'=>['IN',$Ids]]);
        } elseif (is_numeric($Ids)) {
            $where = array_merge($where,['id'=>$Ids]);
        }
        $fo = 'id,type,name,price';
        $field = empty($field) ? $fo : $fo.$field;
        $where = array_merge($where,$filter);

        $list = $this->field($field)
                ->where($where)
                ->order($order)
                ->select()->toArray();

        return $list;
    }

}