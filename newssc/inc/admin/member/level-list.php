<?php

$sql="select * from {$this->prename}member_level order by level";
$data=$this->getRows($sql);
;echo '<article class="module width_full">

<form action="/admin.php/member/setLevel"  method="post" target="ajax" call="setMemberLevel">
	<header><h3 class="tabs_involved">等级设置</h3></header>
	<table class="tablesorter" cellspacing="0">
	<thead>
		<tr>
			<th>级别</th>
			<th>级别名称</th>
			<th>需要积分</th>
			<th>每日提现次数</th>
		</tr>
	</thead>
	<tbody>
	';if($data) foreach($data as $level){;echo '		<tr>
			<td>';echo $level['level'];echo '</td>
			<td><input type="text" name="data[';echo $level['id'];echo '][levelName]" value="';echo $level['levelName'];echo '" /></td>
			<td><input type="text" name="data[';echo $level['id'];echo '][minScore]" value="';echo $level['minScore'];echo '" /></td>
			<td><input type="text" name="data[';echo $level['id'];echo '][maxToCashCount]" value="';echo $level['maxToCashCount'];echo '" /></td>
		</tr>
	';};echo '	</tbody>
	</table>
	<footer>
		<div class="submit_link"><input type="submit" class="alt_btn" value="提交修改"/></div>
	</footer>
</form>
</article>';
?>