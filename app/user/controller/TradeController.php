<?php
namespace app\user\controller;

use cmf\controller\UserBaseController;
// use app\user\model\UserModel;
// use think\Validate;
use think\Db;

/**
* 个人中心 交易共用
*/
class TradeController extends UserBaseController
{
    // 订单详情
    public function orderDetail()
    {
        $id = $this->request->param('id/d');
        // $userId = $this->user['id'];

        $where = [
            // 'user_id'=>$userId,
        ];

        $order = model('usual/UsualCar')->getPostRelate($id, $where);
        if (empty($order)) {
            $this->error('数据消失在二次元了');
            // abort(404,'数据消失在二次元了');
        }

        $this->assign('order',$order);
        $this->fetch();
    }

    // 删除
    public function del()
    {
        // $id = $this->request->param('id/d');
        $table = $this->request->param('table/s');
        if (empty($table)) {
            $table = 'trade_order';
        }
        parent::dels(Db::name($table));
        $this->success("刪除成功！");
    }

    // 赎回资金 cancel中处理
    public function backfund()
    {$this->success('请耐心等待工作人员操作');
        $id = $this->request->param('id/d');
        $userId = $this->user['id'];

        return $this->fetch();
    }

    // 订单 客户详情
    public function ajaxBuyer()
    {
        $id = $this->request->param('id/d');
        $buyerInfo = Db::name('trade_order')
            ->field('buyer_uid,buyer_username,buyer_contact,buyer_address')
            ->where('id',$id)->find();
        $identify = lothar_verify($buyerInfo['buyer_uid']);
        $pop = ($identify==1)?'已认证':'未认证';

        // $data = lothar_toJson($data);
        $data = json_encode([
                'name'  => $buyerInfo['buyer_username'],
                'mobile'=> $buyerInfo['buyer_contact'],
                'pop'   => $pop,
                'addr'  => $buyerInfo['buyer_address'],
            ]);

        echo $data;exit();
        // return $data;
    }

    // 更多……  保留代码
    public function more()
    {
        // 多字段图片处理
        // $file_var = ['driving_license','identity_card1','identity_card2'];
        // // $file_var = ['driving_license','identity_card1','identity_card2','thumbnail'];
        // $files = model('service/Service')->uploadPhotos($file_var);
        // foreach ($files as $key => $it) {
        //     if (!empty($it['err'])) {
        //         // $this->error($it['err']);
        //     }
        //     if (!empty($it['data'])) {
        //         if ($key=='identity_card1') {
        //             $post['identi']['identity_card'][] = ['url'=>$it['data'],'name'=>''];
        //         } elseif ($key=='identity_card2') {
        //             $post['identi']['identity_card'][] = ['url'=>$it['data'],'name'=>''];
        //         } elseif ($key=='driving_license') {
        //             $post['identi']['driving_license'] = $it['data'];
        //         } else {
        //             $post['more'][$key] = $it['data'];
        //         }
        //     }
        // }
        // 多图上传 photos
        // $pdata = model('service/Service')->uploadPhotoMulti('photos');
        // $post['more']['photos'][] = [];

        // $id = $this->request->param('id/d');
        // return $this->fetch();
    }

}