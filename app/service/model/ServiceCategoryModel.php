<?php
namespace app\service\model;

// use think\Db;
// use think\Model;
// use tree\Tree;
// use think\Request;
// use app\admin\model\RouteModel;
use app\usual\model\UsualModel;

class ServiceCategoryModel extends UsualModel
{
    // 获取列表数据
    public function getLists($filter=[], $order='', $limit='',$extra=[])
    {
        $where = [];
        if (!empty($filter['cateType'])) {
            $where['type'] = $filter['cateType'];
        }
        if (!empty($filter['keyword'])) {
            $where['name'] = ['like',"%$filter[keyword]%"];
        }
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }
        // $categories = $this->field('id,name,description,list_order')->order("list_order ASC")->where($where)->select()->toArray();
        $categories = $this->field('id,name,code,type,platform,description,more,list_order')
                    ->where($where)
                    ->order("is_top DESC,list_order ASC")
                    ->paginate(config('pagerset.size'));
        return $categories;
    }

    public function getOptions($selectId=0, $parentId=0, $option='')
    {
        // $data = $this->all()->toArray();
        $data = $this->field(['id','name'])->select()->toArray();

        $options = $this->createOptions($selectId, $option, $data);
        return $options;
    }

    public function getDefineData($selectIds=[], $freestyle='checkbox', $default='请选择')
    {
        $defconf = config('service_define_data');
        $tpl = '';
        if ($freestyle=='checkbox') {
            foreach ((array)$defconf as $key => $vo) {
                $tpl .= '<label class="define_label"><input class="define_input" type="checkbox" name="define_data[]" value="'.$key.'" '.(in_array($key,$selectIds)?'checked':'').'><span> &nbsp;'.$vo.'</span></label>';
            }
        } elseif ($freestyle=='selectmulti') {
            // <select multiple="multiple" size="2"></select>
            $tpl = empty($default) ? '': '<option value="0">--'.$default.'--</option>';
            if (is_array($defconf)) {
                foreach ($defconf as $key => $vo) {
                    $tpl .= '<option value="'.$key.'" '.($selectIds==$key?'selected':'').' >'.$vo.'</option>';
                }
            }
            // $tpl = createOptions($selectId, $default, $data);
        } elseif ($freestyle===false) {
            if (is_numeric($selectIds)) {
                // $define_data = $this->getPost($selectIds);
                // $define_data = $this->field('define_data')->where('id',$selectIds)->find()->toArray();
                // $define_data = $define_data['define_data'];
                // 优化
                $define_data = $this->where('id',$selectIds)->value('define_data');
                $define_data =  json_decode($define_data);
            } else {
                $define_data = $selectIds;
            }
            $new_data = [];
            foreach ($define_data as $d) {
                $new_data[] = [
                    'title' => $defconf[$d],
                    'name' => $d
                ];
            }
            return $new_data;
        } else {
            return $define_data;
        }
        return $tpl;
    }

    /**
     * 添加业务模型
     * @param $data
     * @param $extra
     * @return bool
    */
    public function addCategory($data)
    {
        $data['create_time'] = time();
        $data['dev'] = session('?name')?session('name'):'';

        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }
        $this->allowField(true)->save($data);
        // $id          = $this->id;

        return $this->id;
    }

    /**
     * 编辑业务模型
     * @param $data
     * @return bool
    */
    public function editCategory($data)
    {
        $id          = intval($data['id']);
        $data['dev'] = session('?name')?session('name'):'';

        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }

        $this->isUpdate(true)->allowField(true)->save($data, ['id'=>$id]);

        return $this->id;
    }

    public function createCategoryTableTree($currentIds=0, $tpl='', $config=null)
    {
        $tpl = <<<tpl
<tr class='data-item-tr'>
    <td>
        <input type='radio' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]' value='\$id' data-name='\$name' \$checked>
    </td>
    <td>\$id</td>
    <td>\$spacer <a style='text-decoration:none;cursor:pointer;'>\$name</a></td>
</tr>
tpl;
    }



// 前台
    /*首页*/
    public function getIndexServiceList($limit=7)
    {
        $ckey = 'giservicel'.$limit;

        $lists = cache($ckey);
        if (empty($lists)) {
            $lists = $this->field('id,name,description,more')
                    ->where('status',1)
                    ->order('is_top desc,id')
                    ->limit($limit)
                    ->select();
            cache($ckey, $lists, 3600);
        }

        return $lists;
    }
    /*服务模块*/
    public function fromCateList($type='service', $limit=20)
    {
        $where = [
            'delete_time' => 0,
            'status' => 1,
        ];
        if (is_array($type)) {
            $where = array_merge($where,['type'=>['IN',$type]]);
        } else {
            $where = array_merge($where,['type'=>$type]);
        }
        $list = $this->field('id,type,name,code,dev,description,more')
                ->where($where)
                ->order('is_top','DESC')
                ->select()->toArray();

        return $list;
    }

    // 用户中心 - 服务nav
    public function serviceNav()
    {
        $where = [
            'delete_time'   => 0,
            'status'        => 1,
            'type'          => 'service',
        ];
        $order = 'is_top DESC,list_order';

        $result = $this->field('id,name,code')->where($where)->order($order)->select();
        return $result;
    }

}