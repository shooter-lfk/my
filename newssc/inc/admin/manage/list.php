<?php

$sql="select uid, username from {$this->prename}members where admin=1 and enable=1 and isDelete=0";
$data=$this->getPage($sql,$this->page,$this->pageSize);
$sql="select * from {$this->prename}member_session where uid=? order by id desc limit 1";
;echo '<article class="module width_full">
	<header>
		<h3 class="tabs_involved">管理员管理
			<div class="submit_link wz">
				<input type="button" value="添加管理员" onclick="manageAddManagerModal()" class="alt_btn">
			</div>
		</h3>
	</header>
	<table class="tablesorter" cellspacing="0">
		<thead>
			<tr>
				<td>UID</td>
				<td>用户名</td>
				<td>登录IP</td>
				<td>状态</td>
				<td>最后登录时间</td>
				<td>操作</td>
			</tr>
		</thead>
		<tbody>
		';
if($data['data']) foreach($data['data'] as $var){
$login=$this->getRow($sql,$var['uid']);
;echo '			<tr>
				<td>';echo $var['uid'];echo '</td>
				<td>';echo $var['username'];echo '</td>
				<td>';echo $this->ifs(long2ip($login['loginIP']),'--');echo '</td>
				<td>';echo $this->iff($login['isOnLine'] &&$login['accessTime']>$GLOBALS['conf']['member']['sessionTime'],'在线','离线');echo '</td>
				<td>';echo $this->iff($login['loginTime'],date('Y-m-d H:i',$login['loginTime']),'--');echo '</td>
				<td><a href="/admin.php/manage/pwdManagerModal/';echo $var['uid'];echo '" target="ajax" call="manageChangePwdModal">修改密码</a> | <a href="/admin.php/manage/deleteManager/';echo $var['uid'];echo '" target="ajax" call="manageDeleteManager" dataType="json">删除</a></td>
			</tr>
		';};echo '		</tbody>
	</table>
	<footer>
	';
$rel=get_class($this).'/coinLog-{page}?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$data['total'],$rel,'betLogSearchPageAction');
;echo '	</footer>
</article>';
?>