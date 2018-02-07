<?php
namespace app\usual\model;

use app\usual\model\UsualCategoryModel;
use tree\Tree;

class UsualItemCateModel extends UsualCategoryModel
{
    public function getLists($filter=[], $order='', $limit='',$extra=[])
    {
        $field = 'id,parent_id,path,name,unit,code,code_type,description,is_rec,status,list_order';

        // 筛选条件
        $where = [];
        // 后台
        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['a.name'] = ['like', "%$keyword%"];
        }
        // 更多
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }
        $myId = isset($filter['parent']) ? intval($filter['parent']) : 0;

        // 排序
        $order = empty($order) ? 'list_order' : $order;

        // 数据量
        // $limit = $this->limitCom($limit);

        // 查数据
        $series = $this->field($field)
                ->where($where)
                ->order($order)
                ->select()
                ->toArray();
                // ->paginate($limit);

        $cateTree = [];
        $tree = new Tree();
        // model('admin/NavMenu')->parseNavMenu4Home($series);
        $tree->init($series);
        $cateTree = $tree->getTreeArray($myId);

        return $cateTree;
    }

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
        if (empty($categories)) return null;
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

    public function getFirstCate($selectId=0, $parentId=0, $option='全部', $condition=[])
    {
        $where = [];
        $where = [
            // 'delete_time' => 0,
            'parent_id' => $parentId,
            'status' => 1,
        ];
        if (!empty($condition)) {
            $where = array_merge($where,$condition);
        }

        // $data = $this->all()->toArray();
        $data = $this->field('id,name')->where($where)->select()->toArray();

        $options = $this->createOptions($selectId, $option, $data);
        return $options;
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



}