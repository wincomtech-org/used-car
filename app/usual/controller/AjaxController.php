<?php
namespace app\usual\controller;

use cmf\controller\BaseController;
// use cmf\controller\HomeBaseController;
use app\usual\model\UsualSeriesModel;
use think\Db;

/**
* Ajax 集中营
* 特别说明
    对于ajax返回数据
        echo $data;exit();
        return $data;
    特别是对于json格式，这两个返回的数据结果集是不一样的。建议统一使用echo $data;exit();保证数据的准确性。
* 其它地方 ajax 操作以 function ajax*() 形式来创建方法体
*/
class AjaxController extends BaseController
{
    // public function _initialize()
    // {
    //     parent::_initialize();
    // }

    /*
    * 地区 获取城市数据 city
    * return ajax
    * 框架阻止了 GET 方式
    */
    public function getCitys()
    {
        // if ($this->request->isAjax()) {
        // if ($this->request->isPost()) {
            $parentId = $this->request->param('parentId',0,'intval');
            $ajax = model('admin/District')->getDistricts(0,$parentId,'请选择城市');
            // $ajax_encode = json_encode($ajax);

            // echo $ajax;exit();
            return $ajax;
        // }


        // $parentId = request();
        // $parentId = $this->request->param();
        // return $parentId['parentId'];
        // return request('parentId',0,'intval');
        // return $this->request->param('parentId',0,'intval');
        // echo "kill2";die;
        // echo $this->request->param('parentId');die;
    }

    /*
    * 地区 获取坐标数据 coordinate
    * return ajax
    * 框架阻止了 GET 方式
    */
    public function coordinate()
    {
        $result =  $this->coords('请选择服务点',false);
        if ($result) {
            return $result;
        } else {
            return '<option>--暂无该区数据--</option>';
        }
    }
    public function coords($option=false, $json=true)
    {
        $compId = $this->request->param('compId',0,'intval');
        $provId = $this->request->param('provId',0,'intval');
        $cityId = $this->request->param('cityId',0,'intval');
        if (!empty($cityId)) {
            if (empty($compId)) {
                $where = ['city_id'=>$cityId];
            } else {
                $where = ['company_id'=>$compId,'city_id'=>$cityId];
            }
        } elseif (!empty($provId)) {
            if (empty($compId)) {
                $where = ['province_id'=>$provId];
            } else {
                $where = ['company_id'=>$compId,'province_id'=>$provId];
            }
        }

        $result = model('UsualCoordinate')->getCoordinates(0, $where, $option);

        if ($result) {
            if ($json===true) {
                echo json_encode($result);exit();
            } else {
                return $result;
            }
        } else {
            return;
        }
    }

    /*
    * 点击品牌 获取车系数据 series
    * return ajax
    * 框架阻止了 GET 方式
    */
    public function serieByBrand()
    {
        if ($this->request->isPost()) {
            $brandId = $this->request->param('brandId',0,'intval');

            $serieModel = new UsualSeriesModel();
            $series = $serieModel->SeriesTree($brandId,false);

            $tpl = '';
            foreach ($series as $v) {
                $tpl .= '<li data-val="'. $v['id'] .'"><input value="'. $v['name'] .'" readonly /></li>';
            }
            return $tpl;
        }
        return '<li><input value="--数据错误--"></li>';
    }

    // 获取二级车系
    public function getSecondSeries()
    {
        if ($this->request->isAjax()) {
            $parentId = $this->request->post('parentId',0,'intval');
            return model('UsualSeries')->getSeries(0,$parentId,2,true);
        }
    }

    /*
    * 用户
    * 验证用户
    * 获取用户id
    */
    public function checkUname()
    {
        $uname = $this->request->param('uname','','strval');
        if (empty($uname)) {
            return '请输入用户信息';
        }

        // $uid = model('usual/Usual')->getUid($uname);
        $uid = intval($uname);
        if (empty($uid)) {
            $uid = Db::name('user')->whereOr(['user_nickname|user_login|user_email|mobile'=>$uname])->value('id');
            $uid = intval($uid);
            if (empty($uid)) {
                return '不存在该用户！请检查';
            }
        } else {
            $count = Db::name('user')->where('id',$uid)->count();
            if (empty($count)) {
                return '不存在该用户！请检查';
            }
        }
        return '该用户可用';
    }

    /*
    * 消息定时获取
    * 使用 socket 实时获取新消息
    */
    public function news()
    {
        $html = lothar_get_news('',true);

        // $html = str_replace('__STATIC__', '/static', $html);

        echo $html;exit;
    }



}
