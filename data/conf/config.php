<?php	
return [
  'cmf_default_theme' => 'datong_car',
  'insurance_order_status' => 
  [
    -11 => '过期失效',
    -3 => '管理员取消',
    -2 => '卖家取消',
    -1 => '取消/关闭',
    0 => '待审核',
    1 => '已审核',
    5 => '已确认合同',
    6 => '已支付',
    10 => '完成',
  ],
  'service_status' => 
  [
    -11 => '过期',
    -5 => '卖家取消失败',
    -4 => '买家取消失败',
    -3 => '管理员取消',
    -2 => '卖家取消',
    -1 => '买家取消',
    0 => '预约中',
    1 => '预约成功',
    10 => '完成',
  ],
  'service_define_data' => 
  [
    'username' => '车主名',
    'contact' => '联系方式',
    'telephone' => '电话',
    'birthday' => '生日',
    'address' => '详情地址',
    'seller_name' => '卖家名',
    'seller_contact' => '卖家联系方式',
    'seller_birthday' => '卖家生日',
    'plateNo' => '车牌号码',
    'car_vin' => '车架号',
    'reg_time' => '注册日期',
    'identity_card' => '身份证',
    'driving_license' => '行驶证',
    'qualified' => '合格证',
    'loan_invoice' => '贷款发票',
    'appoint_time' => '预约时间',
    'service_point' => '服务点',
  ],
  'trade_order_status' => 
  [
    -11 => '过期',
    -5 => '卖家取消失败',
    -4 => '买家取消失败',
    -3 => '管理员取消',
    -2 => '卖家取消',
    -1 => '买家取消',
    0 => '未支付',
    1 => '预约中',
    8 => '全部支付',
    10 => '完成',
  ],
  'usual_car_type' => 
  [
    1 => '准新车',
    2 => '练手车',
    3 => '分期购',
  ],
  'usual_car_sell_status' => 
  [
    -11 => '售罄',
    -2 => '禁止出售',
    -1 => '下架',
    0 => '初始态',
    1 => '上架(售卖中]',
    2 => '已下单',
    3 => '已付款',
    10 => '完成',
  ],
  'usual_car_status' => 
  [
    -11 => '售罄',
    -2 => '禁止出售',
    -1 => '下架',
    0 => '初始态',
    1 => '上架(出售]',
    2 => '已付款',
    3 => '已下单',
    10 => '完成(最终确认]',
  ],
  'usual_item_cate_codetype' => 
  [
    'text' => '文本类型',
    'select' => '选择框',
    'radio' => '单选框',
    'checkbox' => '复选框',
    'number' => '数字型',
    'hidden' => '隐藏域',
  ],
  'verify_status' => 
  [
    -1 => '禁止认证',
    0 => '未认证',
    1 => '已认证',
    2 => '取消',
    3 => '认证失败',
  ],
  'verify_define_data' => 
  [
    'mobile' => '手机号',
    'email' => '邮箱',
    'identity_card' => '身份证',
    'driving_license' => '行驶证',
    'real_name' => '姓名',
    'gender' => '性别',
    'birthday' => '生日',
    'telephone' => '电话',
    'alipay' => '支付宝',
    'weixin' => '微信',
    'ID_Type' => '证件类型',
    'ID_No' => '证件号码',
    'booklet' => '户口本',
    'house_certificate' => '房产证',
    'marriage_lines' => '结婚证',
    'birthcity' => '出生地',
    'residecity' => '居住地',
    'diploma' => '毕业证书',
    'graduateschool' => '毕业院校',
    'education' => '学历',
    'business_license' => '营业执照',
    'work_occupation' => '职业',
    'work_company' => '公司',
    'work_position' => '职位',
    'work_experience' => '工作经历',
  ],
  'pagerset' => 
  [
    'size' => 12,
  ],
];