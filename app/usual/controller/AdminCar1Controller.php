<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;
use app\usual\model\UsualCarModel;
use app\usual\model\UsualBrandModel;
// use app\usual\model\UsualItemModel;
// use app\admin\model\DistrictModel;
use think\Db;

/**
* 车辆模块
* 二手车模块
*/
class AdminCar1Controller extends AdminBaseController
{
    function _initialize()
    {
        parent::_initialize();
        $this->Model = new UsualCarModel();
    }

    /**
     * 车辆列表
    */
    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $brandId = $this->request->param('brandId',0,'intval');
        $param['plat'] = 1;
        $param['parent'] = 0;
        $adminId = cmf_get_current_admin_id();
        if ($adminId!=1) {
            $param['uid'] = cmf_get_current_admin_id();
        }

        $data = $this->Model->getLists($param);

        $cateModel  = new UsualBrandModel();
        $brandTree   = $cateModel->adminCategoryTree($brandId);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('brand_tree', $brandTree);
        $this->assign('articles', $data->items());
        $data->appends($param);
        $this->assign('pager', $data->render());

        return $this->fetch();
    }

    /**
     * 添加车辆
    */
    public function add()
    {
        $post = [
            'brand_id' => 0,
            'model_id' => 0,
            'serie_id' => 0,
            'province_id' => 0,
            'city_id' => 0,
            'type' => 0,
            'sell_status' => 1,
        ];
        $this->op($post);

        return $this->fetch();
    }
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $post = $this->opPost($data);
            $post['user_id'] = cmf_get_current_admin_id();

            // 提交车子数据
            $this->Model->adminAddArticle($post);

            $this->success('添加成功!', url('AdminCar1/edit', ['id'=>$this->Model->id]));
        }
    }

    public function op($post=[])
    {
        $Brands = model('UsualBrand')->getBrands($post['brand_id']);
        $Models = model('UsualModels')->getModels($post['model_id']);
        $Series = model('UsualSeries')->getSeries($post['serie_id']);
        $provId = $this->request->param('provId',1,'intval');
        $Provinces = model('admin/District')->getDistricts($post['province_id'],$provId);
        // 车源类别
        $Types = $this->Model->getCarType($post['type']);

        // 用于前台车辆条件筛选且与属性表name同值的字段码
        $searchCode = model('UsualItem')->getItemSearch();
        // dump($searchCode);die;
        // 从属性表里被推荐的
        $recItems = model('UsualItem')->getItemTable('is_rec',1);
        // 属性表里所有属性（不包含推荐的）
        $allItems = model('UsualItem')->getItemTable(null,'',true);

        // 售卖状态
        $sell_status = $this->Model->getSellStatus($post['sell_status']);

        $this->assign('Brands', $Brands);
        $this->assign('Models', $Models);
        $this->assign('Series', $Series);
        $this->assign('Types', $Types);
        $this->assign('Provinces', $Provinces);

        $this->assign('searchCode', $searchCode);
        $this->assign('recItems', $recItems);
        $this->assign('allItems', $allItems);

        $this->assign('sell_status', $sell_status);
    }
    public function opPost($data,$valid='add1')
    {
        $post = $data['post'];
        $more = $data['post']['more'];
        // $report = $data['post']['report'];

        if (empty($post['serie_id'])) {
            $post['serie_id'] = empty($post['serie_pid']) ? 0 : $post['serie_pid'];
        }
        $post = model('UsualItem')->ItemMulti($post,$more);
        // $postadd= model('UsualItem')->ItemMulti($post,$more);
        // $post   = array_merge($post,$postadd);
        $post = $this->Model->identiStatus($post);

        // 验证
        $result = $this->validate($post, 'Car.'.$valid);
        if ($result !== true) {
            $this->error($result);
        }
        // 处理文件图片
        $style = [[565,385],[283,195],[160,109]];
        if (!empty($data['photo'])) {
            $post['more']['photos'] = lothar_dealFiles($data['photo'],$style);
        } else {
            $post['more']['photos'] = [];
        }
        if (!empty($data['file'])) {
            $post['more']['files'] = lothar_dealFiles($data['file']);
        } else {
            $post['more']['files'] = [];
        }
        if (!empty($post['more']['thumbnail'])) {
            $thumbnail = $post['more']['thumbnail'];
            $thumbnail = cmf_asset_relative_url($thumbnail);
            $post['more']['thumbnail'] = lothar_thumb_make($thumbnail,$style);
        }
        // $post['report'] = $data['report'];

        return $post;
    }

    /**
     * 编辑车辆
    */
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        $post = $this->Model->getPost($id);

        $this->op($post);
        $Series2 = model('UsualSeries')->getSeries($post['serie_id'],0,2);
        $Citys = model('admin/District')->getDistricts($post['city_id'],$post['province_id']);

        $this->assign('Series2', $Series2);
        $this->assign('Citys', $Citys);
        $this->assign('post', $post);

        return $this->fetch();
    }
    public function editPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $post = $this->opPost($data,'edit1');
            $post['deal_uid'] = cmf_get_current_admin_id();

            // 更新车子数据
            $this->Model->adminEditArticle($post);

            $this->success('保存成功!',url('index'));
        }
    }


    /**
     * 车辆款式
     * @return [type] [description]
     */
    public function design()
    {
        $param = $this->request->param();
        $parent = $this->request->param('parent',0,'intval');
        $car = Db::name('usual_car')->field('id,name')->where('id',$parent)->find();

        $list = $this->Model->getLists($param);

        $this->assign('list',$list);
        $this->assign('parent',$parent);
        $this->assign('carInfo',$car);
        return $this->fetch();
    }

    public function addDesign()
    {
        $parent = $this->request->param('parent',0,'intval');
        $field = 'id,brand_id,model_id,serie_id,province_id,city_id,type,sell_status';
        $field .= ',car_displacement,car_seating,car_gearbox,car_effluent,car_fuel,car_color';
        $field .= ',issue_time,name';
        $post = $this->Model->field($field)->where('id',$parent)->find();
        if (empty($post)) {
            $this->error('数据获取失败');
        }
        // dump($post);die;

        $this->op($post);

        $this->assign('post',$post);
        return $this->fetch();
    }
    public function addDesignPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $post = $this->opPost($data);
            $post['deal_uid'] = cmf_get_current_admin_id();

            // 提交车子数据
            $this->Model->adminAddArticle($post);

            $this->success('添加成功!', url('AdminCar1/editDesign', ['id'=>$this->Model->id]));
        }
    }

    public function editDesign()
    {
        $id = $this->request->param('id', 0, 'intval');
        $post = $this->Model->getPost($id);

        $this->op($post);
        $Series2 = model('UsualSeries')->getSeries($post['serie_id'],0,2);
        $Citys = model('admin/District')->getDistricts($post['city_id'],$post['province_id']);
        $car = Db::name('usual_car')->field('id,name')->where('id',$post['parent_id'])->find();

        $this->assign('Series2', $Series2);
        $this->assign('Citys', $Citys);
        $this->assign('carInfo',$car);
        $this->assign('post', $post);

        return $this->fetch();
    }
    public function editDesignPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $post = $this->opPost($data,'edit1');

            // 更新车子数据
            $this->Model->adminEditArticle($post);

            $this->success('保存成功!',url('index'));
        }
    }



    public function delete()
    {
        $param           = $this->request->param();

        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            $result       = $this->Model->where(['id' => $id])->find();
            $data         = [
                'object_id'   => $result['id'],
                'create_time' => time(),
                'table_name'  => 'UsualCar',
                'name'        => $result['name']
            ];
            $resultPortal = $this->Model
                ->where(['id' => $id])
                ->update(['delete_time' => time()]);
            if ($resultPortal) {
                Db::name('recycleBin')->insert($data);
            }
            $this->success("删除成功！", '');
        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $recycle = $this->Model->where(['id' => ['in', $ids]])->select();
            $result  = $this->Model->where(['id' => ['in', $ids]])->update(['delete_time' => time()]);
            if ($result) {
                foreach ($recycle as $value) {
                    $data = [
                        'object_id'   => $value['id'],
                        'create_time' => time(),
                        'table_name'  => 'UsualCar',
                        'name'        => $value['name']
                    ];
                    Db::name('recycleBin')->insert($data);
                }
                $this->success("删除成功！", '');
            }
        }
    }

    public function publish()
    {
        $param           = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            $this->Model->where(['id' => ['in', $ids]])->update(['status' => 1, 'published_time' => time()]);
            $this->success("发布成功！", '');
        }

        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            $this->Model->where(['id' => ['in', $ids]])->update(['status' => 0]);
            $this->success("隐藏成功！", '');
        }
    }

    public function top()
    {
        $param           = $this->request->param();
        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            $this->Model->where(['id' => ['in', $ids]])->update(['is_top' => 1]);
            $this->success("置顶成功！", '');

        }
        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            $this->Model->where(['id' => ['in', $ids]])->update(['is_top' => 0]);
            $this->success("取消置顶成功！", '');
        }
    }

    public function recommend()
    {
        $param = $this->request->param();
        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            $this->Model->where(['id' => ['in', $ids]])->update(['is_rec' => 1]);
            $this->success("推荐成功！", '');

        }
        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            $this->Model->where(['id' => ['in', $ids]])->update(['is_rec' => 0]);
            $this->success("取消推荐成功！", '');

        }
    }

    public function listOrder()
    {
        parent::listOrders(Db::name('UsualCar'));
        $this->success("排序更新成功！", '');
    }

    public function move()
    {

    }

    public function copy()
    {

    }

}