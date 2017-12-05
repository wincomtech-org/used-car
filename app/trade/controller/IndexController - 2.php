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
    // }

    public function index()
    {
        // dump(Loader::parseName('brand_id',1));die;
        // dump(cmf_parse_name('brandId'));die;
        // dump(cmf_parse_name('car_seating'));die;
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
        *
            url美化：
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

        // 处理请求
        // $param = $this->request->param();
        $oxnum = $this->request->param('oxnum/s');
        $oxvar = $this->request->param('oxvar/s');
        $keyword = $this->request->param('keyword/s');
        // $jumpext = $this->request->param('jumpext/s','','strval');
        // ID
        $platform = $this->request->param('platform',0,'intval');
        $typeId = $this->request->param('typeId','new');
        $brandId = $this->request->param('brandId/d');// 2大众 4福特
        $serieId = $this->request->param('serieId/d');
        $modelId = $this->request->param('modelId/d');
        $priceId = $this->request->param('priceId/s');
        // 以下为 item 处理
        $car_seating = $this->request->param('car_seating/s','','strval');
        $car_gearbox = $this->request->param('car_gearbox/s','','strval');
        $car_effluent = $this->request->param('car_effluent/s','','strval');
        $car_fuel = $this->request->param('car_fuel/s','','strval');
        $car_color = $this->request->param('car_color/s','','strval');
        $car_displacement = $this->request->param('car_displacement/s','','strval');
        $car_mileage = $this->request->param('car_mileage/s','','strval');
        $car_age = $this->request->param('car_age/s','','strval');

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

        // 获取筛选相关数据
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
        if (empty($brandId)) {
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
        // 其它
        $moreTree = cache('moreTree');
        if (empty($moreTree)) {
            $filter_var = config('usual_car_filter_var0').','.config('usual_car_filter_var');
            $moreTree = model('usual/UsualItem')->getItemTable(['code'=>['IN',$filter_var]]);
            cache('moreTree',$moreTree,3600);
        }
        // dump($moreTree);die;

        // 筛选机制
        // 初始化
        $separator = '_';// 分隔符 避免被转义
        $cname = 'a.';// 别名
        $numeric = '000000000';// 预置
        $limit = 12;//每页数据量
        $string = $jumpurl = $jumpext = '';
        $filter = $extra = $where = $order = $carlist = [];
        $filter['sellStatus'] = 1;

        // 处理请求的数据
        // 平台
        if (!empty($platform)) {
            $extra['platform'] = $platform;
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
            $extra['shop_price'] = $this->operatorSwitch($priceId);
        }
        if (isset($oxnum)) {
            $numeric = trim($oxnum);
        }
        if (isset($oxvar)) {
            $string = explode($separator,$oxvar);
        }
        // if (!empty($jumpext)) {
        //     // $numeric = $this->request->param('n/a',[]);
        //     // $jumpArr = explode($separator,$jumpext);
        //     // 处理数字类型的 0,1,2
        //     $numeric = strstr($jumpext, $separator, true);
        //     // 处理 item 字符类型的
        //     $string = strstr($jumpext, $separator);
        //     $string = preg_replace('/^\\'.$separator.'/','',$string);
        //     // $string = preg_replace('/\\'.$separator.'/','',$string,1);//同上面效果
        //     $string = explode($separator,$string);
        // }

        // 处理数字类型的 0,1,2 是否字段别名: 'a.'.cmf_parse_name($idv)
        $numericArr = str_split($numeric,3);
        $newNumeric = '';
        foreach (['brandId','serieId','modelId'] as $key => $idv) {
            $value = $$idv;
            $value = !empty($value) ? $value: (is_null($value)?null:$numericArr[$key]);
            $value = $$idv = intval($value);
            if (empty($value)) {
                $value = '000';
            } else {
                $extra[$cname.cmf_parse_name($idv)] = $value;
                if ($value>0 && $value<10) {
                    $value = '00'.$value;
                } elseif ($value<100) {
                    $value = '0'.$value;
                }
            }
            $newNumeric .= strval($value);
        }
        $numeric = empty($newNumeric) ? $numeric : $newNumeric;

        // 处理 item $$val['code'] 用于 assign()赋值
        $newString = '';
        foreach ($moreTree as $key => $val) {
            $value = $$val['code'];
            $value = !empty($value) ? $value : (empty($string)?$value:$string[$key]);
            $value = htmlspecialchars_decode($value);
            // $value = htmlspecialchars($value);
            if (!empty($value)) {
                $$val['code'] = $value;
                $extra[$cname.$val['code']] = $this->operatorSwitch($value);
            }
            $newString .= $value . $separator;
        }
        $string = substr($newString,0,strlen($newString)-1);

        // URL 参数
        // url('Post/step1',['id'=>1,'h'=>'a'])
        // url('Post/step1','id=1&h=a')
        // $jumpext = $numeric . ($string?$separator.$string:'');
        $jumpext = 'oxnum='.$numeric
                 . ($string ? '&oxvar='.$string : '')
                 . ($typeId ? '&typeId='.$typeId : '')
                 . ($priceId ? '&priceId='.$priceId : '');

// dump($brandId);
// dump($priceId);
// dump($car_gearbox);
// dump($extra);
// dump($moreTree);
// dump($numeric);
// dump($priceId);
// dump($jumpext);
// die;

        /*车辆买卖 车辆数据*/

        // 列表 数据库查询
        $carlist = $carModel->getLists($filter, $order, $limit, $extra);



        // 模板赋值
        $this->assign('regCarInfo',$regCarInfo);
        $this->assign('jumpext',$jumpext);

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
        $this->assign('car_seating',$car_seating);
        $this->assign('car_gearbox',$car_gearbox);
        $this->assign('car_effluent',$car_effluent);
        $this->assign('car_fuel',$car_fuel);
        $this->assign('car_color',$car_color);
        $this->assign('car_displacement',$car_displacement);
        $this->assign('car_mileage',$car_mileage);
        $this->assign('car_age',$car_age);
        $this->assign('moreTree',$moreTree);

        // 数据分页
        $this->assign('carlist', $carlist->items());// 获取查询数据并赋到模板
        $carlist->appends($jumpext);//添加分页URL参数
        // $carlist->appends('jumpext',$jumpext);//添加分页URL参数
        $this->assign('pager', $carlist->render());// 获取分页代码并赋到模板

        return $this->fetch();
    }
}