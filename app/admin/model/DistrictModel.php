<?php
namespace app\admin\model;

use think\Model;

/**
* 地区模型
*/
class DistrictModel extends Model
{
    public function getdistricts($parentId=1, $selectId=0, $default_option=false, $level=1)
    {
        // $districts = $this->all()->toArray();
        $districts = $this->field('id,name')->where('parent_id',$parentId)->select()->toArray();
        $options = $default_option ?'<option value="0">--请选择--</option>':'';
        if (is_array($districts)) {
            foreach ($districts as $v) {
                $options .= '<option value="'.$v['id'].'" '.($selectId==$v['id']?'selected':'').' >'.$v['name'].'</option>';
            }
        }
        return $options;
    }

}