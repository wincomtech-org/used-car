<?php
namespace app\trade\controller;

use cmf\controller\HomeBaseController;
use app\usual\model\UsualModel;
use app\usual\model\UsualCarModel;
use app\usual\model\UsualCompanyModel;
use app\usual\model\UsualItemModel;
use app\trade\model\TradeReportCateModel;
use think\Db;

/**
* 前台处理车辆信息  详情页
*/
class PostController extends HomeBaseController
{
    public function details()
    {
        $id = $this->request->param('id',0,'intval');
        $userId = cmf_get_current_user_id();

        $carModel = new UsualCarModel();
        // $car = $carModel->getPost($id);
        $car = $carModel->getPostRelate($id);
        // dump($car);die;
        if (empty($car)) {
            abort(404,'数据不存在！');
        }
        $plat = $car['platform'];

        // 检查是否锁单
        // $where = ['car_id'=>$id,'status'=>['in','1,8,10,-11']];
        $where = ['car_id'=>$id];
        $findOrder = Db::name('trade_order')->where($where)->value('buyer_uid');
        // 所属公司
        // $company = Db::name('UsualCompany')->where(['user_id'=>$car['user_id']])->find();

        // 车主信息
        $sellerInfo = lothar_verify($userId,'openshop','more');

        // 获取推荐车辆
        $carTuis = $carModel->getLists([],'',12,['a.is_rec'=>1]);


        $itModel = new UsualItemModel();
        // 车辆属性
        // 查找相关属性值 id
        $car2 = $itModel->getItemFilterVar($id);
        $car = array_merge($car,$car2);



        /*新车、二手车数据分离*/
        if ($plat==1) {
            // 新车初始化
            $filter = 'a.parent_id='.$id;
            // 处理格式参
            // 获取树形结构的属性筛选
            // $moreTree = cache('moreTreePost1');
            if (empty($moreTree)) {
                $filter_var0 = 'issue_time,';
                $filter_var = 'car_structure,car_color,car_seating,car_gearbox,car_fuel';
                $moreTree = $itModel->getItemTable(['code'=>['IN',$filter_var]]);
                // cache('moreTreePost1',$moreTree,3600);
            }
            // 只取数字型
            foreach ($moreTree as $key => $rows) {
                foreach ($rows['form_element'] as $k => $row) {
                    if (!is_numeric($row['name'])) {
                        unset($moreTree[$key]['form_element'][$k]);
                    }
                }
            }
            // dump($moreTree);die;
            // 合并处理

            /*获取其它筛选相关数据*/
            $issueTime = ['2016'=>'2016款','2017'=>'2017款','2018'=>'2018款'];

            /*URL 参数*/
            // $jumpext;


            /*车辆买卖 车辆数据*/
            // 款式对比数据查询
            // 应用模型层
            // $skuList = $carModel->getLists([], '', 12, ['a.parent_id'=>$id])->toArray();
            // $skuList = $skuList['data'];
            // 原生
            $skuList = $carModel->getListsOrgin($filter);
// dump($skuList);die;

            /*
             * 所有款式属性 二次加工
             * $allItems[$k1]['more'] = $itModel->getItemShow($v1['more'],config('usual_car_filter_var02'));
             * 'usual_car_filter_var02'=>'car_displacement,car_seating'
             */
            $allItemsThead = $allItems = $tbody2 = [];
            if (!empty($skuList)) {
                foreach ($skuList as $v1) {
                    // $omg = $this->omg($v1,&$tbody2);
                    $omg = $this->omg($v1);
                    $tbody2 = $omg['tbody2'];
                    $allItems[$v1['id']] = $omg['allItems'];
                }
                $allItemsThead = array_merge([[
                    'name' => '基本信息',
                    'child' => [
                        ['name'=>'售价'],
                        ['name'=>'市场价'],
                        ['name'=>'厂商'],
                        ['name'=>'级别'],
                        ['name'=>'上市时间'],
                        ['name'=>'排量'],
                        ['name'=>'座位数'],
                    ],
                ]],$tbody2);
            }
            if (empty($allItems)) {
                $omg = $this->omg($car);
                $tbody2 = $omg['tbody2'];
                $allItems[$car['id']] = $omg['allItems'];
                $allItemsThead = array_merge([[
                    'name' => '基本信息',
                    'child' => [
                        ['name'=>'售价'],
                        ['name'=>'市场价'],
                        ['name'=>'厂商'],
                        ['name'=>'级别'],
                        ['name'=>'上市时间'],
                        ['name'=>'排量'],
                        ['name'=>'座位数'],
                    ],
                ]],$tbody2);
            }

            /*模板赋值*/
            // 筛选数据集
            $this->assign('issueTime',$issueTime);
            $this->assign('moreTree',$moreTree);
            // 款式数据集
            $this->assign('allItemsThead',$allItemsThead);
            $this->assign('allItems',$allItems);

        } elseif ($plat==2) {

            // 二手车初始化
            // 车辆所有属性
            $carMore = $car['more'];
            $allItems = $itModel->getItemShow($carMore,config('usual_car_filter_var02'));
            // 检测报告
            $reportModel = new TradeReportCateModel();
            $reportCateTree = $reportModel->getCateTree();

            $this->assign('allItems',$allItems);
            $this->assign('reportCateTree', $reportCateTree);
            $this->assign('reportIds', $car['report']);
        }


        $this->assign('plat',$plat);
        $this->assign('userId',$userId);
        $this->assign('findOrder',$findOrder);
        $this->assign('car',$car);
        $this->assign('seller',$sellerInfo);
        $this->assign('carTuis',$carTuis);

        return $this->fetch('details'.$plat);
    }

