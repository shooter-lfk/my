<?php
include_once ( "config.php" );

//[必填]订单号(商户自己产生：要求不重复)
$BillNo = $_GET['rechargeId'];

//[必填]订单金额
$Amount = sprintf('%01.2f',$_REQUEST['amount']);				

//[必填]返回数据给商户的地址(商户自己填写):::注意请在测试前将该地址告诉我方人员;否则测试通不过
$httphost = "http://".$_SERVER['HTTP_HOST'];

$ReturnURL = $httphost."/ecpss/back.php";	 	

//[必填]支付完成后，后台接收支付结果，可用来更新数据库值
$AdviceURL = $httphost."/ecpss/notify.php";	
	
$defaultBankNumber = $_REQUEST['bankco'];

$Remark = "";  //[选填]升级。
     
//校验源字符串
$md5src = $userid.$BillNo.$Amount.$ReturnURL.$userkey;

//MD5检验结果
$MD5info = strtoupper(md5($md5src));

$products="products info";

?>
<html>
<head>
<title>正在为您连接银行</title>
</head>
<body>
<form action="<?=$reqURL_onLine?>" method="post" name="E_FORM" >
<input type="hidden" name="MerNo" value="<?=$userid?>">
<input type="hidden" name="BillNo" value="<?=$BillNo?>">
<input type="hidden" name="Amount" value="<?=$Amount?>">
<input type="hidden" name="ReturnURL" value="<?=$ReturnURL?>" >
<input type="hidden" name="AdviceURL" value="<?=$AdviceURL?>" >
<input type="hidden" name="MD5info" value="<?=$MD5info?>">
<input type="hidden" name="Remark" value="<?=$Remark?>">
<input type="hidden" name="defaultBankNumber" value="<?=$defaultBankNumber?>">
<input type="hidden" name="products" value="<?=$products?>">
</form>
<script>
document.E_FORM.submit();
</script>
</body>
</html>