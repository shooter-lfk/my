<?php

$data=$this->getRows("select * from {$this->prename}type where isDelete=0 order by sort");
;echo '<article class="module width_full">
	<header><h3 class="tabs_involved">彩种设置</h3></header>
	<table class="tablesorter" cellspacing="0" width="100%">
		<thead>
			<tr>
				<td>彩种名称</td>
				<td>彩种简称</td>
				<td title="开奖前关闭投注间隔时间，以秒为单位">停止投注间隔</td>
				<td>开启/关闭</td>
				<td>排序</td>
				<td>操作</td>
			</tr>
		</thead>
		<tbody>
		';if($data) foreach($data as $var){;echo '			<tr>
				<td><input name="title" value="';echo $var['title'];echo '"/></td>
				<td><input name="shortName" value="';echo $var['shortName'];echo '"/></td>
				<td><input type="text" name="data_ftime"  class="textWid1" placeholder="秒" value="';echo $var['data_ftime'];echo '"/></td>
				<td><input type="checkbox" name="enable" value="1" ';echo $this->iff($var['enable'],'checked');echo '/></td>
				<td><input type="text" name="sort"  class="textWid1" value="';echo $var['sort'];echo '"/></td>
				<td><a href="/admin.php/system/updateType/';echo $var['id'];echo '" target="ajax" method="POST" onajax="sysBeforeUpdateType" call="sysUpdateType">保存修改</a></td>
			</tr>
		';};echo '		</tbody>
	</table>
</article>';
?>