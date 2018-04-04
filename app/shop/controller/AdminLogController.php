<?php
namespace app\shop\controller;

use app\admin\model\AdminLogModel;
use cmf\controller\AdminBaseController;

/**
 * 操作日志
 */
class AdminLogController extends AdminBaseController
{

    /**
     * 日志管理
     * @adminMenu(
     *     'name'   => '日志管理',
     *     'parent' => 'shop/AdminIndex/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '日志管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        // $param = $this->request->param();
        $scModel = new AdminLogModel;
        $where   = [
            'type'    => 'goods',
            // 'user_id' => cmf_get_current_admin_id(),
        ];
        $list = $scModel->all($where);
        $this->assign('list',$list->items());
        // $list->appends($param);
        $this->assign('pager',$list->render());
        return $this->fetch();
    }

    /**
     * 日志删除
     * @adminMenu(
     *     'name'   => '日志删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10,
     *     'icon'   => '',
     *     'remark' => '',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $ids = $this->request->param('ids');
        $scModel = new AdminLogModel;
        if (empty($ids)) {
            $this->error('操作有误！');
        } elseif (is_array($ids)) {
            $result = $scModel->destroy($ids);
        } else {
            $result = $scModel->where('id',$ids)->delete();
        }
        if (!empty($result)) {
            $this->success('删除成功！');
        }
        $this->error('删除失败！');
    }
}
