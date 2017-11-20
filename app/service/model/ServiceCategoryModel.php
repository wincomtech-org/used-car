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
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    // 获取列表数据
    public function getLists($filter=[], $isPage = false)
    {
        $where = [];
        if (!empty($filter['cateType'])) {
            $where['type'] = $filter['cateType'];
        }
        if (!empty($filter['keyword'])) {
            $where['name'] = ['like',"%$filter[keyword]%"];
        }
        // $categories = $this->field('id,name,description,list_order')->order("list_order ASC")->where($where)->select()->toArray();
        $categories = $this->field('id,name,code,type,description,list_order')->where($where)->order("list_order ASC,id DESC")->paginate(config('pagerset.size'));
        return $categories;
    }

    public function getOptions($selectId=0, $parentId=0, $level=1, $default_option=false)
    {
        // $data = $this->all()->toArray();
        $data = $this->field(['id','name'])->select()->toArray();
        $options = $default_option ?'<option value="0">--请选择--</option>':'';
        if (is_array($data)) {
            foreach ($data as $v) {
                $options .= '<option value="'.$v['id'].'" '.($selectId==$v['id']?'selected':'').' >'.$v['name'].'</option>';
            }
        }
        // $options = $this->createOptions($data,$option);
        return $options;
    }

    public function getDefineData($selectIds=[], $freestyle='checkbox', $default_option=false)
    {
        $define_data = config('service_define_data');
        $html = '';
        if ($freestyle=='checkbox') {
            foreach ($define_data as $key => $vo) {
                $html .= '<label class="define_label"><input class="define_input" type="checkbox" name="define_data[]" value="'.$key.'" '.(in_array($key,$selectIds)?'checked':'').'><span> &nbsp;'.$vo.'</span></label>';
            }
        } elseif ($freestyle=='select') {
            $html = $default_option ?'<option value="0">--请选择--</option>':'';
            if (is_array($define_data)) {
                foreach ($define_data as $key => $vo) {
                    $html .= '<option value="'.$key.'" '.($selectIds==$key?'selected':'').' >'.$vo.'</option>';
                }
            }
        } else {
            return $define_data;
        }
        return $html;
    }

    /**
     * 添加业务模型
     * @param $data
     * @param $extra
     * @return bool
    */
    public function addCategory($data,$extra=[])
    {
        $data['create_time'] = time();
        $data['dev'] = session('?name')?session('name'):'';

        $result = true;
        self::startTrans();
        try {
            if (!empty($data['more']['thumbnail'])) {
                $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
            }
            $data['define_data'] = empty($extra) ? [] : $extra;
            $this->allowField(true)->save($data);
            // $id          = $this->id;
            self::commit();
        } catch (\Exception $e) {
            self::rollback();
            $result = false;
        }

        return $result;
    }

    /**
     * 编辑业务模型
     * @param $data
     * @param $extra
     * @return bool
    */
    public function editCategory($data,$extra=[])
    {
        $result = true;
        $id          = intval($data['id']);
        $data['dev'] = session('?name')?session('name'):'';

        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }
        $data['define_data'] = empty($extra) ? [] : $extra;
        $this->isUpdate(true)->allowField(true)->save($data, ['id' => $id]);

        return $result;
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
    public function getIndexServiceList($limit=3)
    {
        $ckey = 'giservicel'.$limit;

        $lists = cache($ckey);
        if (empty($lists)) {
            $lists = $this->field('id,name,description,more')
                    ->where('status',1)
                    ->order('is_rec desc,id')
                    ->limit($limit)
                    ->select()->toArray();
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

}