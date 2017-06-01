<?php
echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
';
$sql="select c.*, b.name bankName, u.username from {$this->prename}members u, {$this->prename}bank_list b, {$this->prename}member_cash c where c.uid=u.uid and b.isDelete=0 and c.bankId=b.id";
if($_GET['fromTime'] &&$_GET['toTime']){
$sql.=' and c.actionTime between '.strtotime($_GET['fromTime']).' and '.strtotime($_GET['toTime']);
}elseif($_GET['fromTime']){
$sql.=' and c.actionTime>='.strtotime($_GET['fromTime']);
}elseif($_GET['toTime']){
$sql.=' and c.actionTime<'.strtotime($_GET['toTime']);
}
if($_GET['username'] &&$_GET['username']!='用户名'){
$sql.=" and u.username like '%{$_GET['username']}%' and concat(',',u.parents,',') like '%,{$this->user['uid']},%'";
}else{
unset($_GET['username']);
switch($_GET['type']){
case 1:
$sql.=" and uid={$this->user['uid']} order by id des";
break;
case 2:
if(!$_GET['uid']) $_GET['uid']=$this->user['uid'];
$sql.=" and u.parentId={$_GET['uid']} order by id des";
break;
case 3:
$sql.="concat(',',u.parents,',') like '%,{$this->user['uid']},%' and u.uid!={$this->user['uid']} order by id des";
break;
default:
$sql.=" and concat(',',u.parents,',') like '%,{$this->user['uid']},%' order by id desc";
break;
}
}
if($_GET['uid']=$this->user['uid']) unset($_GET['uid']);
$data=$this->getPage($sql,$this->page,$this->pageSize);
$params=http_build_query($_GET,'','&');
$stateName=array('提现成功','提交到银行处理','已取消','已支付','提现失败');
;echo '<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_1">
	<thead class="tr-top">
		<tr>
			<th>用户帐号</th>
			<th>提现金额</th>
			<th>申请时间</th>
			<th>备注</th>
			<th>状态</th>
		</tr>
	</thead>
	<tbody class="tr-cont">
	';if($data['data']) foreach($data['data'] as $var){;echo '		<tr>
			<td>';echo $var['username'];echo '</td>
			<td>';echo $var['amount'];echo '</td>
			<td>';echo date('m-d H:i',$var['actionTime']);echo '</td>
			<td>';echo $this->iff($var['state']==4,$this->iff($var['info'],$var['info'],$var['bankName'].'返回错误信息:675051'),$var['bankName'].' 处理完成');echo '</td>	
			<td>
			';
if($var['state']==3 &&$var['uid']==$this->user['uid']){
echo '<div class="sure" id="',$var['id'],'"></div>';
}else{
echo $stateName[$var['state']];
}
;echo '			</td>
		</tr>
	';};echo '	</tbody>
</table>
';
$this->display('inc_page.php',0,$data['total'],$this->pageSize,'/index.php/team/searchCashRecord-{page}?'.$params);

?>