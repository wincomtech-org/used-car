<?php
namespace app\trade\controller;

use cmf\controller\HomeBaseController;
use app\usual\model\UsualSeriesModel;
use app\usual\model\UsualCarModel;
use think\Db;
// use think\Loader;

/**
* 车辆买卖 列表
*
*/
class IndexController extends HomeBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    //     dump(Loader::parseName('brand_id',1));die;
    //     dump(cmf_parse_name('brandId'));die;
    //     dump(cmf_parse_name('car_seating'));die;
    // }

    public function index()
    {
        $platform = [
            ['id'=>1,'name'=>'新车','description'=>'新车选购<br>提供优质资源'],
            ['id'=>2,'name'=>'二手车','description'=>'二手车买卖<br>为您的安全保驾护航'],
            ['id'=>3,'name'=>'服务商城','description'=>'服务<br>汽车配件、服务、周边等'],
        ];

        $this->assign('platform',$platform);
        return $this->fetch();
    }

    public function platform()
    {
        // 写在前面
        $plat = $this->request->param('plat',2,'intval');
        if ($plat==3) {
            $this->redirect('shop/Index/index');
        }
        if (!in_array($plat,[1,2,3])) $plat = 2;

        // 实例化
        $serieModel = new UsualSeriesModel();

        /*获取免费登记卖车信息相关数据 cache('?regCarInfo')*/
        $regCarInfo = cache('regCarInfo');
        if (empty($regCarInfo)) {
            // $regCarSession = session('deposit_'.cmf_get_current_user_id());
            // $brandId = $this->request->param('brandId',0,'intval');
            $provId = $this->request->param('provId',1,'intval');
            // $cityId = $this->request->param('cityId',0,'intval');
            $Brands = model('usual/UsualBrand')->getBrands(0,0,false);
            // $Series = $serieModel->SeriesTree($brandId,false);
            $Models = model('usual/UsualModels')->getModels(0,0,false);
            $Provinces = model('admin/District')->getDistricts(0,$provId);
            // $Citys = model('admin/District')->getDistricts($cityId,$provId);

            $regCarInfo = [
                'brand'=>$Brands,
                // 'serie'=>$Series,
                'model'=>$Models,
                'prov'=>$Provinces,
            ];
            cache('regCarInfo',$regCarInfo,3600);
        }



        /*
        * 车辆买卖 筛选
        * url美化：
            条件筛选先用a标签试试 占位符 效果(string类型：00000000)。
            001：车品牌、车系
            01：其它参数
        * 备用函数
            str_split($param,3);
            str_replace(search, replace, subject);
            substr(string,start,length)
            dechex('十转十六');hexdec('十六转十');
        */
        $carModel = new UsualCarModel();

        /*获取请求数据 typeCast()$type=a/d/f/b/s/gettype()*/
        // $param = $this->request->param();
        // dump($param);die;
        $keyword = $this->request->param('keyword');
        $oxnum = $this->request->param('oxnum');
        // $jumpext = $this->request->param('jumpext','','strval');
        // ID
        $typeId = $this->request->param('typeId','new');
        $brandId = $this->request->param('brandId');// 2大众 4福特
        $serieId = $this->request->param('serieId');
        $modelId = $this->request->param('modelId');
        $priceId = $this->request->param('priceId');
        // 普通级 optimize => name
        $car_mileage = $this->request->param('car_mileage','','strval');
        $car_displacement = $this->request->param('car_displacement','','strval');
        $car_seating = $this->request->param('car_seating/d',0,'intval');
        // 以下针对item处理 moreTree => ID
        $car_gearbox = $this->request->param('car_gearbox/d',0,'intval');
        $car_effluent = $this->request->param('car_effluent/d',0,'intval');
        $car_fuel = $this->request->param('car_fuel/d',0,'intval');
        $car_color = $this->request->param('car_color/d',0,'intval');
        // 以下二手车
        $ageId = $this->request->param('ageId','','strval');
        // $car_structure = $this->request->param('car_structure/d',0,'intval');

        // 处理全站搜索 关键词
        if (!empty($keyword)) {
            $ooo = Db::name('usual_brand')->where(['name'=>['like',"%$keyword%"]])->value('id');
            if (empty($ooo)) {
                $ooo = Db::name('usual_series')->field('id,brand_id')->where(['name'=>['like',"%$keyword%"]])->find();
                if (empty($ooo)) {
                    $filter['keyword'] = $keyword;
                } else {
                // dump($ooo);
                    $filter['serieId'] = $serieId = $ooo['id'];
                    $filter['brandId'] = $brandId = $ooo['brand_id'];
                }
            } else {
                $filter['brandId'] = $brandId = $ooo;
            }
        }


        /*筛选机制*/
        // 初始化
        $separator = '_';// 分隔符 避免被转义
        $cname = 'a.';// 别名
        $placeholder = '00000000000000000000000000000000000000000';// 预置
        $limit = 12;//每页数据量
        $jumpurl = $jumpext = '';
        $filter = $extra = $where = $order = $carlist = [];
        // 售卖条件
        $extra['a.parent_id'] = 0;
        $extra['a.status'] = 1;
        $extra['a.sell_status'] = ['gt',0];

        // 处理请求的数据
        // 平台
        if (!empty($plat)) {
            $extra['a.platform'] = $plat;
        }
        // 类别
        if (is_numeric($typeId)) {
            $filter['typeId'] = (int)$typeId;
        } elseif ($typeId=='new') {
            $order = ['a.published_time'=>'DESC'];
        } elseif ($typeId=='rec') {
            $order = ['a.is_rec'=>'DESC'];
        }
        // 价格
        if (!empty($priceId)) {
            $extra['a.shop_price'] = $this->operatorSwitch($priceId,true);
        }
        // 车龄
        if (!empty($ageId)) {
            $extra['a.car_age'] = $this->operatorSwitch($ageId,true);
        }
        // 处理格式参
        $oxnum = empty($oxnum) ? $placeholder : $oxnum;
        $oxnum = trim($oxnum);
        // brandId,serieId,modelId
        $string1 = substr($oxnum,0,9);
        $remain = substr($oxnum, strlen($string1));

        // 处理数字类型的 大类 。$$idv 用于 assign()赋值。是否字段别名: 'a.'.cmf_parse_name($idv)。
        $newString1 = '';
        $string1Arr = str_split($string1,3);
        foreach (['brandId','serieId','modelId'] as $key=>$idv) {
            $value = $$idv;
            $value = !empty($value) ? ($value=='null'?null:$value) : (empty($string1)?null:$string1Arr[$key]);
            $value = $$idv = intval($value);
            if ($idv=='serieId' && $brandId!=$string1Arr[0]) $value = 0;
            if (!empty($value)) {
                $extra[$cname.cmf_parse_name($idv)] = $value;
            }
            $value = $this->dealPlaceholder($value);
            $newString1 .= $value;
        }
        $string1 = empty($newString1) ? $string1 : $newString1;

        // 获取树形结构的属性筛选
        if ($plat == 1) {
            $filter_var_0 = config('usual_car_filter_var01');
        } else {
            $filter_var_0 = config('usual_car_filter_var02');
        }
        $filter_var_1 = config('usual_car_filter_var');
        $moreTree = cache('moreTree'.$plat);
        if (empty($moreTree)) {
            $filter_var = $filter_var_0 .','.$filter_var_1;
            $moreTree = model('usual/UsualItem')->getItemTable(['code'=>['IN',$filter_var]]);
            cache('moreTree'.$plat,$moreTree,3600);
        }
        // dump($moreTree);die;
        // 处理 普通级。 将usual_item的name与usual_car中的对应值作比较
        // 处理 item 。  将usual_item的id与usual_car中的对应值作比较
        // 合并处理
        $newString4 = '';$filter_var_0 = explode(',',$filter_var_0);
        $string4Arr = str_split($remain,4);
        foreach ($moreTree as $key=>$val) {
            $value = $$val['code'];
            $value = !empty($value) ? ($value=='null'?null:$value) : (empty($remain)?null:$string4Arr[$key]);
            $value = intval($value);
            if (!empty($value)) {
                $$val['code'] = $value;
                if (in_array($val['code'], $filter_var_0)) {
                    $extra[$cname.$val['code']] = $this->operatorSwitch($value);
                } else {
                    // $extra[$cname.$val['code']] = $value;
                    $extra[$cname.$val['code']] = $this->operatorSwitch($value,'id');
                }
            }
            $value = $this->dealPlaceholder($value,4);
            $newString4 .= $value;
        }
        $string4 = empty($newString4) ? $remain : $newString4;


        /*获取其它筛选相关数据*/
        // 车源类别
        // $Types = model('usual/UsualCar')->getCarType();// option
        $Types = config('usual_car_type');
        // $Types = array_merge($Types,['new'=>'最新上架','rec'=>'新车推荐']);
        // $Types['new'] = '最新上架';
        // $Types['rec'] = '新车推荐';
        $Types = ['new'=>'最新上架','rec'=>'新车推荐'] + $Types;
        // 品牌
        $Brands = model('usual/UsualBrand')->getBrands($brandId,0,false);
        // 系列
        $serieModel = new UsualSeriesModel();
        if (empty($brandId) || $brandId=='null') {
            $Series = $serieModel->recSeries();
        } else {
            $recSeries = $serieModel->recSeries($brandId);
            $Series = $serieModel->SeriesTree($brandId,false);
            $this->assign('recSeries',$recSeries);
        }
        // 车型
        $Models = model('usual/UsualModels')->getModels($modelId,0,false);
        // 。。。
        // $Provinces = model('admin/District')->getDistricts(0,1);
        // $Prices = model('usual/UsualItem')->getItems(0,21,false);
        $Prices = ['0~3'=>'3万以下','3~5'=>'3-5万','5~8'=>'5-8万','8~10'=>'8-10万','10~15'=>'10-15万','15~20'=>'15-20万','20~30'=>'20-30万','30~50'=>'30-50万','>50'=>'50万以上'];
        $ages = ['0~1'=>'1年以内','0~3'=>'3年以内','0~5'=>'5年以内','>5'=>'5年以上'];

        // 数据总缓存
        // $obcache = cache('obcache');
        // if (empty($obcache)) {
        //     $obcache = [
        //         'brands'    => $Brands,
        //         'series'    => $Series,
        //         'models'    => $Models,
        //         'prices'    => $Prices,
        //         'moreTree'  => $moreTree,
        //         'types'     => $Types,
        //         // 'ages'    => $ages,
        //     ];
        //     cache('obcache',$obcache);
        // }


        /*URL 参数*/
        $string = $string1 . $string4;
        $jumpext = 'oxnum='.$string
                 . ($plat ? '&plat='.$plat : '')
                 . ($typeId ? '&typeId='.$typeId : '')
                 . (empty($priceId) ? '' : '&priceId='.$priceId);


        /*车辆买卖 车辆数据*/
        // 列表 数据库查询
        $carlist = $carModel->getLists($filter, $order, $limit, $extra);


        /*模板赋值*/
        $this->assign('regCarInfo',$regCarInfo);
        $this->assign('jumpext',$jumpext);

        $this->assign('plat',$plat);
        $this->assign('typeId',$typeId);
        $this->assign('Types',$Types);
        $this->assign('brandId',$brandId);
        $this->assign('Brands',$Brands);
        $this->assign('serieId',$serieId);
        $this->assign('Series',$Series);
        $this->assign('modelId',$modelId);
        $this->assign('Models',$Models);
        // $this->assign('provId',$provId);
        // $this->assign('Provinces',$Provinces);
        $this->assign('priceId',$priceId);
        $this->assign('Prices',$Prices);
        // 以下为 item 处理
        $this->assign('car_mileage',$car_mileage);
        $this->assign('car_displacement',$car_displacement);
        $this->assign('car_seating',$car_seating);
        $this->assign('car_gearbox',$car_gearbox);
        $this->assign('car_effluent',$car_effluent);
        $this->assign('car_fuel',$car_fuel);
        $this->assign('car_color',$car_color);
        // $this->assign('car_structure',$car_structure);
        $this->assign('moreTree',$moreTree);
        // 二手车
        // $this->assign('car_age',$car_age);
        $this->assign('ageId',$ageId);
        $this->assign('ages',$ages);

        // 数据分页
        $this->assign('carlist', $carlist->items());// 获取查询数据并赋到模板
        $carlist->appends($jumpext);//添加分页URL参数
        // $carlist->appends('jumpext',$jumpext);//添加分页URL参数
        $this->assign('pager', $carlist->render());// 获取分页代码并赋到模板

        return $this->fetch('platform'.$plat);
    }



    /*
    * 运算符转换
    * @param $id 值
    * @param $custom 自定义模式
    * @param $rule 替换规则
    * $newV = intval(preg_replace('/>=/','',$value,1));
      $newV = intval(preg_replace('/^<=/','',$value));
    * return array
    */
    public function operatorSwitch($id, $custom=false, $rule='>=<')
    {
        if ($custom===true) {
            // 外置 价格
            $value = $id;
            $newV = cmf_strip_chars($value,$rule);
        } elseif ($custom=='id') {
            // 将usual_item的id与usual_car中的对应值作比较
            $value = Db::name('usual_item')->where('id',intval($id))->value('name');
            $newV = $id;
        } else {
            // 将usual_item的name与usual_car中的对应值作比较
            $value = Db::name('usual_item')->where('id',intval($id))->value('name');
            $newV = cmf_strip_chars($value,$rule);
        }

        if (empty($value)) {
            $condition = [];
        } else {
            if (stripos($value,'>=')!==false) {
                $condition = ['egt',$newV];
            } elseif (stripos($value, '<=')!==false) {
                $condition = ['elt',$newV];
            } elseif (stripos($value, '>')!==false) {
                $condition = ['gt',$newV];
            } elseif (strrpos($value, '<')!==false) {
                $condition = ['lt',$newV];
            } elseif (strrpos($value, '=')!==false) {
                $condition = ['eq',$newV];
            } elseif (strrpos($value, '~')!==false) {
                $condition = ['between',str_replace('~',',',$value)];
            } else {
                $condition = $newV;
            }
        }

        return $condition;
    }

    /*
    *占位符处理
    * @param $value 值
    * @param $scaleplate 标尺
    * return string
    */
    public function dealPlaceholder($value=null, $scaleplate=3)
    {
        $placeholder = str_repeat('0',$scaleplate);
        if (empty($value)) {
            $result = $placeholder;
        } else {
            if ($value>0 && $value<10) {
                $result = substr($placeholder, 1) . $value;
            } elseif ($value>=10 && $value<100) {
                $result = substr($placeholder, 2) . $value;
            } elseif ($value>=100 && $value<1000) {
                $result = substr($placeholder, 3) . $value;
            } elseif ($value>=1000 && $value<10000) {
                $result = substr($placeholder, 4) . $value;
            } else {
                return;
            }
        }
        $result = strval($result);
        return $result;
    }

}