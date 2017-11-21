<?php
namespace app\usual\model;

use app\usual\model\UsualCategoryModel;
use tree\Tree;

class UsualSeriesModel extends UsualCategoryModel
{
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
        $data = $this->field('id,name')
                ->where(['brand_id'=>$brandId,'is_rec'=>1])
                ->order('list_order')
                ->limit(10)
                ->select()
                ->toArray();

        return $data;
    }
    // 所有车系
    public function SeriesTree($brandId=0)
    {
        $data = $this->field('id,parent_id,name')
                ->where(['brand_id'=>$brandId])
                ->order('list_order')
                ->select()
                ->toArray();

        $ufoTree = [];
        $tree = new Tree();
        // model('admin/NavMenu')->parseNavMenu4Home($data);
        $tree->init($data);
        $ufoTree = $tree->getTreeArray(0);

        return $ufoTree;
    }
}