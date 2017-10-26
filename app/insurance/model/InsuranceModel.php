<?php
namespace app\insurance\model;

// use think\Model;
use think\Db;
use app\usual\model\UsualModel;

class InsuranceModel extends UsualModel
{
    public function getLists($filter)
    {
        $field = 'a.*,b.name AS bname';
        $where = [
            'a.delete_time' => 0
        ];

        $companyId = empty($filter['companyId']) ? 0 : intval($filter['companyId']);
        if (!empty($companyId)) {
            $where['a.company_id'] = ['eq', $companyId];
        }

        $startTime = empty($filter['start_time']) ? 0 : strtotime($filter['start_time']);
        $endTime   = empty($filter['end_time']) ? 0 : strtotime($filter['end_time']);
        if (!empty($startTime) && !empty($endTime)) {
            $where['a.published_time'] = [['>= time', $startTime], ['<= time', $endTime]];
        } else {
            if (!empty($startTime)) {
                $where['a.published_time'] = ['>= time', $startTime];
            }
            if (!empty($endTime)) {
                $where['a.published_time'] = ['<= time', $endTime];
            }
        }

        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['a.name'] = ['like', "%$keyword%"];
        }

        $series = $this->alias('a')->field($field)
            ->join('__USUAL_COMPANY__ b','a.company_id=b.id','LEFT')
            ->where($where)
            ->order('a.update_time DESC')
            ->paginate(5);

        return $series;
    }

    public function getPost($id)
    {
        $post = $this->get($id)->toArray();
        // $post = model('Insurance')->where('id', $id)->find();
        if (isset($post['content'])) {
            $post['content'] = cmf_replace_content_file_url(htmlspecialchars_decode($post['content']));
        }
        if (isset($post['information'])) {
            $post['information'] = cmf_replace_content_file_url(htmlspecialchars_decode($post['information']));
        }
        return $post;
    }

    public function getCompany($selectId = 0)
    {
        $where = ['delete_time' => 0];
        $categories = Db::name('usual_company')->field('id,name')->order("list_order ASC")->where($where)->select()->toArray();

        $options = '';
        foreach ($categories as $item) {
            $options .= '<option value="'.$item['id'].'" '.($selectId==$item['id']?'selected':'').'>'.$item['name'].'</option>';
        }

        return $options;
    }
}