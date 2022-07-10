<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
//  回调域名:需手动设置
$notifyDomain = "https://v2board.domain.com"; 
//  回调路径:需手动设置
$notifyPath = "/api/v1/guest/payment/notify/VmqPay/ovR1wZIi";
//  通讯密钥:需手动设置
$key = "a7cc8678193ee9c70ae3d75fd04ae6a9"; 
//  商户订单号
$payId = $_GET['payId'];
//  云端订单号
$orderId = $_GET['orderId'];
//  混淆参数    
$param = $_GET['param'];
//  支付方式：微信支付为1 支付宝支付为2
$type = $_GET['type'];  
//  订单金额
$price = $_GET['price'];
//  实际支付金额
$reallyPrice = $_GET['reallyPrice'];
//  签名
//  校验签名计算方式 = md5(payId + param + type + price + reallyPrice + 通讯密钥)
$sign = md5($payId.$param.$type.$price.$reallyPrice.$key); 
$_sign = $_GET['sign']; 
if ($sign != $_sign) {
    echo "error_sign";//sign校验不通过
    exit();
}
//  生成回调签名计算方式=md5(payId + param + 通讯密钥)
$callbackSign = md5($payId . $param . $key);
$params = [
    'payId' => $payId,
    'orderId' => $orderId,
    'sign' => $callbackSign
];
echo "支付成功！请勿刷新或关闭本页面，正在回传结果……";
$notifyUrl = $notifyDomain . $notifyPath . "?". http_build_query($params);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $notifyUrl);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$output = curl_exec($ch);
curl_close($ch);
echo $output;
echo "……";
if($output == 'success'){
    $payUrl = $notifyDomain . "/#/order/" . $payId;
    echo "<a href=$payUrl>点我跳转订单页</a>";
}else{
    echo "回传失败，请刷新页面或联系管理员";
}
exit();
?>