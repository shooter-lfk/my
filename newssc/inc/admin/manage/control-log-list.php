<?php

$para=$_GET;
if($para['username'] &&$para['username']!="管理员"){
$userWhere="and u.username like '%{$para['username']}%'";
}
if($para['type']){
$typeWhere="and l.type={$para['type']}";
}
if($_REQUEST['fromTime'] &&$_REQUEST['toTime']){
$fromTime=strtotime($_REQUEST['fromTime']);
$toTime=strtotime($_REQUEST['toTime'])+24*3600;
$timeWhere="and l.actionTime between $fromTime and $toTime";
}elseif($_REQUEST['fromTime']){
$fromTime=strtotime($_REQUEST['fromTime']);
$timeWhere="and l.actionTime>=$fromTime";
}elseif($_REQUEST['toTime']){
$toTime=strtotime($_REQUEST['toTime'])+24*3600;
$timeWhere="and l.actionTime<$fromTime";
}else{
$timeWhere=' and l.actionTime>'.strtotime('00:00');
}
$sql="select l.*, u.username from {$this->prename}admin_log l, {$this->prename}members u where l.uid=u.uid $timeWhere $typeWhere $userWhere order by l.id desc";
$data=$this->getPage($sql,$this->page,$this->pageSize);
;echo '	<table class="tablesorter" cellspacing="0">
	<thead>
		<tr>
			<th>时间</th>
			<th>管理员</th>
			<th>操作类型</th>
			<th>登录IP</th>
			<th>操作描述</th>
			<th>对应ID</th>
			<th>操作对象</th>
		</tr>
	</thead>
	<tbody>
	';if($data['data']) foreach($data['data'] as $var){;echo '		<tr>
			<td>';echo date('m-d H:i',$var['actionTime']);echo '</td>
			<td>';echo $var['username'];echo '</td>
			<td>';echo $this->adminLogType[$var['type']];echo '</td>
			<td>';echo long2ip($var['actionIP']);echo '</td>
			<td>';echo $this->ifs($var['action'],'--');echo '</td>
			<td>';echo $this->ifs($var['extfield0'],'--');echo '</td>			
			<td>';echo $this->ifs($var['extfield1'],'--');echo '</td>			
		</tr>
	';}else{;echo '		<tr>
			<td colspan="10">暂时没有Log</td>
		</tr>
	';};echo '	</tbody>
	</table>
	<footer>
	';
$rel=get_class($this).'/controlLog-{page}?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$data['total'],$rel,'betLogSearchPageAction');
;echo '	</footer>'
?>