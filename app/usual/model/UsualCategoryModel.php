<?php
namespace app\usual\model;

use app\admin\model\RouteModel;
use think\Model;
use tree\Tree;
use think\Db;

class UsualCategoryModel extends Model
{

    protected $type = [
        'more' => 'array',
    ];

    /**
     * 生成分类 select树形结构
     * @param int $selectId 需要选中的分类 id
     * @param int $currentCid 需要隐藏的分类 id
     * @return string
     */
    public function adminCategoryTree($selectId = 0, $currentCid = 0, $table = '')
    {
        $where = ['delete_time' => 0];
        if (!empty($currentCid)) {
            $where['id'] = ['neq', $currentCid];
        }
        if (empty($table)) {
            $categories = $this->order("list_order ASC")->where($where)->select()->toArray();
        } else {
            $categories = Db::name($table)->order("list_order ASC")->where($where)->select()->toArray();
        }

        $tree       = new Tree();
        $tree->icon = ['&nbsp;&nbsp;│', '&nbsp;&nbsp;├─', '&nbsp;&nbsp;└─'];
        $tree->nbsp = '&nbsp;&nbsp;';

        $newCategories = [];
        foreach ($categories as $item) {
            $item['selected'] = $selectId == $item['id'] ? "selected" : '';
            array_push($newCategories, $item);
        }

        $tree->init($newCategories);
        $str     = '<option value=\"{$id}\" {$selected}>{$spacer}{$name}</option>';
        $treeStr = $tree->getTree(0, $str);

        return $treeStr;
    }

    /**
     * @param int|array $currentIds
     * @param string $tpl
     * @return string
     */
    public function adminCategoryTableTree($currentIds = 0, $tpl = '', $config = null)
    {
        // if (!empty($currentCid)) {
        //     $where['id'] = ['neq', $currentCid];
        // }
        if (isset($config['table2']) && $config['table2']=='usual_brand') {
            $where = ['a.delete_time' => 0];
            $categories = $this
                            ->alias('a')
                            ->field('a.id,a.parent_id,a.brand_id,a.name,a.description,a.list_order,b.name bname')
                            ->order("a.list_order,a.brand_id")
                            ->join('usual_brand b','a.brand_id=b.id','left')
                            ->where($where)
                            ->select()
                            ->toArray();
        } else {
            $where = ['delete_time' => 0];
            $categories = $this->order("list_order ASC")->where($where)->select()->toArray();
        }

        $tree       = new Tree();
        $tree->icon = ['&nbsp;&nbsp;│', '&nbsp;&nbsp;├─', '&nbsp;&nbsp;└─'];
        $tree->nbsp = '&nbsp;&nbsp;';

        if (!is_array($currentIds)) {
            $currentIds = [$currentIds];
        }

        $config['add_title'] = isset($config['add_title'])?$config['add_title']:'添加子分类';
        $newCategories = [];
        foreach ($categories as $item) {
            $item['checked'] = in_array($item['id'], $currentIds) ? "checked" : "";
            $item['url']     = isset($config['url']) ? '<a href="'. cmf_url($config['url'], ['id' => $item['id']]) .'">'. $item['name'] .'</a>' : $item['name'];
            $item['str_action'] = '';
            if (isset($config['add'])) {
                $item['str_action'] .= '<a href="'. url($config['m'].'/add', ["parent" => $item['id']]) .'">'.$config['add_title'].'</a>&nbsp;&nbsp;';
            }
            if (isset($config['edit'])) {
                $item['str_action'] .= '<a href="'. url($config['m'].'/edit', ["id" => $item['id']]) .'">'. lang('EDIT') .'</a>&nbsp;&nbsp;';
            }
            if (isset($config['delete'])) {
                $item['str_action'] .= '<a class="js-ajax-delete" href="' . url($config['m'].'/delete', ["id" => $item['id']]) . '">' . lang('DELETE') . '</a>';
            }
            array_push($newCategories, $item);
        }

        $tree->init($newCategories);

        // 被修改过的： <a href='\$url' target='_blank'>\$name</a> 改成 \$url
        if (empty($tpl)) {
            $tpl = '<tr>';
            $tpl .= "<td><input name='list_orders[\$id]' type='text' size='3' value='\$list_order' class='input-order'></td>";
            $tpl .= "<td>\$id</td>";
            $tpl .= "<td>\$spacer \$url</td>";
            if (isset($config['table2']) && $config['table2']=='usual_brand') $tpl .= "<td>\$bname</td>";
            $tpl .= "<td>\$description</td>";
            $tpl .= "<td>\$str_action</td>";
            $tpl .= '</tr>';

            // 以下为原代码
            // $tpl = "<tr>
            //             <td><input name='list_orders[\$id]' type='text' size='3' value='\$list_order' class='input-order'></td>
            //             <td>\$id</td>
            //             <td>\$spacer \$url</td>
            //             <td>\$bname</td>
            //             <td>\$description</td>
            //             <td>\$str_action</td>
            //         </tr>";
        }
        $treeStr = $tree->getTree(0, $tpl);

        return $treeStr;
    }

    /**
     * 添加品牌分类
     * @param $data
     * @return bool
     */
    public function addCategory($data)
    {
        $result = true;
        self::startTrans();
        try {
            if (!empty($data['more']['thumbnail'])) {
                $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
            }
            $this->allowField(true)->save($data);
            $id          = $this->id;
            $parentId    = isset($data['parent_id'])?intval($data['parent_id']):0;
            if (empty($parentId)) {
                $this->where( ['id' => $id])->update(['path' => '0-' . $id]);
            } else {
                $parentPath = $this->where('id', $parentId)->value('path');
                $this->where( ['id' => $id])->update(['path' => "$parentPath-$id"]);

            }
            self::commit();
        } catch (\Exception $e) {
            self::rollback();
            $result = false;
        }

        if ($result != false) {
            //设置别名
            $routeModel = new RouteModel();
            if (!empty($data['alias']) && !empty($id)) {
                $routeModel->setRoute($data['alias'], 'portal/List/index', ['id' => $id], 2, 5000);
                $routeModel->setRoute($data['alias'] . '/:id', 'portal/Article/index', ['cid' => $id], 2, 4999);
            }
            $routeModel->getRoutes(true);
        }

        return $result;
    }

    public function editCategory($data)
    {
        $result = true;

        $id          = intval($data['id']);
        $parentId    = isset($data['parent_id'])?intval($data['parent_id']):0;
        $oldCategory = $this->where('id', $id)->find();

        if (empty($parentId)) {
            $newPath = '0-' . $id;
        } else {
            $parentPath = $this->where('id', $parentId)->value('path');
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
                    $childPath = str_replace($oldCategory['path'] . '-', $newPath . '-', $child['path']);
                    $this->isUpdate(true)->save(['path' => $childPath], ['id' => $child['id']]);
                }
            }

            //设置别名
            $routeModel = new RouteModel();
            if (!empty($data['alias'])) {
                $routeModel->setRoute($data['alias'], 'portal/List/index', ['id' => $data['id']], 2, 5000);
                $routeModel->setRoute($data['alias'] . '/:id', 'portal/Article/index', ['cid' => $data['id']], 2, 4999);
            } else {
                $routeModel->deleteRoute('portal/List/index', ['id' => $data['id']]);
                $routeModel->deleteRoute('portal/Article/index', ['cid' => $data['id']]);
            }

            $routeModel->getRoutes(true);
        }

        return $result;
    }

}