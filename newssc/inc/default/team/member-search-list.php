<?php
echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
<script type="text/javascript" src="/skin/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="/skin/js/jqueryui/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" src="/skin/js/jqueryui/i18n/jquery.ui.datepicker-zh-CN.js"></script>
<script type="text/javascript" src="/skin/js/artDialog/artDialog.js?skin=aero"></script>
<script type="text/javascript" src="/skin/js/artDialog/plugins/iframeTools.source.js"></script>
';
$sql="select * from {$this->prename}members where ";
if($_GET['username'] &&$_GET['username']!='用户名'){
$sql.="username like '%{$_GET['username']}%' and concat(',',parents,',') like '%,{$this->user['uid']},%'";
}else{
unset($_GET['username']);
switch($_GET['type']){
case 0:
$sql.="concat(',',parents,',') like '%,{$this->user['uid']},%'";
break;
case 1:
$sql.="uid={$this->user['uid']}";
break;
case 2:
if(!$_GET['uid']) $_GET['uid']=$this->user['uid'];
$sql.="parentId={$_GET['uid']}";
break;
case 3:
$sql.="concat(',',parents,',') like '%,{$this->user['uid']},%' and uid!={$this->user['uid']}";
break;
}
}
if($_GET['uid']=$this->user['uid']) unset($_GET['uid']);
$data=$this->getPage($sql,$this->page,$this->pageSize);
$params=http_build_query($_GET,'','&');
$sql="select uid, username from {$this->prename}members where uid=?";
$sql="select * from {$this->prename}member_session where uid=? order by id desc limit 1";
;echo '<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_1">
	<thead class="tr-top">
		<tr>
			<th>编号</th>
			<th>用户名</th>
			<!--th>等级</th-->
			<th>可用资金</th>
			<th>冻结资金</th>
			<th>全部资金</th>
			<th>返点</td>
			<th>状态</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody class="tr-cont">
	';if($data['data']) foreach($data['data'] as $var){
$login=$this->getRow($sql,$var['uid']);
;echo '		<tr>
			<td>';echo $var['uid'];echo '</td>
			<td>';echo $var['username'];echo '</td>
			<!--td>Lv';echo $var['grade'];echo '</td-->
			<td>';echo $var['coin'];echo '</td>
			<td>';echo $var['fcoin'];echo '</td>
			<td>';echo $var['coin']+$var['fcoin'];echo '</td>
			<td>';echo $var['fanDian'];echo '%</td>
			<td>';echo $this->iff($login['isOnLine'] &&$login['accessTime']>$GLOBALS['conf']['member']['sessionTime'],'在线','离线');echo '';echo $this->iff($var['enable'],'',' 无效');echo '</td>
			<td><a class="caozuo" href="/index.php/team/searchMember?type=2&uid=';echo $var['uid'];echo '">查看下级</a> <!--a onClick="art.dialog.open(\'/index.php/team/userUpdate/';echo $var['uid'];echo '\', {id: \'testID6\',lock: true,title: \'成员返点修改\',width:420});">编辑</a--></td>
		</tr>
	';};echo '	</tbody>
</table>
';
$this->display('inc_page.php',0,$data['total'],$this->pageSize,'/index.php/team/searchMember-{page}?'.$params);

?>