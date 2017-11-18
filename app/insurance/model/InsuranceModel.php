<?php
namespace app\insurance\model;

use think\Db;
use app\usual\model\UsualModel;

class InsuranceModel extends UsualModel
{
    public function getLists($filter)
    {
        $field = 'a.*,b.name AS bname';
        $where = [
            'a.delete_time' => 0
        ];

        $companyId = empty($filter['companyId']) ? 0 : intval($filter['companyId']);
        if (!empty($companyId)) {
            $where['a.company_id'] = ['eq', $companyId];
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
            ->join('__USUAL_COMPANY__ b','a.company_id=b.id','LEFT')
            ->where($where)
            ->order('a.update_time DESC')
            ->paginate(config('pagerset.size'));

        return $series;
    }

    public function getInsurance($selectId=0, $companyId=0)
    {
        $where = ['delete_time' => 0];
        if ($companyId>0) {
            $where = ['company_id'=>$companyId];
        }
        $categories = Db::name('insurance')->field('id,name')->order("list_order ASC")->where($where)->select()->toArray();
        $options = '';
        foreach ($categories as $item) {
            $options .= '<option value="'.$item['id'].'" '.($selectId==$item['id']?'selected':'').'>'.$item['name'].'</option>';
        }

        return $options;
    }



// 前台
    /*首页*/
    public function getIndexInsuranceList($limit=4)
    {
        $ckey = 'giinsurancel'.$limit;

        $lists = cache($ckey);
        if (empty($lists)) {
            $lists = $this->field('id,name,description,desc2,more')
                ->where(['delete_time'=>0,'status'=>1,'identi_status'=>1])
                ->order('is_rec desc,published_time desc')
                ->limit($limit)
                ->select()->toArray();
            cache($ckey, $lists, 3600);
        }
        return $lists;
    }

    public function getPostList($where='', $order='', $limit=4)
    {
        $where = array_merge([
            'delete_time'   => 0,
            'status'        => 1,
            'identi_status' => 1,
            'is_rec'        => 1,
        ],$where);
        $order = array_merge($order,['update_time'=>'DESC']);

        $lists = $this->field('id,name,description,desc2,more')
            ->where($where)
            ->order($order)
            ->limit($limit)
            ->select();
            // ->paginate($limit);

        return $lists;
    }
}