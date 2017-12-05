<?php
namespace app\usual\model;

use app\usual\model\UsualModel;
use app\usual\model\UsualItemCateModel;
use tree\Tree;

class UsualItemModel extends UsualModel
{
    // protected $filter_var = config('usual_car_filter_var');
    protected $filter_var = 'car_gearbox,car_effluent,car_fuel,car_color';

    /*function _initialize()
    {
        parent::_initialize();
        // $this->filter_var = config('usual_car_filter_var');
    }*/

    public function getLists($filter)
    {
        $field = 'a.*,b.name AS bname';
        $where = [
            'a.delete_time' => 0
        ];
        $join = [
            ['__USUAL_ITEM_CATE__ b','a.cate_id=b.id','LEFT'],
        ];

        $cateId = empty($filter['cateId']) ? 0 : intval($filter['cateId']);
        if (!empty($cateId)) {
            $where['a.cate_id'] = ['eq', $cateId];
        }

        $startTime = empty($filter['start_time']) ? 0 : strtotime($filter['start_time']);
        $endTime   = empty($filter['end_time']) ? 0 : strtotime($filter['end_time']);
        if (!empty($startTime) && !empty($endTime)) {
            $where['a.update_time'] = [['>= time', $startTime], ['<= time', $endTime]];
        } else {
            if (!empty($startTime)) {
                $where['a.update_time'] = ['>= time', $startTime];
            }
            if (!empty($endTime)) {
                $where['a.update_time'] = ['<= time', $endTime];
            }
        }

        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['a.name'] = ['like', "%$keyword%"];
        }

        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order('is_top DESC,id DESC')
            ->paginate(config('pagerset.size'));

        return $series;
    }

    // 合并项  筛选属性和拓展属性同时修改，以筛选属性为主，否则哪个被修改就用哪个。
    public function ItemMulti($post=[], $more=[])
    {
        $filters = explode(',',$this->filter_var);
        $newArr = $post;
        if (!empty($post['id'])) {
            $data = model('UsualCar')->field($this->filter_var)->where('id',$post['id'])->find();
        }
        foreach ($filters as $xx) {
            if (!empty($post[$xx]) && empty($more[$xx])) {
                $newArr['more'][$xx] = $post[$xx];
            } elseif (!empty($more[$xx]) && empty($post[$xx])) {
                $newArr[$xx] = $more[$xx];
            } elseif (!empty($more[$xx]) && !empty($post[$xx])) {
                if (!empty($post['id'])) {
                    if ($data->$xx==$post[$xx] && $data->$xx!=$more[$xx]) {
                        $newArr[$xx] = $more[$xx];
                    } else {
                        $newArr['more'][$xx] = $post[$xx];
                    }
                } else {
                    $newArr['more'][$xx] = $post[$xx];
                }
            }
        }
        return $newArr;
    }

    // 用于前台车辆条件筛选且与属性表name同值的字段码
    public function getItemSearch($filter='')
    {
        $filter = $this->filter_var?$this->filter_var:$filter;
        // $filter = str_replace(',','|',$filter);
        $filter = '\''.str_replace(',','\',\'',$filter).'\'';
        // $filter = explode('|',$filter);

        // 'code'=>[$filter,'OR']
        return $this->ItemBaseData(['code'=>['exp','in('.$filter.')']]);
    }

    // 获取属性表数据及关联属性值表的属性值
    public function getItemTable($key='', $var='', $recursive=false)
    {
        $filter = [];
        if (!empty($var)) {
            $filter[$key] = $var;
        } else {
            $filter = $key;
        }
        return $this->ItemBaseData($filter, $recursive);
    }

    public function ItemBaseData($filter=[], $recursive=false)
    {
        $where = [
            'delete_time'=>0,
            'status'=>1,
        ];
        if (!empty($filter)) {
            $where = array_merge($where,$filter);
        }
        $itemCateModel = new UsualItemCateModel();
        $itemCate = $itemCateModel->field('id,parent_id,name,unit,code,code_type,description')
                ->where($where)
                ->order('list_order')
                ->select()->toArray();
        // 以下整个都可以改成用 Tree 类解决
        if (is_array($itemCate)) {
            foreach ($itemCate as $key=>$cate) {
                $items = $this->getItems(0,$cate['id'],false);
                $itemCate[$key]['form_element'] = $items;
            }
            if ($recursive===true) {
                $itemCateTree = [];
                $tree = new Tree();
                // model('admin/NavMenu')->parseNavMenu4Home($itemCate);
                $tree->init($itemCate);
                $itemCateTree = $tree->getTreeArray(0);
                return $itemCateTree;
            }
        } else {
            return [];
        }
        return $itemCate;
    }

    // 获取前台 展示给用户的 自定义数据集
    public function getItemShow($data=[])
    {
        # code...
    }

    /*
     * 获取 属性
     * ."\r\n"
    */
    public function getItems($selectId=0, $cateId=0, $option='请选择')
    {
        $where = ['cate_id'=>$cateId,'status'=>1];
        $data = $this->field('id,name,description')->where($where)->order('is_top','desc')->select()->toArray();

        $options = $this->createOptions($selectId, $option, $data);
        return $options;
    }


}