    public function omg($omg)
    {
        $itModel = new UsualItemModel();
        $tbody0 = [[
            'child' => [
                'name' => $omg['name'],
                'price'=> $omg['shop_price'],
            ],
        ]];
        $tbody1 = [[
            'child' => [
                ['is_rec'=>1,'sketch'=>$omg['shop_price']],
                ['is_rec'=>0,'sketch'=>$omg['market_price']],
                ['is_rec'=>1,'sketch'=>$omg['bname'].$omg['cname']],
                ['is_rec'=>0,'sketch'=>$omg['dname']],
                ['is_rec'=>0,'sketch'=>date('Y-m-d',$omg['issue_time'])],
                ['is_rec'=>0,'sketch'=>$omg['car_displacement']],
                ['is_rec'=>0,'sketch'=>$omg['car_seating']],
            ],
        ]];
        $carMore = is_string($omg['more']) ? json_decode($omg['more'],true) : $omg['more'] ;
        $tbody2 = $itModel->getItemShow($carMore,config('usual_car_filter_var02'));
        $allItems = array_merge($tbody0,$tbody1,$tbody2);

        return ['tbody2'=>$tbody2,'allItems'=>$allItems];
    }

    // 新车款式对比
    public function ajaxPlat1()
    {
        /*获取请求数据*/
        $param = $this->request->param();
        // echo $param['parent_id'];exit;
        // var_export($param['issue_time']);exit;
        // var_export($param);exit;
        // echo implode(',',$issue_time);exit;
        // echo serialize($param);exit;
        // echo json_encode($param);exit;
        // $parent_id = $this->request->param('parent_id/d',0,'intval');//serialize之后ajax传过来无法获取

        $parent_id = empty($param['parent_id']) ? 0 : $param['parent_id'];
        $issue_time = empty($param['issue_time']) ? [] : $param['issue_time'];
        // 普通级 optimize => name
        $car_seating = empty($param['car_seating']) ? [] : $param['car_seating'];
        // 以下针对item处理 moreTree => ID
        $car_gearbox = empty($param['car_gearbox']) ? [] : $param['car_gearbox'];
        $car_fuel = empty($param['car_fuel']) ? [] : $param['car_fuel'];
        $car_color = empty($param['car_color']) ? [] : $param['car_color'];
        // 车身结构 usual_car_filter_var
        $car_structure = empty($param['car_structure']) ? [] : $param['car_structure'];

        /*筛选机制*/
        // 初始化
        $filter = '(a.parent_id='.$parent_id .' OR a.id='.$parent_id.')';
        $jumpext = '';
        $carModel = new UsualCarModel();

        // 处理请求的数据
        // 使用原生查询 框架不方便
        if (!empty($issue_time)) {
            $myarr = $issue_time;
            // print_r($issue_time);die;
            if (count($myarr)==1) {
                $startTime = strtotime($myarr[0]);
                $endTime = strtotime($myarr[0]+1);
                $filter .= ' AND (a.issue_time BETWEEN '.$startTime.' AND '.$endTime.')';
            } else {
                // 原型：' AND ((? BETWEEN ? AND ?) OR (? BETWEEN ? AND ?))';
                // 是否可以判断连续的年份？
                $filter .= ' AND (';
                $filter2 = '';
                foreach ($myarr as $sv) {
                    $filter2 .= '(a.issue_time BETWEEN '.strtotime($sv).' AND '.strtotime($sv+1).') OR ';
                }
                $filter2 = substr($filter2,0,-4);
                $filter .= $filter2.')';
            }
            // $jumpext .= '&issue_time='.$issue_time;
        }

        if (!empty($car_seating)) {
            // 座位在 usual_car里 用的是 值 而不是 ID
            // 通过这里的ID去找值
            $seats = Db::name('usual_item')->where(['id'=>['in',$car_seating]])->column('name');
            $filter .= $carModel->queryQuote($seats,'car_seating');
        }
        if (!empty($car_gearbox)) {
            $filter .= $carModel->queryQuote($car_gearbox,'car_gearbox');
        }
        if (!empty($car_fuel)) {
            $filter .= $carModel->queryQuote($car_fuel,'car_fuel');
        }
        if (!empty($car_color)) {
            $filter .= $carModel->queryQuote($car_color,'car_color');
        }
        if (!empty($car_structure)) {
            $filter .= $carModel->queryQuote($car_structure,'car_structure');
        }

        $skuList = $carModel->getListsOrgin($filter,'a.id');
        $sk = [];
        if (!empty($skuList)) {
            foreach ($skuList as $sku) {
                $sk[] = $sku['id'];
            }
        }

        echo json_encode($sk);exit;
        return 'return ajaxPlat1';
    }



