<?php
namespace app\admin\model;

use think\Model;
use app\usual\model\UsualModel;

/**
* 地区模型
*/
class DistrictModel extends Model
{
    public function getDistricts($selectId=0, $parentId=1, $option='')
    {
        // if (!empty($selectId)) {
        //     $parentId = $this->where('id',$selectId)->value('parent_id');
        // }
        // $districts = $this->all()->toArray();
        $data = $this->field('id,name')->where('parent_id',$parentId)->select()->toArray();

        $uModel = new UsualModel();
        $options = $uModel->createOptions($selectId, $option, $data);
        return $options;
    }

}