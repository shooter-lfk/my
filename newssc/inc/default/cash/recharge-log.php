<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'充值记录');;echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
</head>
<body>
<div class="pright" style="width:720px;min-height:260px;padding:0;">
<div class="main_top">
	<div class="dtime" style="width:270px;">
		<form action="/index.php/cash/rechargeLog" method="get">
			<div class="but_sum" onclick="$(this).closest(\'form\').submit()">查询</div>
			<div class="input"><input class="fqr-in" name="endTime" value="';echo date('Y-m-d');echo '" type="date" height="20"/></div>
			<div class="input"><input class="fqr-in" name="fromTime" value="';echo date('Y-m-d',strtotime('-1 day'));echo '" type="date" height="20"/></div>
			<div style="display:none;"><input type="submit" value=""/></div>
		</form>
	</div>
	<span>充值记录</span>
</div>
		<div class="game-left" style="width:720px;padding:0;">
			<div class="biao-cont">
				<!--下注列表-->
				<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_1">
					<thead class="tr-top">
					<tr>
						<th>充值编号</th>
						<th>充值金额</th>
						<th>充值成功时间</th>
					</tr>
					</thead>
					<tbody class="tr-cont">
					';
$sql="select * from {$this->prename}member_recharge where uid={$this->user['uid']} and state=1 order by id desc";
if($_GET['fromTime'] &&$_GET['endTime']){
$fromTime=strtotime($_GET['fromTime']);
$endTime=strtotime($_GET['endTime'])+3600*24;
$sql.=" and actionTime between $fromTime and $endTime";
}elseif($_GET['fromTime']){
$sql.=' and actionTime>='.strtotime($_GET['fromTime']);
}elseif($_GET['endTime']){
$sql.=' and actionTime<'.(strtotime($_GET['endTime'])+3600*24);
}
$pageSize=10;
$list=$this->getPage($sql,$this->page,$pageSize);
if($list['data']) foreach($list['data'] as $var){
;echo '					<tr>
						<td>';echo $this->ifs($var['rechargeId'],'管理员充值');echo '</td>
						<td>';echo $var['amount'];echo '</td>
						<td>';echo date('m-d H:i',$var['actionTime']);echo '</td>
					</tr>
					';};echo '					</tbody>
				</table>
				';$this->display('inc_page.php',0,$list['total'],$this->pageSize,"/index.php/cash/rechargeLog-{page}?fromTime={$_GET['fromTime']}&endTime={$_GET['endTime']}");;echo '				<!--下注列表 end -->
			</div>
		</div>
</body>
</html>
';
?>