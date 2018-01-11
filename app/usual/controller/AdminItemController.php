<?php
namespace app\usual\controller;

use cmf\controller\AdminBaseController;
// use app\usual\model\UsualItemModel;
use think\Db;

class AdminItemController extends AdminBaseController
{
    // function _initialize()
    // {
    //     parent::_initialize();
    // }

    public function index()
    {
        $param = $this->request->param();//接收筛选条件
        $cateId = $this->request->param('cateId',0,'intval');

        $data = model('UsualItem')->getLists($param);
        $data->appends($param);
        $cates = model('UsualItemCate')->getCategoryTree($cateId,0,0,true);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('cateId', $cateId);
        $this->assign('categorys', $cates);
        $this->assign('lists', $data->items());
        $this->assign('pager', $data->render());

        return $this->fetch();
    }

    public function add()
    {
        $cateId = $this->request->param('cid',0,'intval');
        $insertId = intval(Db::name('usual_item')->max('id'))+1;

        $cates = model('UsualItemCate')->getCategoryTree($cateId,0,0,true);

        // $this->assign('cateId', $cateId);
        $this->assign('insertId', $insertId);
        $this->assign('categorys', $cates);

        return $this->fetch();
    }
    public function addPost()
    {
        if ($this->request->isPost()) {
            // $data   = $this->request->param();
            $data   = $_POST;// 避免被转译
            $post   = $data['post'];
            $post['update_time'] = time();
            $result = $this->validate($post,'Item.add');
            if ($result !== true) {
                $this->error($result);
            }

            // $post['name'] = htmlspecialchars_decode($post['name']);// 反转译
            // $this->error($post['name']);

            model('UsualItem')->adminAddArticle($post);

            // 钩子
            // $post['id'] = model('UsualItem')->id;
            // $hookParam          = [
            //     'is_add'  => true,
            //     'article' => $post
            // ];
            // hook('portal_admin_after_save_article', $hookParam);

            $this->success('添加成功!', url('AdminItem/edit', ['id'=>model('UsualItem')->id,'cid'=>$post['cate_id']]));
        }
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        $cateId = $this->request->param('cid', 0, 'intval');

        $post = model('UsualItem')->getPost($id);
        $cateId = empty($cateId) ? intval($post['cate_id']) : $cateId;
        $cates = model('UsualItemCate')->getCategoryTree($cateId,0,0,true);

        $this->assign('post', $post);
        $this->assign('cateId', $cateId);
        $this->assign('categorys', $cates);
        return $this->fetch();
    }
    public function editPost()
    {
        if ($this->request->isPost()) {
            // $data   = $this->request->param();
            $data   = $_POST;// 避免被转译

            $post   = $data['post'];
            $post['update_time'] = time();
            $result = $this->validate($post, 'Item.edit');
            if ($result !== true) {
                $this->error($result);
            }

            model('UsualItem')->adminEditArticle($post);

            // 钩子
            // $hookParam = [
            //     'is_add'  => false,
            //     'article' => $post
            // ];
            // hook('portal_admin_after_save_article', $hookParam);

            $this->success('保存成功!');
        }
    }

    public function delete()
    {
        $param = $this->request->param();

        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            $resultPortal = model('UsualItem')
                ->where(['id' => $id])
                ->update(['delete_time' => time()]);
            if ($resultPortal) {
                $result       = model('UsualItem')->where(['id' => $id])->find();
                $data         = [
                    'object_id'   => $result['id'],
                    'create_time' => time(),
                    'table_name'  => 'Insurance',
                    'name'        => $result['name']
                ];
                Db::name('recycleBin')->insert($data);
            }
            $this->success("删除成功！", '');
        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $recycle = model('UsualItem')->where(['id' => ['in', $ids]])->select();
            $result  = model('UsualItem')->where(['id' => ['in', $ids]])->update(['delete_time' => time()]);
            if ($result) {
                foreach ($recycle as $value) {
                    $data = [
                        'object_id'   => $value['id'],
                        'create_time' => time(),
                        'table_name'  => 'UsualItem',
                        'name'        => $value['name']
                    ];
                    Db::name('recycleBin')->insert($data);
                }
                $this->success("删除成功！", '');
            }
        }
    }

    public function publish()
    {
        $param           = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('UsualItem')->where(['id' => ['in', $ids]])->update(['status' => 1, 'published_time' => time()]);
            $this->success("启用成功！", '');
        }

        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('UsualItem')->where(['id' => ['in', $ids]])->update(['status' => 0]);
            $this->success("隐藏成功！", '');
        }
    }
    public function top()
    {
        $param           = $this->request->param();
        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('UsualItem')->where(['id' => ['in', $ids]])->update(['is_top' => 1]);
            $this->success("置顶成功！", '');

        }
        if (isset($_POST['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('UsualItem')->where(['id' => ['in', $ids]])->update(['is_top' => 0]);
            $this->success("取消置顶成功！", '');
        }
    }
    public function recommend()
    {
        $param           = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');
            model('UsualItem')->where(['id' => ['in', $ids]])->update(['is_rec' => 1]);
            $this->success("推荐成功！", '');

        }
        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');
            model('UsualItem')->where(['id' => ['in', $ids]])->update(['is_rec' => 0]);
            $this->success("取消推荐成功！", '');

        }
    }


    public function listOrder()
    {
        parent::listOrders(Db::name('UsualItem'));
        $this->success("排序更新成功！", '');
    }

    public function move()
    {

    }

    public function copy()
    {

    }
}