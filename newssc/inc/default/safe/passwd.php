<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'安全中心－密码管理');;echo '<link href="/skin/main/css/idealForms/idealForms.css" rel="stylesheet" type="text/css" media="screen"/> 
<link href="/skin/main/css/idealForms/idealForms-theme-sapphire.css" rel="stylesheet" type="text/css" media="screen"/>
<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
<style>
.table_3 td {background:none;}
.table_3 label {height:25px;line-height:25px;float:left;width:6em;display:inline;overflow:hidden;}
.table_3 label input {margin-top:5px;clear:both;}
</style>
<script type="text/javascript" src="/skin/main/js/modernizr-1.6.min.js"></script>
<script type="text/javascript" src="/skin/main/js/jquery-idealForms.js"></script>
<script type="text/javascript" src="/skin/main/js/scripts.js"></script>
</head>
<body>
<form action="/index.php/safe/setPasswd" method="post" target="ajax" onajax="safeBeforSetPwd" call="safeSetPwd">
<div class="tbbox1">
<div class="a-top"><div class="a-title spn9">登录密码管理</div></div>
	<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_3">
		<tr><th width="96">原始密码：</th><td><input name="oldpassword" type="password" value=""/></td></tr>
		<tr><th>新密码：</th><td><input name="newpassword" type="password" value=""/></td></tr>
		<tr><th>确认新密码：</th><td><input type="password" class="confirm" value=""/></td></tr>
		<tr><th></th><td><div style="display:none;"><input type="submit" value=""/></div><div class="buttonabc xiugai" onclick="$(this).closest(\'form\').submit()">修改密码</div></td></tr>
	</table>
</div>
</form>
				
<form action="/index.php/safe/setCoinPwd" method="post" target="ajax" onajax="safeBeforSetCoinPwd" call="safeSetPwd">
';if($args[0]){;echo '<div class="tbbox1">
<div class="a-top"><div class="a-title spn9">资金密码管理</div></div>
	<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_3">
		<tr><th width="96">原始密码：</th><td><input name="oldpassword" type="password" value=""/></td></tr>
		<tr><th>新密码：</th><td><input name="newpassword" type="password" value=""/></td></tr>
		<tr><th>确认新密码：</th><td><input type="password" class="confirm" value=""/></td></tr>
		<tr><th></th><td><div style="display:none;"><input type="submit" value=""/></div><div class="buttonabc xiugai" onclick="$(this).closest(\'form\').submit()">修改密码</div></td></tr>
	</table>
</div>
';}else{;echo '<div class="tbbox1">
<div class="a-top"><div class="a-title spn9">设置资金密码</div></div>
	<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_3">
		<tr><th colspan="2" align="center" style="color:#666">资金密码：提款、充值、还有积分兑换等都必须输入资金密码！</th></tr>
		<tr><th width="96">密码：</th><td><input name="newpassword" type="password" value=""/></td></tr>
		<tr><th>确认新密码：</th><td><input type="password" class="confirm" value=""/></td></tr>
		<tr><th></th><td><div style="display:none;"><input type="submit" value=""/></div><div class="buttonabc xiugai" onclick="$(this).closest(\'form\').submit()">设置密码</div></td></tr>
	</table>
</div>
';};echo '</form>
</body>
</html>
';
?>