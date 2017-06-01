<?php

$this->getTypes();
$this->getPlayeds();
if($_REQUEST['username']){
$userWhere="and b.qz_username like '%{$_REQUEST['username']}%'";
}
if($_REQUEST['type']){
$typeWhere="and b.type={$_REQUEST['type']}";
}
if($_REQUEST['betType']!=''){
$betTypeWhere=" and b.betType={$_REQUEST['betType']}";
}
if($_REQUEST['fromTime'] &&$_REQUEST['toTime']){
$fromTime=strtotime($_REQUEST['fromTime']);
$toTime=strtotime($_REQUEST['toTime'])+24*3600;
$timeWhere="and b.qz_time between $fromTime and $toTime";
}elseif($_REQUEST['fromTime']){
$fromTime=strtotime($_REQUEST['fromTime']);
$timeWhere="and b.qz_time>=$fromTime";
}elseif($_REQUEST['toTime']){
$toTime=strtotime($_REQUEST['toTime'])+24*3600;
$timeWhere="and b.qz_time<$fromTime";
}else{
$timeWhere=' and b.actionTime>'.strtotime('00:00');;
}
$sql="select * from {$this->prename}bets b where qz_uid>0 $timeWhere $typeWhere $userWhere order by b.id desc";
$data=$this->getPage($sql,$this->page,$this->pageSize);
$mname=array(
'2.00'=>'元',
'0.20'=>'角',
'0.02'=>'分'
);
;echo '<article class="module width_full">
	<header>
		<h3 class="tabs_involved">普通投注
			<form class="submit_link wz" action="/admin.php/business/betLog" target="ajax" call="defaultSearch" dataType="html">
				会员<input type="text" class="alt_btn" name="username" style="width:70px;"/>&nbsp;&nbsp;
				时间从 <input type="date" class="alt_btn" name="fromTime"/> 到 <input type="date" name="toTime" class="alt_btn"/>&nbsp;&nbsp;
				<select style="width:90px;" name="type">
					<option value="">全部彩种</option>
				';if($this->types) foreach($this->types as $var){
if($var['enable'] &&!$var['isDelete']){
;echo '					<option value="';echo $var['id'];echo '" title="';echo $var['title'];echo '">';echo $this->ifs($var['shortName'],$var['title']);echo '</option>
				';}};echo '				</select>&nbsp;&nbsp;
                <select style="width:74px;" name="betType">
					<option value="">全部来源</option>
					<option value="0" title="web">web</option>
					<option value="1" title="web">手机</option>
				</select>&nbsp;&nbsp;
				<input type="submit" value="查找" class="alt_btn">
				<input type="reset" value="重置条件">
			</form>
		</h3>
	</header>
	<table class="tablesorter" cellspacing="0">
		<thead>
			<tr>
				<th>单号</th>
				<th>用户名</th>
				<th>投注时间</th>
				<th>彩种</th>
				<th>玩法</th>
				<th>期号</th>
				<th>倍数</th>
				<th>模式</th>
				<th>投注号码</th>
				<th>投注金额</th>
				<th>中奖金额</th>
				<th>返点</th>
				<th>抽水</th>
				<th>来源</th>
			</tr>
		</thead>
		<tbody>
		';if($data['data']) foreach($data['data'] as $var){;echo '			<tr>
				<td>';echo $var['id'];echo '</td>
				<td>';echo $var['qz_username'];echo '</td>
				<td>';echo date('m-d H:i',$var['qz_time']);echo '</td>
				<td>';echo $this->ifs($this->types[$var['type']]['shortName'],$this->types[$var['type']]['title']);echo '</td>
				<td>';echo $this->playeds[$var['playedId']]['name'];echo '</td>
				<td>';echo $var['actionNo'];echo '</td>
				<td>';echo $var['beiShu'];echo '</td>
				<td>';echo $mname[$var['mode']];echo '</td>
				<td data-code="';echo $var['actionData'];echo '">';echo $this->CsubStr($var['actionData'],0,10);echo '</td>
				<td>';echo $var['fcoin'];echo '</td>
				<td>';echo $this->iff($var['lotteryNo'],number_format($var['fcoin']-$var['qz_fanDian'] -$var['qz_chouShui'] -$var['fanDianAmount'] -$var['zjCount'] * $var['bonusProp'] * $var['beiShu'] * $var['mode']/2,2),'未开奖');echo '</td>
				<td>';echo $var['qz_fanDian'];echo '</td>
				<td>';echo $var['qz_chouShui'];echo '</td>
				<td>';if($var['betType']==0){echo 'web';}else if($var['betType']==1){echo '手机';}else if($var['betType']==2){echo 'PC';};echo '</td>
			</tr>
		';}else{;echo '			<tr>
				<td colspan="13">暂时没有抢庄记录</td>
			</tr>
		';};echo '		</tbody>
	</table>
	<footer>
	';
$rel=get_class($this).'/znzLog-{page}?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$data['total'],$rel,'betLogSearchPageAction');
;echo '	</footer>
</article>';
?>