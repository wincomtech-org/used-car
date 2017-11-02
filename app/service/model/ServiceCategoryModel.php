<?php
namespace app\service\model;

use think\Model;
// use app\usual\model\UsualModel;

class ServiceCategoryModel extends Model
{
    public function getLists($filter, $isPage = false)
    {
        // $categories = $this->field('id,name,description,list_order')->order("list_order ASC")->where($where)->select()->toArray();
        $categories = $this->field('id,name,description,list_order')->order("list_order ASC,id DESC")->paginate(5);
        return $categories;
    }

    public function getCategorys($selectId=0, $parentId=0, $level=1, $default_option=false)
    {
        // $data = $this->all()->toArray();
        $data = $this->field(['id','name'])->select()->toArray();
        $options = $default_option ?'<option value="0">--请选择--</option>':'';
        if (is_array($data)) {
            foreach ($data as $v) {
                $options .= '<option value="'.$v['id'].'" '.($selectId==$v['id']?'selected':'').' >'.$v['name'].'</option>';
            }
        }
        return $options;
    }
}