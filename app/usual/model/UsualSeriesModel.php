<?php
namespace app\usual\model;

use app\usual\model\UsualCategoryModel;
use tree\Tree;
use think\Db;

class UsualSeriesModel extends UsualCategoryModel
{
    public function getLists($filter=[], $order='', $limit='',$extra=[])
    {
        $field = 'a.id,a.parent_id,a.name,a.description,a.is_rec,a.list_order,b.name bname';
        $join = [['usual_brand b','a.brand_id=b.id','LEFT']];

        // 筛选条件
        $where = ['a.delete_time' => 0];
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }
        // 更多

        // 后台
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
            $find = Db::name('usual_brand')->where('name','like',"%$keyword%")->find();
            if (!empty($find)) {
                $filter['brandId'] = $find['id'];
                $where['b.name'] = ['like', "%$keyword%"];
            } else {
                $where['a.name'] = ['like', "%$keyword%"];
            }
        }
        if (!empty($filter['brandId'])) {
            $where['a.brand_id'] = $filter['brandId'];
        }

        // 排序
        $order = empty($order) ? 'a.list_order,a.brand_id' : $order;

        // 数据量
        $limit = empty($limit) ? config('pagerset.size') : $limit;

        // 查数据
        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order($order)
            ->paginate($limit);

        return $series;
    }

    public function getSeries($selectId=0, $parentId=0, $level=1, $default_option=false)
    {
        if (!empty($selectId)) {
            $pid = $this->where(['id'=>$selectId])->value('parent_id');
            if (!empty($pid)) {
                if ($level==1) {
                    $selectId = $pid;
                    $pid = $this->where(['id'=>$pid])->value('parent_id');
                }
            } else {
                if ($level==2) {
                    $pid = $selectId;
                    $selectId = 0;
                }
            }
        } else {
            if (!empty($parentId)) {
                $pid = $parentId;
            } else {
                if ($level==1) {
                    $pid = $parentId;
                } elseif ($level==2) {
                    $pid = -1;
                }
            }
        }
        // if (!empty($selectId) && $parentId!=0) {
        //     $pid = $this->where(['id'=>$selectId])->value('parent_id');
        // } else {
        //     $pid = $parentId;
        // }
        // if (!empty($pid) && $parentId===true) {
        //     $selectId = $pid;
        //     $pid = $this->where(['id'=>$pid])->value('parent_id');
        // }
        // if (empty($this->get(['parent_id'=>$selectId]))) {
        //     return '';
        // }
        // $data = $this->all()->toArray();
        $data = $this->field(['id','name'])->where(['parent_id'=>$pid])->select()->toArray();

        $options = $default_option ?'<option value="0">--请选择--</option>':'';
        if (is_array($data)) {
            foreach ($data as $v) {
                $options .= '<option value="'.$v['id'].'" '.($selectId==$v['id']?'selected':'').' >'.$v['name'].'</option>';
            }
        }
        // $options = $this->createOptions($selectId, $option, $data);
        return $options;
    }



/*前台*/
    // 车辆列表页
    // 推荐车系
    public function recSeries($brandId=0)
    {
        $where = ['is_rec'=>1];
        if (!empty($brandId)) {
            $where = array_merge(['brand_id'=>$brandId],$where);
        }
        $data = $this->field('id,name')
                ->where($where)
                ->order('list_order')
                ->limit(10)
                ->select()
                ->toArray();

        return $data;
    }
    // 所有车系
    public function SeriesTree($brandId=0,$recursive=true)
    {
        $where = [];
        if (!empty($brandId)) {
            $where = ['brand_id'=>$brandId];
        }
        if (empty($recursive)) {
            $where = array_merge($where,['parent_id'=>['neq',0]]);
            // $where = array_merge($where,['parent_id'=>['gt',0]]);
        }
        $data = $this->field('id,parent_id,name')
                ->where($where)
                ->order('list_order')
                ->select()
                ->toArray();

        if ($recursive) {
            $ufoTree = [];
            $tree = new Tree();
            // model('admin/NavMenu')->parseNavMenu4Home($data);
            $tree->init($data);
            $ufoTree = $tree->getTreeArray(0);

            return $ufoTree;
        }

        return $data;
    }
}