    /*
    * 预约看车
    * pay.html
    */
    public function seeCar()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }
        $id = $this->request->param('id',0,'intval');//车子ID
        $user = cmf_get_current_user();

        // 判断是否二次支付：
        $findOrder =Db::name('trade_order')->field('id,pay_id,order_sn,bargain_money,status')->where(['buyer_uid'=>$user['id'],'car_id'=>$id])->find();
        if (!empty($findOrder['id'])) {
            $orderId = intval($findOrder['id']);
            if (empty($findOrder['status'])) {
                // 未支付状态
                $carInfo = Db::name('usual_car')->field('name,bargain_money,price,car_license_time,car_mileage,car_displacement')->where('id',$id)->find();
            } else {
                // 不是未支付状态
                $this->error('请勿重复提交',url('user/Buyer/index',['id'=>$orderId]));
            }
        } else {
            // 获取用户数据
            $usualModel = new UsualModel();
            $username = $usualModel->getUsername($user);

            // 获取车辆表数据
            $where['a.id'] = $id;
            $carInfo = Db::name('usual_car')->alias('a')
                     ->join('user b','a.user_id=b.id','LEFT')
                     ->field('a.user_id,a.name,a.bargain_money,a.price,a.car_license_time,a.car_mileage,a.car_displacement,b.user_nickname,b.user_login,b.user_email,b.mobile')
                     ->where($where)->find();
            if (empty($carInfo)) {
                $this->error('数据不存在！',url('trade/Index/index'));
            }
            $seller_username = $usualModel->getUsername($carInfo);

            // 生成车单
            $post = [
                'car_id'            => $id,
                'order_sn'          => cmf_get_order_sn('seecar_'),
                'buyer_uid'         => $user['id'],
                'buyer_username'    => $username,
                'buyer_contact'     => $user['mobile'],
                'seller_uid'        => $carInfo['user_id'],
                'seller_username'   => $seller_username,
                'bargain_money'     => $carInfo['bargain_money'],
                'description'       => $carInfo['name'],
                'create_time'       => time(),
                // 'ip'                => '',
            ];
            $orderId = Db::name('trade_order')->insertGetId($post);
            // lothar_put_news();
        }

        // 判断是否为手机端、微信端
        $map = [
            'action'    => 'seecar',
            'order_sn'  => $findOrder['order_sn']?$findOrder['order_sn']:$post['order_sn'],
            'coin'      => $carInfo['bargain_money'],
            'id'        => $orderId,
        ];
        $this->showPay($map);

        $this->assign('carInfo',$carInfo);
        $this->assign('orderId',$orderId);
        // $this->assign('formurl',url('Post/seeCarPost'));
        $this->assign('paysign','seeCar');
        return $this->fetch();
    }
    // 提交预约看车 paytype,action,order_sn,coin
    public function seeCarPost()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }

        // 前置数据
        $paytype = $this->request->param('paytype');
        if (empty($paytype)) {
            $this->error('请选择支付方式');
        }
        $orderId = $this->request->param('orderId/d');
        if (empty($orderId)) {
            $this->error('预约失败,请检查',url('trade/Post/seeCar'));
        }
        $order = Db::name('trade_order')->field('order_sn,bargain_money,pay_id')->where('id',$orderId)->find();
        $map = [
            'paytype'   => $paytype,
            'action'    => 'seecar',
            'order_sn'  => $order['order_sn'],
            'coin'      => $order['bargain_money'],
            // 'id'        => $orderId,
        ];

        // 判断是否二次支付：首单支付
        // 转向支付接口
        $this->success('前往支付中心……',cmf_url('funds/Pay/pay',$map));
    }

    /*
    * 第一次开店，
    * 开店资料审核 config('verify_define_data');
    * pay.html
    */
    public function deposit()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }

        // 前置数据
        $action  = 'openshop';
        $setting = cmf_get_option('usual_settings');
        $coin    = $setting['deposit'];
        $userId = cmf_get_current_user_id();

        // 判断是否二次支付：已有订单未付款，直接去支付；已有订单已支付，跳向用户中心审核页面
        $findOrder = Db::name('funds_apply')->field('id,order_sn,coin,payment')->where(['user_id'=>$userId,'type'=>$action])->find();
        if (!empty($findOrder)) {
            $orderId = intval($findOrder['id']);
            if (empty($findOrder['status'])) {
                # code...
            } else {
                $this->error('开店申请记录已存在',url('user/Funds/apply',['type'=>$action]));
            }
        } else {
            // 开店申请
            $post = [
                'type'      => $action,
                'user_id'   => $userId,
                'order_sn'  => cmf_get_order_sn($action.'_'),
                'coin'      => $coin,
                'create_time' => time(),
                // 'ip'        => '',
            ];
            $orderId = Db::name('funds_apply')->insertGetId($post);
            // lothar_put_news();
        }

        // 判断是否为手机端、微信端
        $map = [
            'action'    => $action,
            'order_sn'  => empty($findOrder['order_sn'])?$post['order_sn']:$findOrder['order_sn'],
            'coin'      => $coin,
            'id'        => $orderId,
        ];
        $this->showPay($map);

        $this->assign('deposit',$coin);
        $this->assign('orderId',$orderId);
        // $this->assign('formurl',url('Post/depositPost'));
        $this->assign('paysign','deposit');
        return $this->fetch();
    }
    // 提交开店押金 paytype,action,coin
    // \app\funds\controller\PayController.php
    public function depositPost()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录',url('user/Login/index'));
        }

        // 前置数据
        $paytype = $this->request->param('paytype');
        if (empty($paytype)) {
            $this->error('请选择支付方式');
        }
        $orderId = $this->request->param('orderId/d');
        if (empty($orderId)) {
            $this->error('开店申请失败');
        }
        $order = Db::name('funds_apply')->field('order_sn,coin,payment')->where('id',$orderId)->find();
        $map = [
            'paytype'   => $paytype,
            'action'    => 'openshop',
            'order_sn'  => $order['order_sn'],
            'coin'      => $order['coin'],
            // 'id'        => $orderId,
        ];

        // 判断是否二次支付：首单支付
        // 转向支付接口
        $this->success('前往支付中心……',cmf_url('funds/Pay/pay',$map));
    }

    // 登记卖车信息
    public function regCar()
    {
        // 是否登录
        $userId = cmf_get_current_user_id();
        if (empty($userId)) {
            echo lothar_toJson(0,'您尚未登录',url("user/Login/index"));exit();
        }

        // 卖车资质证明
        $rs = model('Trade')->check_sell($userId);
        if (!empty($rs)) {
            echo lothar_toJson($rs[0], $rs[1], $rs[2]);exit();
        }

        // 获取数据 直接获取不到数据？
        // $data = $this->request->param();
        // $data = $_POST;
// var_dump($data);die;

        $brandId = $this->request->param('brandId');
        $serieId = $this->request->param('serieId');
        $modelId = $this->request->param('modelId');
        $province = $this->request->param('province');
        $city = $this->request->param('city');
        $tel = $this->request->param('tel');
        $code = $this->request->param('code');
        $userInfo = cmf_get_current_user();

        // 验证验证码
        // $isMob = cmf_is_mobile();
        // if (!(cmf_captcha_check($code,1) || cmf_captcha_check($code,2))) {
        if (!cmf_captcha_check($code,1) && !cmf_captcha_check($code,2)) {
            echo lothar_toJson(0,'验证码错误');exit();
        }

        $uname = $userInfo['user_nickname'] ? $userInfo['user_nickname'] : ($userInfo['user_login']?$userInfo['user_login']:$userInfo['user_email']);

        $post = [
            'brand_id' => $brandId,
            'serie_id' => $serieId,
            'model_id' => $modelId,
            'province_id' => $province,
            'city_id'   => $city,
            'name'      => $uname .'的车子-'.rand(100,9999),
            'sell_status' => 0,
            // 'sell_status' => -1,
            'user_id'   => $userInfo['id'],
            'identi'    => ['username'=>'','contact'=>'手机：'.$tel],
        ];

        $result = $this->validate($post, 'usual/Car.seller');
        if ($result !== true) {
            echo lothar_toJson(0,$result);exit();
        }

        // 提交
        $transStatus = true;
        Db::startTrans();
        try{
            // $id = Db::name('usual_car')->insertGetId($post);
            // identi 需要被序列化，用模型处理
            $result = model('usual/UsualCar')->adminAddArticle($post);
            $id = $result->id;

            $log = model('usual/News')->newsObject('regCar',$id,$userInfo['id']);
            lothar_put_news($log);
            // session('deposit_'.$userInfo['id'], null);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $transStatus = false;
        }

        if ($transStatus===true) {
            $result = lothar_toJson(1, '提交成功', url('user/Seller/car'), ['id'=>$id]);
        } else {
            $result = lothar_toJson(0,'提交失败');
        }
        echo $result;exit();
    }

    public function order()
    {
        $data = $this->request->param();

        $result = $this->validate($data, 'Trade');
        if ($result !== true) {
            $this->error($result);
        }

        // 提交
        // $result = model('Trade')->adminAddArticle($post);
        // if ($result) {
        //     $this->success('提交成功',url('user/Profile/center'));
        // }
        // $this->error('提交失败');
    }

    public function collect()
    {
        // 是否登录
        $userInfo = cmf_get_current_user();
        if (empty($userInfo)) {
            $this->error('您尚未登录',url("user/Login/index"));
        }
        $id = $this->request->param('id/d');
        if (empty($id)) {
            $this->error('请求出错');
        }
        $scount = Db::name('user_favorite')->where(['user_id'=>$userInfo['id'],'table_name'=>'usual_car','object_id'=>$id])->count();
        if ($scount>0) {
            $this->error('您已收藏过');
        }

        $info = Db::name('usual_car')->where('id',$id)->value('name');
        $url = [
            'action' => 'trade/Post/details',
            'param'  => ['id'=>$id]
        ];
        $url = json_encode($url);

        $data = [
            'title'       => $info,
            'url'         => $url,
            'description' => '操作用户['.$userInfo['id'].']'.($userInfo['user_nickname']?$userInfo['user_nickname']:$userInfo['user_login']),
            'table_name'  => 'usual_car',
            'object_id'   => $id,
            'user_id'     => $userInfo['id'],
            'create_time' => time(),
        ];

        $res = Db::name('user_favorite')->insertGetId($data);
        if (!empty($res)) {
            $this->success('收藏成功',url('user/Collect/index'));
        }
        $this->error('收藏失败');
    }
}