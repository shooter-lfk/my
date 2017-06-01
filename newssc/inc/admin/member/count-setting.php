<?php

$sql="select * from {$this->prename}params_fandianset order by fanDian desc";
$data=$this->getRows($sql);
;echo '<article class="module width_full">

<form action="/admin.php/member/setUserCount"  method="post" target="ajax" call="setMemberLevel">
	<header><h3 class="tabs_involved">用户等级限额设置</h3></header>
	<table class="tablesorter" cellspacing="0">
	<thead>
		<tr>
			<th>返点</th>
			<th>不定位返点</th>
			<th>用户限额</th>
		</tr>
	</thead>
	<tbody>
	';if($data) foreach($data as $level){;echo '		<tr>
			<td><input type="text" name="data[';echo $level['id'];echo '][fanDian]" value="';echo $level['fanDian'];echo '" /></td>
			<td><input type="text" name="data[';echo $level['id'];echo '][bFanDian]" value="';echo $level['bFanDian'];echo '" /></td>
			<td><input type="text" name="data[';echo $level['id'];echo '][userCount]" value="';echo $level['userCount'];echo '" /></td>
		</tr>
	';};echo '	</tbody>
	</table>
	<footer>
		<div class="submit_link"><input type="submit" class="alt_btn" value="提交修改"/></div>
	</footer>
</form>
</article>'
?>