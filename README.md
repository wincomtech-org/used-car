# used-car
大通车服

流程图：
    https://www.processon.com/view/link/59cc6eb9e4b06e9fd2f745d4
    密码：1234
GIT源码：
    https://github.com/wincomtech-org/used_car
DOAMIN：
    http://usedcar.wincomtech.cn/
正式网址：http://www.datongchefu.cn/
测试账号：lothar  111111
        ###备用   super  111111
服务商城测试：http://www.datongchefu.cn/shop/post/details/id/6.html
模板路径：
    \public\themes\datong_car\  主目录
    \public\themes\datong_car\public\  共用文件 head、header、footer、nav、banner、morejs
    \public\themes\datong_car\public\assets\  资源文件 css、js、images、font
DOMEvent DOMDocumentWrapper phpQueryEvents phpQuery Callback JSONP
    \simplewind\extend\phpQuery\phpQuery.php
        $.getJSON(url,data,callback)





大通车服二手车设计
*.

【修改日志】
冀B

订单状态：-11过期,-2卖家取消,-1买家取消,0待付款,1待审查,2待发货,3待收货,4待评价,10完成

20180421
1、关于前台车辆列表页，统一不显示首付相关字眼保持样式排版统一
2、前台车辆详情页，有首付则显示，没有就不显示
3、车辆图集分类
4、微信端微信登录

20180411
手机拍照

20180409
商城全面测试

20180408
缩略图如果有变动的才生成。
如果有身份证、行驶证则导出。
    大通车服 - 李总:
        后台的导出功能需要把行车本和身份证图片一起导出，尤其是业务订单里面的

20180404
在业务预约成功后短信通知用户。(\app\service\controller\AdminServiceController.php  lothar_sms_send())

20180330
筛选
数据库优化标准: 100w数据 3s以内


20180329
客户对接：百度商桥、云片短信、快递100 接口
服务商城列表筛选未完成

20180328
修正没有规格时，加入购物车失败

20180326
首页轮播图
底部新闻轮播图

20180226
###1、注册
###2、短信(lothar_sms_send())：找回密码、业务预约成功提醒、

20180222
###1、坐标修改
???2、自定义资料
###3、业务模型提交后，请跳转该业务预约详情页，这样客户会使用比较方便，知道自己预约的业务情况。
###4、业务可多次申请



3.17
在banner.html里添加了懒加载的jq代码，懒加载的代码在通用的js下lazyload.js
<img  class="image-item"  lazyload="true" data-original="地址" alt="">
应该也可以给个默认图 src='默认图片'
