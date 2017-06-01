<?php
	$nodeId=1;
$sql="select * from {$this->prename}content where nodeId=$nodeId order by id desc";
$data=$this->getPage($sql,$this->page,$this->pageSize);
;echo '<article class="module width_full">
	<header>
		<h3 class="tabs_involved">系统公告
			<div class="submit_link wz">
			<input type="submit" value="添加公告" onclick="sysAddNotice()" class="alt_btn">
			</div>
		</h3>
	</header>
	<table class="tablesorter" cellspacing="0">
	<thead>
		<tr>
			<td>日期</td>
			<td>内容</td>
			<td>是否显示</td>
			<td>操作</td>
		</tr>
	</thead>
	<tbody>
	';if($data['data']) foreach($data['data'] as $var){;echo '		<tr>
			<td>';echo date('Y-m-d',$var['addTime']);echo '</td>
			<td width="60%"><input type="text" name="content" value="';echo $var['content'];echo '" style="width:100%"></td>
			<td><input type="checkbox" name="enable" value="1" ';echo $this->iff($var['enable'],'checked');echo '/></td>
			<td><a href="/admin.php/system/updateNotice/';echo $var['id'];echo '" target="ajax" method="post" onajax="sysBeforeUpdateNotice" call="sysReloadNotice">修改保存</a> | <a href="/admin.php/system/deleteNotice/';echo $var['id'];echo '" target="ajax" call="sysReloadNotice">删除</a></td>
		</tr>
	';}else{;echo '		<tr>
			<td colspan="4">暂时没有系统公告，要添加公告请点击右上角按钮。</td>
		</tr>
	';};echo '	</tbody>
	</table>
	<footer>
	';
$rel=get_class($this).'/notice-{page}?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$data['total'],$rel,'betLogSearchPageAction');
;echo '	</footer>
</article>

';
?>