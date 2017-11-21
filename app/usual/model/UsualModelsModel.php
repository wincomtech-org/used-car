<?php
namespace app\usual\model;

use app\usual\model\UsualCategoryModel;

class UsualModelsModel extends UsualCategoryModel
{
    public function getModels($selectId=0, $parentId=0, $option='')
    {
        // $data = $this->all()->toArray();
        $data = $this->field(['id','name'])->select()->toArray();

        $options = $this->createOptions($selectId, $option, $data);
        return $options;
    }
}