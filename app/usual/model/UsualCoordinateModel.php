<?php
namespace app\usual\model;

use app\usual\model\UsualModel;

class UsualCoordinateModel extends UsualModel
{
    public function getLists($filter=[], $order='', $limit='',$extra=[])
    {
        $field = 'a.*,b.name company,c.name scname';
        $join = [
            ['__USUAL_COMPANY__ b', 'a.company_id=b.id', 'LEFT'],
            ['__SERVICE_CATEGORY__ c', 'a.sc_id=c.id', 'LEFT']
        ];

        $where = [];
        // 所属公司
        if (!empty($filter['compId'])) {
            // $field .= ',b.name company';
            // $join = array_merge($join,['__USUAL_COMPANY__ b', 'a.company_id=b.id', 'LEFT']);
            // array_push($join,['__USUAL_COMPANY__ b', 'a.company_id=b.id', 'LEFT']);
            $where['a.company_id'] = $filter['compId'];
        }
        // 所属业务模型
        if (!empty($filter['scId'])) {
            $where['a.sc_id'] = $filter['scId'];
        }
        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['a.remark'] = ['like', "%$keyword%"];
        }

        // 数据量
        $limit = $this->limitCom($limit);

        $series = $this->alias('a')
            ->field($field)
            ->join($join)
            ->where($where)
            ->order('a.sc_id')
            // ->fetchSql(true)->select();
            ->paginate($limit);

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
        $where = array_merge(['status'=>1],$where);
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