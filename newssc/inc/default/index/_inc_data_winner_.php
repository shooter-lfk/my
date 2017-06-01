<?php
echo '<div class="zhongjiang">
	<div class="zj-title">
		<div class="jiang current">
			<select class="lb_color img01" name="winner">
				<option value="/index.php/index/winner/';echo $this->type;echo '">当期大奖</option>
				<option value="/index.php/index/winner/';echo $this->type;echo '/1">今日大奖</option>
			</select>
		</div>
		<div class="jiang">
			<select class="lb_color img01" name="count">
				<option value="/index.php/index/acount/';echo $this->type;echo '">今日累计</option>
				<option value="/index.php/index/acount/';echo $this->type;echo '/1">本周累计</option>
			</select>
		</div>

	</div>
	<div class="zj-cont">
		<table>
			<tbody>
				';
$this->display('index/winner-list.php');
;echo '			</tbody>
		</table>
	</div>
</div>';
?>