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

    public function getLists($filter=[], $order='', $limit='',$extra=[])
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

        // 数据量
        $limit = $this->limitCom($limit);

        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order('is_top DESC,id DESC')
            ->paginate($limit);

        return $series;
    }

    // 合并项  筛选属性和拓展属性同时修改，以筛选属性为主，否则哪个被修改就用哪个。
    public function ItemMulti($post=[], $more=[])
    {
        // 筛选项字段
        // $filter_var02 = config('usual_car_filter_var02');
        // $filter_var_search = $filter_var02 .','. $this->filter_var;
        $filter_var_search = $this->filter_var;

        // 推荐项字段
        $itemCateModel = new UsualItemCateModel();
        $filterRec = $itemCateModel->field('code')->where('is_rec',1)->select()->toArray();
        $rec_var = '';
        foreach ($filterRec as $value) {
            $rec_var .= ','.$value['code'];
        }
        $filter_var_rec = $this->filter_var . $rec_var;

        // 开始过滤
        $filters = explode(',',$filter_var_rec);
        $newArr = $post;
        if (!empty($post['id'])) {
            $data = model('usual/UsualCar')->field($filter_var_search)->where('id',$post['id'])->find();
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
    public function getItemTable($key=null, $var='', $recursive=false)
    {
        $filter = [];
        if (is_array($key)) {
            $filter = $key;
        } elseif (is_string($key)) {
            $filter[$key] = $var;
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

    // 获取前台 车子详情页 usual_car_filter_var 数据集
    public function getItemFilterVar($id)
    {
        $data = model('usual/UsualCar')
            ->field($this->filter_var)
            ->where('id',$id)
            ->find();
        if (empty($data)) {
            $where = [];
        } else {
            $data = $data->toArray();
            $where = ['a.id'=>['in',array_values($data)]];
        }
        $items = $this->alias('a')
            ->field('a.name,a.description,b.code,b.unit')
            ->join('usual_item_cate b','a.cate_id=b.id','LEFT')
            ->where($where)
            ->select()->toArray();
        // 描述替代值
        $newItem = [];
        foreach ($items as $val) {
            $newItem[$val['code']] = empty($val['description'])?$val['name'].$val['unit']:$val['description'];
        }

        return $newItem;
    }

    /**
     * 获取前台 车子详情页 自定义数据集描述 
     * $data数据集非ID？
     * @param  array  $data   [数据集]
     * @param  array  $filter [需要去除的]
     * @return [type]         [description]
     */
    public function getItemShow($data=[], $filter=[])
    {
        if (empty($filter)) {
            $allItems = $this->getItemTable(null,'',true);
        } else {
            // $allItems = $this->getItemTable(['code'=>['not in',$filter]],'',true);
            $allItems = $this->getItemTable('code',['not in',$filter],true);
        }

        $newData = $children = $element = [];
        foreach ($allItems as  $key => $cate) {
            // echo "1=>".$cate['name'].'<br>';
            if (!empty($cate['children'])) {
                foreach ($cate['children'] as $key2 => $child) {
                    // echo "2=>".$child['name'].'<br>';
                    switch ($child['code_type']) {
                        case 'select':
                        case 'checkbox':
                        case 'radio':
                            if (!empty($child['form_element'])) {
                                foreach ($child['form_element'] as $key => $value) {
                                    // echo "3=>".$value['name'].'<br>';
                                    if (isset($data[$child['code']]) && ($value['id']==$data[$child['code']])) {
                                        $element = $value;
                                    }
                                }
                            }
                            if (isset($element)) {
                                $sketch = empty($element['description'])?(empty($element['name'])?'':$element['name'].$child['unit']):$element['description'];
                            }
                            break;
                        case 'text':
                        case 'number':
                        case 'hidden':
                            if (!empty($data[$child['code']])) {
                                $sketch = $data[$child['code']].$child['unit'];
                            }
                            break;
                        case 'file':
                            if (!empty($data[$child['code']])) {
                                $sketch = $data[$child['code']];
                            }
                            break;
                    }
                    if (!isset($sketch)) {
                        $sketch = '';
                    }
                    $children[] = [
                        'code_type'  => $child['code_type'],
                        // 'code'  => $child['code'],
                        'name'  => $child['name'],
                        // 'unit'  => $child['unit'],
                        'sketch'  => $sketch,
                    ];
                    unset($element,$sketch);
                    // echo "<br>";
                }
            }
            if (!isset($children)) {
                $children = [];
            }
            $newData[] = ['name'=>$cate['name'],'child'=>$children];
            unset($children);
            // echo "<hr>";
        }

        return $newData;
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