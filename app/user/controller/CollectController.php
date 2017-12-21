<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
use app\user\model\UserFavoriteModel;
use think\Db;

class CollectController extends UserBaseController
{

    /**
     * 个人中心我的收藏列表
    */
    public function index()
    {
        $userId = cmf_get_current_user_id();

        // 获取数据
        $list = model('UserFavorite')->collects();

        // 子查询
        // 联表 table_name
        // $subsql = Db::name('user_favorite')->field('table_name objname')->where(['?'=>'?'])->buildSql();
        // dump($subsql);die;
        // Db::name('user_favorite')->alias('a')->join([$subsql=> 'b'], 'a.object_id=b.id')->select();

        // $user = cmf_get_current_user();
        // $this->assign($user);

        // 赋值
        $this->assign("list", $list->items());
        // 分页
        $this->assign('pager', $list->render());

        return $this->fetch();
    }

    /**
     * 用户取消收藏
    */
    public function delete()
    {
        $id = $this->request->param("id", 0, "intval");
        if (empty($id)) {
            $this->error('数据非法！');
        }
        $where['id'] = $id;
        $result = Db::name("UserFavorite")->where($where)->delete();

        if (empty($result)) {
            $this->error("取消收藏失败！");
        } else {
            $this->success("取消收藏成功！");
        }
    }

    /**
     * 用户收藏
    */
    public function add()
    {
        $data   = $this->request->param();
        // 验证参数
        $result = $this->validate($data, 'Favorite');
        if ($result !== true) {
            $this->error($result);
        }

        // 获取每个参数
        $id = $this->request->param('id', 0, 'intval');
        $table = $data['table'];
        $userId = cmf_get_current_user_id();
        $colQuery = Db::name("user_favorite");

        // 是否收藏过
        $find = $colQuery->where([
            'object_id'  => $id,
            'table_name' => $table,
            'user_id'    => $userId
        ])->count();
        if ($find > 0) {
            $this->error("您已收藏过啦");
        }

        $title       = base64_decode($data['title']);
        $url         = base64_decode($data['url']);
        $description = $this->request->param('description', '', 'base64_decode');
        $description = empty($description) ? $title : $description;

        $post = [
            'user_id'     => $userId,
            'title'       => $title,
            'description' => $description,
            'url'         => $url,
            'object_id'   => $id,
            'table_name'  => $table,
            'create_time' => time()
        ];
        $colQuery->insert($post);

        $this->success('收藏成功');

    }
}