<?php
namespace app\usual\model;

use app\usual\model\UsualModel;

class UsualCarModel extends UsualModel
{
    public function getLists($filter=[], $order='', $limit='',$extra=[])
    {
        $field = 'a.*,b.name AS bname,c.name AS cname,d.name AS dname,e.name ename,f.user_nickname,f.user_login';

        $join = [
            ['usual_brand b','a.brand_id=b.id','LEFT'],
            ['usual_series c','a.serie_id=c.id','LEFT'],
            ['usual_models d','a.model_id=d.id','LEFT'],
            ['district e','a.city_id=e.id','LEFT'],
            ['user f','a.user_id=f.id','LEFT']
        ];

        // 筛选条件
        $where = ['a.delete_time' => 0];
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }
        // 暂定
        if (!empty($filter['sell_status'])) {
            $where['a.sell_status'] = $filter['sell_status'];
        }
        if (!empty($filter['typeId'])) {
            $where['a.type'] = $filter['typeId'];
        }
        if (!empty($filter['brandId'])) {
            $where['a.brand_id'] = $filter['brandId'];
        }
        if (!empty($filter['serieId'])) {
            $where['a.serie_id'] = $filter['serieId'];
        }
        if (!empty($filter['modelId'])) {
            $where['a.model_id'] = $filter['modelId'];
        }
        if (!empty($filter['cityId'])) {
            $where['a.city_id'] = $filter['cityId'];
        }

        // 后台
        $startTime = empty($filter['start_time']) ? 0 : strtotime($filter['start_time']);
        $endTime   = empty($filter['end_time']) ? 0 : strtotime($filter['end_time']);
        if (!empty($startTime) && !empty($endTime)) {
            $where['a.create_time'] = [['>= time', $startTime], ['<= time', $endTime]];
        } else {
            if (!empty($startTime)) {
                $where['a.create_time'] = ['>= time', $startTime];
            }
            if (!empty($endTime)) {
                $where['a.create_time'] = ['<= time', $endTime];
            }
        }
        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['a.name'] = ['like', "%$keyword%"];
        }

        // 排序
        $order = empty($order) ? 'is_top DESC,is_rec DESC,update_time DESC' : $order;

        // 数据量
        $limit = empty($limit) ? config('pagerset.size') : $limit;

        // 查数据
        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order($order)
            ->paginate($limit);

        return $series;
    }

    // 获取车源类型
    public function getCarType($status='')
    {
        return $this->getStatus($status,'usual_car_type');
    }
    // 售卖状态
    public function getSellStatus($status='')
    {
        return $this->getStatus($status,'usual_car_sell_status');
    }



// 前台
    /*首页*/
    public function getIndexCarList($type='', $sort=[], $limit=6)
    {
        $ckey = 'gicarl'.$limit;

        $cars = cache($ckey);
        if (empty($cars)) {
            // $cars = $this->all(function($query){
            //     $query->alias('a')
            //           ->field('a.id,a.name,a.more,a.car_mileage,a.car_license_time,a.shop_price,a.price,b.name AS city_name')
            //           // ->join('district b','a.city_id=b.id','LEFT')
            //           ->join('__DISTRICT__ b','a.city_id=b.id','LEFT')
            //           ->where('a.sell_status',1)
            //           ->limit($limit)
            //           ->order('a.published_time','desc')
            //           ->select()->toArray();
            // });

            $where = ['a.status'=>1,'a.sell_status'=>1];
            if (!empty($type)) {
                $where['a.type'] = $type;
            }
            $order = ['a.id'=>'DESC'];
            if (!empty($sort)) {
                $order = array_merge($sort,$order);
            }

            $cars = $this->alias('a')
                  ->field('a.id,a.name,a.more,a.car_mileage,a.car_license_time,a.market_price,a.shop_price,a.price,b.name AS city_name')
                  // ->join('district b','a.city_id=b.id','LEFT')
                  ->join('__DISTRICT__ b','a.city_id=b.id','LEFT')
                  ->where($where)
                  ->order($order)
                  ->limit($limit)
                  ->select()->toArray();

            cache($ckey, $cars, 3600);
        }

        return $cars;
    }

    // 用户车子列表
    public function getPostRelate($id,$filter=[])
    {
        $field = 'a.*,b.name AS brandname,c.name AS seriename,d.name AS modelname,e.name cityname,f.user_nickname,f.user_login';

        $join = [
            ['usual_brand b','a.brand_id=b.id','LEFT'],
            ['usual_series c','a.serie_id=c.id','LEFT'],
            ['usual_models d','a.model_id=d.id','LEFT'],
            ['district e','a.city_id=e.id','LEFT'],
            ['user f','a.user_id=f.id','LEFT']
        ];

        // 筛选条件
        $where = [
            'a.id' => $id,
            // 'a.delete_time' => 0,
            // 'a.sell_status' => 1,
        ];
        if (!empty($filter)) {
            $where = array_merge($where,$filter);
        }

        // 查数据
        $page = $this->alias('a')
            ->field($field)
            ->join($join)
            ->where($where)
            ->find();

        return $page;
    }

}