<?php
	if(!$args[0]) $args[0]=1;
$chiTypes=array(
1=>'时时彩',
2=>'11选5',
3=>'3D/P3/时时乐',
4=>'六合彩',
5=>'幸运赛车',
6=>'PK10',
7=>'泳坛夺金',
8=>'快乐十分'
);
$groups=$this->getRows("select * from {$this->prename}played_group where type=?",$args[0]);
$sql="select * from {$this->prename}played where groupId=?";
;echo '<article class="module width_full">
	<header>
		<h3 class="tabs_involved">玩法设置
			<ul class="tabs" style="margin-right:25px;">
			';foreach($chiTypes as $key=>$var){;echo '				<li ';echo $this->iff($args[0]==$key,'class="active"');echo '><a href="system/played/';echo $key;echo '">';echo $var;echo '</a></li>
			';};echo '			</ul>
		</h3>
	</header>
	';if($groups) foreach($groups as $group){;echo '	<table class="tablesorter" cellspacing="0">
		<thead>
			<tr>
				<th colspan="5" style="text-align:left;">
					<span style="float:right; margin-right:20px"><a href="/admin.php/system/switchPlayedGroupStatus/';echo $group['id'];echo '" target="ajax" call="reloadPlayed">';echo $this->iff($group['enable'],'关闭','开启');echo '</a></span>
					';echo $group['groupName'];echo '&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="spn1">[状态：<span class="state1">';echo $this->iff($group['enable'],'开启','关闭');echo '</span>]</span>
				</th>
			</tr>
		</thead>
		<tbody>
		';if($playeds=$this->getRows($sql,$group['id'])) foreach($playeds as $played){;echo '			<tr>
				<td width="15%">';echo $played['name'];echo '</td>
				<td width="25%">最高奖金：<input type="text" name="bonusProp" value="';echo $played['bonusProp'];echo '"></td>
				<td width="25%">最低奖金：<input type="text" name="bonusPropBase" value="';echo $played['bonusPropBase'];echo '"></td>
				<td width="15%"><span class="state2">';echo $this->iff($played['enable'],'开启','关闭');echo '</span></td>
				<td><a href="/admin.php/system/switchPlayedStatus/';echo $played['id'];echo '" target="ajax" call="reloadPlayed">';echo $this->iff($played['enable'],'关闭','开启');echo '</a> | <a href="/admin.php/system/updatePlayed/';echo $played['id'];echo '" target="ajax" method="post" onajax="sysBeforeUpdatePlayed" call="reloadPlayed">保存修改</a></td>
			</tr>
		';}else{;echo '			<tr>
				<td colspan="5">暂时没有玩法</td>
			</tr>
		';};echo '		</tbody>
	</table>
	';}else{;echo '		暂时没有玩法
	';};echo '</article>';
?>