<?php
include_once ( "config.php" );

//订单号
$BillNo = $_POST["BillNo"];

//金额
$Amount = $_POST["Amount"];

//支付状态
$Succeed = $_POST["Succeed"];

//支付结果
$Result = $_POST["Result"];

//取得的MD5校验信息
$MD5info = $_POST["MD5info"]; 

//备注
$Remark = $_POST["Remark"];

//校验源字符串
$md5src = $BillNo.$Amount.$Succeed.$userkey;

//MD5检验结果
$md5sign = strtoupper(md5($md5src));

if ($MD5info==$md5sign){
	
	if ( strval($Succeed) == "88" ) { 
		
		$rechargeid = $BillNo;
		
		$tablepix = $conf['db']['prename'];
		
		if ($rechargeid>0){
			
			$conn = mysql_connect($conf['db']['host'],$conf['db']['user'],$conf['db']['password']);
			if (!$conn){
				
				die('Could not connect: ' . mysql_error());
			}
			mysql_select_db($conf['db']['dbname'],$conn);
			
			mysql_query("SET names 'utf8'");
			
			$query = mysql_query("select * from {$tablepix}member_recharge where rechargeid= '".$rechargeid."'");
			
			$recharge = mysql_fetch_array($query);
			
			if($recharge['state']<1){
				
				$query = mysql_query("select * from {$tablepix}members where uid= '".$recharge['uid']."'");
				
				$user  = mysql_fetch_array($query);
				
				if ($user){
					
					$info = '在线充值自动到账';
					
					mysql_query("UPDATE {$tablepix}members SET coin = coin+'".$Amount."' WHERE uid = '".$recharge['uid']."'");
					
					mysql_query("UPDATE {$tablepix}member_recharge SET state=1,rechargeTime=UNIX_TIMESTAMP(),rechargeAmount='".$Amount."',coin='".$user['coin']."', info='".$info."' where rechargeid='".$rechargeid."'");
				}
				
			}
			
			mysql_close($conn);
		}
		
		echo 'ok';
		
	}else{
	
		writeLog("fail");
		
		echo "fail(".strval($Succeed).")";
		
	}
	
}else{

	writeLog($BillNo."=err");
	
	echo "err";	
}
?>