<?php
namespace app\shop\model;

use think\Model;
use app\usual\model\UsualCategoryModel;
use tree\Tree;

/**
* 商品属性模型 cmf_shop_goods_category
*/
class ShopGoodsCategoryModel extends UsualCategoryModel
{
    // 获取列表数据 table表
    public function shopGoodsCategoryTableTree($currentIds=0, $tpl='')
    {
        $where = ['delete_time' => 0];
        // if (!empty($currentCid)) {
        //     $where['id'] = ['neq', $currentCid];
        // }
        $categories = $this->order("list_order ASC")->where($where)->select()->toArray();

        $tree       = new Tree();
        $tree->icon = ['&nbsp;&nbsp;│', '&nbsp;&nbsp;├─', '&nbsp;&nbsp;└─'];
        $tree->nbsp = '&nbsp;&nbsp;';

        if (!is_array($currentIds)) {
            $currentIds = [$currentIds];
        }

        $newCategories = [];
        foreach ($categories as $item) {
            $item['checked'] = in_array($item['id'], $currentIds) ? 'checked' : '';
            $item['url']     = cmf_url('shop/Index/index', ['cateId'=>$item['id']]);
            $item['str_action'] = '<a href="'. url("AdminCategory/add", ["parent" => $item['id']]) . '">添加子分类</a> &nbsp; '
                . '<a href="'. url("AdminCategory/attrs", ["cid" => $item['id']]) . '">查看关联属性</a> &nbsp; '
                . '<a href="'. url("AdminCategory/attrs_add", ["cid" => $item['id']]) . '">添加关联属性</a> &nbsp; '
                . '<a href="'. url("AdminSpec/index") . '">关联规格</a> &nbsp; '
                . '<a href="' . url("AdminCategory/edit", ["id" => $item['id']]) . '">' . lang('EDIT') .'</a> &nbsp; '
                . '<a class="js-ajax-delete" href="'. url("AdminCategory/delete",['id'=>$item['id']]) .'">'. lang('DELETE') .'</a>'
                ;
            array_push($newCategories, $item);
        }

        $tree->init($newCategories);

        if (empty($tpl)) {
            $tpl = "<tr>
                        <td><input name='list_orders[\$id]' type='text' size='3' value='\$list_order' class='input-order'></td>
                        <td>\$id</td>
                        <td>\$spacer <a href='\$url' target='_blank'>\$name</a></td>
                        <td>\$description</td>
                        <td>\$str_action</td>
                    </tr>";
        }
        $treeStr = $tree->getTree(0, $tpl);

        return $treeStr;
    }

    // 获取单条数据
    public function getPost($id)
    {
        $post = $this->get($id)->toArray();

        return $post;
    }

    /**
     * 添加文章分类
     * @param $data
     * @return bool
     */
    public function addCategory($data)
    {
        $transStatus = true;
        self::startTrans();
        try {
            if (!empty($data['more']['thumbnail'])) {
                $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
            }
            $this->allowField(true)->save($data);
            $id = $this->id;
            if (empty($data['parent_id'])) {
                $this->where(['id'=>$id])->update(['path'=>'0-'.$id]);
            } else {
                $parentPath = $this->where('id', intval($data['parent_id']))->value('path');
                $this->where(['id'=>$id])->update(['path'=>"$parentPath-$id"]);
            }
            self::commit();
        } catch (\Exception $e) {
            self::rollback();
            $transStatus = false;
        }

        return $transStatus;
    }

    public function editCategory($data)
    {
        $result = true;
        $id          = intval($data['id']);
        $parentId    = intval($data['parent_id']);
        $oldCategory = $this->where('id', $id)->find();

        if (empty($parentId)) {
            $newPath = '0-' . $id;
        } else {
            $parentPath = $this->where('id', intval($data['parent_id']))->value('path');
            if ($parentPath === false) {
                $newPath = false;
            } else {
                $newPath = "$parentPath-$id";
            }
        }

        if (empty($oldCategory) || empty($newPath)) {
            $result = false;
        } else {
            $data['path'] = $newPath;
            if (!empty($data['more']['thumbnail'])) {
                $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
            }
            $this->isUpdate(true)->allowField(true)->save($data, ['id' => $id]);

            $children = $this->field('id,path')->where('path', 'like', "%-$id-%")->select();
            if (!empty($children)) {
                foreach ($children as $child) {
                    $childPath = str_replace($oldCategory['path'].'-', $newPath.'-', $child['path']);
                    $this->isUpdate(true)->allowField(true)->save(['path'=>$childPath], ['id'=>$child['id']]);
                }
            }
        }

        return $result;
    }




    /**
     * [cateCrumbs 分类面包屑，递归获取]
     * @param  integer $cateId [description]
     * @param  integer $level  [description]
     * @return [type]          [description]
     */
    public function cateCrumbs($cateId=0, $level=5, $crumb='')
    {
        $find = $this->field('name,parent_id')->where('id',$cateId)->find();

        $crumb = $find['name'] . ($crumb?' > '.$crumb:'');
        if ($find['parent_id']==0) {
            return $crumb;
        } else {
            return $this->cateCrumbs($find['parent_id'],$level,$crumb);
        }
    }

    public function getSpecByCate($cateId='1')
    {
        // 判断当前分类规格是否为空，若为空则继承上级，若上级没有关联下级或者没有上级则返回空。
        $spec = '';

        return $spec;
    }

}