<?php
namespace app\usual\model;

use app\usual\model\UsualCategoryModel;

class UsualModelsModel extends UsualCategoryModel
{
    //自定义初始化
    protected function initialize()
    {
        //需要调用`Model`的`initialize`方法
        parent::initialize();
        //TODO:自定义的初始化
    }

    public function getModels($selectId=0, $parentId=0, $level=1, $option=false)
    {
        // $data = $this->all()->toArray();
        $data = $this->field(['id','name'])->select()->toArray();
        $options = $option ?'<option value="0">--请选择--</option>':'';
        if (is_array($data)) {
            foreach ($data as $v) {
                $options .= '<option value="'.$v['id'].'" '.($selectId==$v['id']?'selected':'').' >'.$v['name'].'</option>';
            }
        }
        // $options = $this->createOptions($data,$option);
        return $options;
    }
}