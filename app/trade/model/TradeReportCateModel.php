<?php
namespace app\trade\model;

use app\usual\model\UsualCategoryModel;
use tree\Tree;

class TradeReportCateModel extends UsualCategoryModel
{
    public function getCategoryTree($selectId=0, $currentCid=0, $parentId=0, $codeType=false, $default_option=true, $tpl='')
    {
        $where = [
            'delete_time'=>0,
            'parent_id'=>['egt',$parentId],
        ];
        if (!empty($currentCid)) {
            $where['id'] = ['neq', $currentCid];
        }
        if ($codeType===true) {
            $where['code_type'] = ['like',['all','select','radio','checkbox'],'OR'];
        }
        $categories = $this->order("list_order ASC")->where($where)->select()->toArray();
        if (empty($categories)) return;
        // $newCategories = [];
        // foreach ($categories as $item) {
        //     $item['selected'] = $selectId == $item['id'] ? "selected" : "";
        //     array_push($newCategories, $item);
        // }

        $tree       = new Tree();
        $tree->icon = ['&nbsp;&nbsp;│', '&nbsp;&nbsp;├─', '&nbsp;&nbsp;└─'];
        $tree->nbsp = '&nbsp;&nbsp;';
        $tree->init($categories);
        // $tree->init($newCategories);

        if (empty($tpl)) {
            $tpl = "<option value=\$id \$selected>\$spacer\$name</option>";
            // $tpl = '<option value=\"{$id}\" {$selected}>{$spacer}{$name}</option>';
        }

        $treeStr = $tree->getTree(0, $tpl, $selectId);
        // $treeStr = $tree->getTree(0, $tpl);
        $treeStr = ($default_option ?'<option value="0">--请选择--</option>':'') . $treeStr;

        return $treeStr;
    }

    public function getCodeType($selectId=null, $parentId=0, $default_option=true, $tpl='')
    {
        $type = config('usual_item_cate_codetype');
        $tpl = $default_option ? '<option value="all">默认</option>':'';
        foreach ($type as $key => $v) {
            $tpl .= '<option value="'.$key.'" '.(empty($selectId)&&$key=='text'?'selected':($selectId==$key?'selected':'')).'>'.$v.'</option>';
        }

        return $tpl;
        // return $this->getStatus($status,'usual_item_cate_codetype');
    }

    public function getCate($selectId=0, $parentId=0, $option='')
    {
        $data = $this->field('id,name')->where('parent_id',$parentId)->select()->toArray();
        return $this->createOptions($selectId, $option, $data);
    }


}