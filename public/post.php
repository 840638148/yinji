<?php
//初始化
$curl = curl_init();
//设置抓取的url
curl_setopt($curl, CURLOPT_URL, 'http://dev.yinjispace.com/notify/alipay');
//设置头文件的信息作为数据流输出
curl_setopt($curl, CURLOPT_HEADER, 1);
//设置获取的信息以文件流的形式返回，而不是直接输出。
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//设置post方式提交
curl_setopt($curl, CURLOPT_POST, 1);
//设置post数据
$post_data = array(
'gmt_create' => '2019-07-27 15:00:26',
  'charset' => 'UTF-8',
  'gmt_payment' => '2019-07-27 15:00:31',
  'notify_time' => '2019-07-27 15:00:31',
  'subject' => 'VIP购买',
  'sign' => 'qhBJfHII+gzGrnn/4jlcVsTTotRkX60j3wrpxKRpxOCgJ+YmE1UjzmXJKgxuGXbgb8lgnmJBo7WOVk4aXuPUrULDDz+cpdRthsO3RvnwKYEmOJu8l4rITwn2wrOUYHfMqhkPIxzlXqjH5X7xGC9sttA2tD/CkSBYuHuO/kohcH2V06U4Dp8jI/u902hKtQMHOC3N7enysSYtGGCEXaRuavnczRBEdLDApIue8qILQI7tQOyH2PyMKkbewM0LuBXgHCdOSHbdx9OhMH32cdqIuKyy46ccKfumD8SXUw2jsMUfyWoR4vz0cKgLjT0jKngIBrs6uQdzpblmzudiatujyw==',
  'buyer_id' => '2088002653752198',
  'invoice_amount' => '0.00',
  'version' => '1.0',
  'notify_id' => '2019072700222150031052190552525154',
  'fund_bill_list' => '[{"amount":"0.01","fundChannel":"COUPON"}]',
  'notify_type' => 'trade_status_sync',
  'out_trade_no' => 'YJVIP201907271459486064294',
  'total_amount' => '0.01',
  'trade_status' => 'TRADE_SUCCESS',
  'trade_no' => '2019072722001452190551895538',
  'auth_app_id' => '2019072265970177',
  'receipt_amount' => '0.01',
  'point_amount' => '0.00',
  'buyer_pay_amount' => '0.01',
  'app_id' => '2019072265970177',
  'sign_type' => 'RSA2',
  'seller_id' => '2088531624170333',
);

//post提交的数据
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
//执行命令
$data = curl_exec($curl);
//关闭URL请求
curl_close($curl);
//显示获得的数据
print_r($data); 
