<?php
namespace app\usual\model;

// use think\Db;
// use think\Model;
// use tree\Tree;
// use think\Request;
// use app\admin\model\RouteModel;
use app\usual\model\UsualModel;

class VerifyModelModel extends UsualModel
{
    function _initialize()
    {
        parent::_initialize();
    }

    // 获取列表数据
    public function getLists($filter, $isPage = false)
    {
        // $categories = $this->field('id,name,list_order')->order("list_order ASC")->where($where)->select()->toArray();
        $categories = $this->order("list_order ASC,id DESC")->paginate(config('pagerset.pagesize'));
        return $categories;
    }

    public function getOptions($selectId=0, $parentId=0, $level=1, $default_option=false)
    {
        // $data = $this->all()->toArray();
        $data = $this->field(['code','name'])->select()->toArray();
        $options = $default_option ?'<option value="">--请选择--</option>':'';
        if (is_array($data)) {
            foreach ($data as $v) {
                $options .= '<option value="'.$v['code'].'" '.($selectId==$v['code']?'selected':'').' >'.$v['name'].'</option>';
            }
        }
        return $options;
    }

    public function getDefineData($selectIds=[], $freestyle='checkbox', $default_option=false)
    {
        $define_data = config('verify_define_data');
        $html = '';
        if ($freestyle=='checkbox') {
            foreach ($define_data as $key => $vo) {
                $html .= '<label class="define_label"><input class="define_input" type="checkbox" name="cate[more]['.$key.']" value="'.$key.'" '.(in_array($key,$selectIds)?'checked':'').'><span> &nbsp;'.$vo.'</span></label>';
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
    public function addCategory($data)
    {
        $data['create_time'] = time();
        $data['code'] = strtolower(trim($data['code']));

        $result = true;
        self::startTrans();
        try {
            if (!empty($data['more']['thumbnail'])) {
                $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
            }
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
    public function editCategory($data)
    {
        $id = intval($data['id']);
        $data['code'] = strtolower(trim($data['code']));

        $result = true;
        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }

        $this->isUpdate(true)->allowField(true)->save($data,['id'=>$id]);

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


}