<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
// use app\user\model\UserFavoriteModel;
use think\Db;

class CollectController extends UserBaseController
{

    /**
     * 个人中心我的收藏列表
    */
    public function index()
    {
        $userId        = cmf_get_current_user_id();
        $userQuery     = Db::name("UserFavorite");
        $list     = $userQuery->where(['user_id' => $userId])->order('id desc')->paginate(10);
// dump($list);

        // $user = cmf_get_current_user();
        // $this->assign($user);

        $this->assign("page", $list->render());
        $this->assign("list", $list->items());
        return $this->fetch();
    }

    /**
     * 用户取消收藏
    */
    public function delete()
    {
        $id               = $this->request->param("id", 0, "intval");
        $userId           = cmf_get_current_user_id();

        $userQuery        = Db::name("UserFavorite");
        $where['id']      = $id;
        $where['user_id'] = $userId;
        $data             = $userQuery->where($where)->delete();

        if (!empty($data)) {
            $this->success("取消收藏成功！");
        } else {
            $this->error("取消收藏失败！");
        }
    }

    /**
     * 用户收藏
    */
    public function add()
    {
        $data   = $this->request->param();

        $result = $this->validate($data, 'Favorite');
        if ($result !== true) {
            $this->error($result);
        }

        $id    = $this->request->param('id', 0, 'intval');
        $table = $this->request->param('table');


        $findFavoriteCount = Db::name("user_favorite")->where([
            'object_id'  => $id,
            'table_name' => $table,
            'user_id'    => cmf_get_current_user_id()
        ])->count();

        if ($findFavoriteCount > 0) {
            $this->error("您已收藏过啦");
        }


        $title       = base64_decode($this->request->param('title'));
        $url         = $this->request->param('url');
        $url         = base64_decode($url);
        $description = $this->request->param('description', '', 'base64_decode');
        $description = empty($description) ? $title : $description;
        Db::name("user_favorite")->insert([
            'user_id'     => cmf_get_current_user_id(),
            'title'       => $title,
            'description' => $description,
            'url'         => $url,
            'object_id'   => $id,
            'table_name'  => $table,
            'create_time' => time()
        ]);

        $this->success('收藏成功');

    }
}