<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'基本信息');;echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
<style>
.table_3 td {background:none;}
.table_3 label {height:25px;line-height:25px;float:left;width:6em;display:inline;overflow:hidden;}
.table_3 label input {margin-top:5px;clear:both;}
select{margin-right:0;padding:0;line-height:20px;}
</style>
</head>
<body>
<div class="tbbox1">
<div class="a-top"><div class="a-title spn9">基本信息</div></div>
	<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_3">
				<tr>
				 <th width="96">账号信息：</th><td width="444"> ';echo $this->user['username'];echo ' (';echo $this->iff($this->user['type'],'代理','会员');echo ') &nbsp;&nbsp; 用户编号：';echo $this->user['uid'];echo ' &nbsp;&nbsp; <em style="display:none">等级：Lv';echo $this->user['grade'];echo ' &nbsp;&nbsp; 返点：';echo $this->user['fanDian'];echo '%</em></td>
				</tr>
				<tr>
				 <th>可用资金：</th><td> ';echo $this->user['coin'];echo '元 &nbsp;&nbsp; 冻结资金：';echo $this->user['fcoin'];echo '元</td>
				</tr>
				<tr>
				 <th>积分：</th><td> ';echo $this->user['score'];echo '</td>
				</tr>
	</table>
</div>
<div class="tbbox1">
<div class="a-top"><div class="a-title spn9">银行信息</div></div><a name="bank-info"></a>
<form action="/index.php/safe/setCBAccount" method="post" target="ajax" onajax="safeBeforSetCBA" call="safeSetCBA">
';if($this->user['coinPassword']){;echo '	<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_3">
		<tr><th width="96">账号类型：</th><td>';
$myBank=$this->getRow("select * from {$this->prename}member_bank where uid=?",$this->user['uid']);
$banks=$this->getRows("select * from {$this->prename}bank_list where isDelete=0 order by sort");
$flag=($myBank['editEnable']!=1)&&($myBank);
;echo '			<select name="bankId" class="input_text" ';echo $this->iff($flag,'disabled');echo '>';foreach($banks as $bank){;echo '				<option value="';echo $bank['id'];echo '" ';echo $this->iff($myBank['bankId']==$bank['id'],'selected');echo '>';echo $bank['name'];echo '</option>
			';};echo '</select>';echo $this->iff(!$flag,'<span style="color:#f30;">银行账号一旦设置，将不可修改，请认真设置！</span>');echo '</td></tr>
		<!--tr><th>密保邮箱：</th><td><input name="safeEmail" class="input_text" value="';echo $this->user['safeEmail'];echo '"/></td></tr-->
		<tr><th>姓名：</th><td><input name="username" class="input_text" value="';echo preg_replace('/^(\w{1}).*(\w{1})$/','\1*\1',$myBank['username']);echo '" ';echo $this->iff($flag,'disabled');echo '/></td></tr>
		<tr><th>账号：</th><td><input name="account" class="input_text" value="';echo preg_replace('/^(\w{3}).*(\w{3})$/','\1***\2',$myBank['account']);echo '" ';echo $this->iff($flag,'disabled');echo '/></td></tr>
		<tr><th>资金密码：</th><td><input name="coinPassword" class="input_text" type="password" ';echo $this->iff($flag,'disabled');echo ' /></td></tr>
		<tr><th></th><td><input type="submit" ';echo $this->iff($flag,'disabled');echo ' class="buttonabc" value="设置银行" /></td></tr>
	</table>
';}else{;echo '	<div class="tishi">设置银行信息要用资金密码，您尚未设置资金密码！&nbsp;&nbsp;<a href="/index.php/safe/passwd" style="text-decoration:none; color:green">设置资金密码>></a></div>
';};echo '  </form>
</div>
</body>
</html>'
?>