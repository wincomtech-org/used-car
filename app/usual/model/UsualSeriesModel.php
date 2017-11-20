<?php
namespace app\usual\model;

use app\usual\model\UsualCategoryModel;

class UsualSeriesModel extends UsualCategoryModel
{
    //自定义初始化
    // protected function initialize()
    // {
    //     //需要调用`Model`的`initialize`方法
    //     parent::initialize();
    //     //TODO:自定义的初始化
    // }

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
        // $options = $this->createOptions($data,$option);
        return $options;
    }

}