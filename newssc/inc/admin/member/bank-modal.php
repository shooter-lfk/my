<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="/skin/admin/layout.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="/skin/js/jqueryui/skin/smoothness/jquery-ui-1.8.23.custom.css" />
<!--[if IE]>
	<link rel="stylesheet" href="/skin/admin/ie.css" type="text/css" />
	<script src="/skin/js/html5.js"></script>
<![endif]-->
</head>
<body>
<form name="system_addBank" action="/admin.php/member/updateBank" enctype="multipart/form-data" method="POST">
';
$banks=$this->getRows("select id, name from {$this->prename}bank_list where isDelete=0 order by sort");
if($args[0]){
$bankId=intval($args[0]);
$bank=$this->getRow("select * from {$this->prename}member_bank where id=$bankId");
echo '<input type="hidden" name="id" value="',$bank['id'],'"/>';
}
;echo '<table class="tablesorter leftb" cellspacing="0">
		<tr> 
			<td class="title">银行名称</td> 
			<td>
				<select name="bankId">
				';if($banks) foreach($banks as $var){;echo '					<option value="';echo $var['id'];echo '" ';echo $this->iff($bank['bankId']==$var['id'],'selected');echo '>';echo $var['name'];echo '</option>
				';};echo '				</select>
			</td>
		</tr>
		<tr> 
			<td class="title">姓名</td> 
			<td><input type="text" name="username" value="';echo $bank['username'];echo '"/></td>
		</tr>
		<tr> 
			<td class="title">账号</td> 
			<td><input type="text" name="account" value="';echo $bank['account'];echo '"/></td>
		</tr>
</table>
</form>
</body>
</html>'
?>