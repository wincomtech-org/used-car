<?php
namespace app\usual\model;

use app\usual\model\UsualModel;

class UsualCarModel extends UsualModel
{
    public function getLists($filter)
    {
        $field = 'a.*,b.name AS bname,c.name AS cname,d.name AS dname,e.name ename,f.user_nickname,f.user_login';
        $where = ['a.delete_time' => 0];
        $join = [
            ['usual_brand b','a.brand_id=b.id','LEFT'],
            ['usual_series c','a.serie_id=c.id','LEFT'],
            ['usual_models d','a.model_id=d.id','LEFT'],
            ['district e','a.model_id=e.id','LEFT'],
            ['user f','a.user_id=f.id','LEFT']
        ];
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

        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order('update_time DESC')
            ->paginate(config('pagerset.size'));

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

            $where = ['a.sell_status'=>1];
            if (!empty($type)) {
                $where['a.type'] = $type;
            }
            $order = ['a.id'=>'DESC'];
            if (!empty($sort)) {
                $order = array_merge($sort,$order);
            }

            $cars = $this->alias('a')
                  ->field('a.id,a.name,b.name AS city_name')
                  // ->join('district b','a.city_id=b.id','LEFT')
                  ->join('__DISTRICT__ b','a.city_id=b.id','LEFT')
                  ->where($where)
                  ->order($order)
                  ->limit($limit)
                  ->select()->toArray();

            // cache($ckey, $cars, 3600);
        }

        return $cars;
    }

}