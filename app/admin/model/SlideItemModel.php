<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 小夏 < 449134904@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Model;

class SlideItemModel extends Model
{
    public function getLists($filter=[], $order='list_order', $limit=3,$extra=[])
    {
        $field = 'title,image,url,target,description';

        // 筛选条件
        $where = ['status' => 1];
        // 更多
        if (!empty($filter['cid'])) {
            $where['slide_id'] = $filter['cid'];
        }

        // 查数据
        $slides = $this->field($field)
            ->force('idx4')
            ->where($where)
            ->order($order)
            ->limit($limit)
            ->select();

        return $slides;
    }

}