<?php
namespace app\usual\model;

use app\usual\model\UsualModel;

class UsualCarModel extends UsualModel
{
    public function getLists($filter=[], $order='', $limit='',$extra=[])
    {
        $field = 'a.*,b.name AS bname,c.name AS cname,d.name AS dname,e.name ename,f.user_nickname,f.user_login,f.user_email,f.mobile';

        $join = [
            ['usual_brand b','a.brand_id=b.id','LEFT'],
            ['usual_series c','a.serie_id=c.id','LEFT'],
            ['usual_models d','a.model_id=d.id','LEFT'],
            ['district e','a.city_id=e.id','LEFT'],
            ['user f','a.user_id=f.id','LEFT']
        ];

        // 筛选条件
        $where = ['a.delete_time' => 0];
        // 更多
        if (isset($filter['parent'])) {
            $where['a.parent_id'] = intval($filter['parent']);
        }
        if (!empty($filter['plat'])) {
            $where['a.platform'] = intval($filter['plat']);
        }
        if (!empty($filter['sellStatus'])) {
            $where['a.sell_status'] = $filter['sellStatus'];
        }
        if (!empty($filter['brandId'])) {
            $where['a.brand_id'] = intval($filter['brandId']);
        }
        if (!empty($filter['serieId'])) {
            $where['a.serie_id'] = intval($filter['serieId']);
        }
        if (!empty($filter['modelId'])) {
            $where['a.model_id'] = intval($filter['modelId']);
        }
        if (!empty($filter['cityId'])) {
            $where['a.city_id'] = intval($filter['cityId']);
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
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }

        // 排序
        $order = empty($order) ? 'a.is_top DESC,a.is_rec DESC,a.update_time DESC' : $order;

        // 数据量
        $limit = $this->limitCom($limit);

        // 查数据
        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order($order)
            ->paginate($limit);

        return $series;
    }

    // 原生查询
    public function getListsOrgin($filter='', $field='', $order='', $limit=12)
    {
        $field = (empty($field)) ? 'a.*,b.name AS bname,c.name AS cname,d.name AS dname' : $field ;
        // 售卖条件
        $where = 'WHERE a.status=1 AND a.sell_status>0';
        if (!empty($filter)) {
            $where .= ' AND '. $filter;
        }
        if (!empty($order)) {
            $order = 'ORDER BY '. $order;
        }
        $limit = 'LIMIT '. $limit;

        // 拼接
        // $sql = sprintf("SELECT %s FROM `cmf_usual_car` AS a LEFT JOIN `cmf_usual_brand` AS b ON a.brand_id=b.id LEFT JOIN `cmf_usual_series` AS c ON a.serie_id=c.id LEFT JOIN `cmf_usual_models` AS d ON a.model_id=d.id LEFT JOIN `cmf_district` AS e ON a.city_id=e.id LEFT JOIN `cmf_user` AS f ON a.user_id=f.id WHERE %s ORDER BY %s LIMIT %s", $field, $where, $order, $limit);
        $sql = sprintf("SELECT %s FROM `cmf_usual_car` AS a LEFT JOIN `cmf_usual_brand` AS b ON a.brand_id=b.id LEFT JOIN `cmf_usual_series` AS c ON a.serie_id=c.id LEFT JOIN `cmf_usual_models` AS d ON a.model_id=d.id %s %s %s", $field, $where, $order, $limit);

        $list = $this->query($sql);//这样获取的是数组

        return $list;
    }
    /**
     * 拼接 查询语句
     * @param  string $var [数据]
     * @param  string $key [字段名]
     * @return [type]      [description]
     */
    public function queryQuote($var='',$key='')
    {
        $filter = ' AND ';
        if (count($var)==1) {
            $filter .= 'a.'.$key.'='.$var[0];
        } else {
            // 原型：' AND (?=? OR ?=?)';
            $filter2 = '';
            foreach ($var as $sv) {
                $filter2 .= 'a.'.$key.'='.$sv.' OR ';
            }
            $filter2 = substr($filter2,0,-4);
            $filter = $filter .'('. $filter2 .')';
        }

        return $filter;
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
    // 解决状态冲突
    public function identiStatus($data=[], $shape=false)
    {
        if ( isset($data['sell_status']) && isset($data['identi_status']) ) {
            if (empty($data['identi_status']) && !empty($data['sell_status'])) {
                $data['sell_status'] = 0;
            }
        }
        return $data;
    }



// 前台
    /*首页*/
    public function getIndexCarList($fk, $filter, $sort='', $limit=6)
    {
        $ckey = 'gicarl'.$fk;

        $cars = cache($ckey);
        if (empty($cars)) {
            // $cars = $this->all(function($query){
            //     $query->alias('a')
            //         ->field('a.id,a.name,a.more,a.car_mileage,a.car_license_time,a.shop_price,a.price,b.name AS city_name')
            //         // ->join('district b','a.city_id=b.id','LEFT')
            //         ->join('__DISTRICT__ b','a.city_id=b.id','LEFT')
            //         ->where('a.sell_status',1)
            //         ->limit($limit)
            //         ->order('a.published_time','desc')
            //         ->select()->toArray();
            // });

            $where['a.delete_time'] = 0;
            $where['a.status'] = 1;
            $where['a.sell_status'] = ['gt',0];
            if (!empty($filter)) {
                $where = array_merge($where,$filter);
            }
            $order = 'a.id DESC';
            if (!empty($sort)) {
                $order = $sort .','. $order;
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
        $field = 'a.*,b.name AS brandname,c.name AS seriename,d.name AS modelname,e.name cityname,f.user_nickname,f.user_login,f.user_email,f.mobile';

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
        if (!empty($page)) {
            $page = $page->toArray();
        }
        $post['username'] = $this->getUsername($page);

        return $page;
    }

}