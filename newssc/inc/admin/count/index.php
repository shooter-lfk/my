<?php
echo '<article class="module width_full">
    ';
$date=strtotime('00:00:00');
$sql="select left(`date`,7) monthName, sum(betAmount) betAmount, sum(betAmount-zjAmount) winAmount from {$this->prename}count group by monthName order by monthName desc limit 5";
$dataMonth=$this->getRows($sql);
$dataMonth=array_reverse($dataMonth);
foreach($dataMonth as $arrId=>$varAmount){
$monthArr[$arrId]=$varAmount['monthName'];
$betAmountArr[$arrId]=intval($varAmount['betAmount']);
$winAmountArr[$arrId]=intval($varAmount['winAmount']);
if($arrId==0){
$onff=false;
$max=$betAmountArr[$arrId];
$min=$winAmountArr[$arrId];
}else{
if($max<$betAmountArr[$arrId]) $max=$betAmountArr[$arrId];
if($min>$winAmountArr[$arrId]) $min=$winAmountArr[$arrId];
}
}
$cha=$max-$min;
$imgY='|'.$min.'元|'.$max.'元';
$imgX="";
$imgBet="";
$imgWin="";
$z0="";
for($i=0;$i<($arrId+1);$i++){
$imgX.='|'.$monthArr[$i];
if($i==0){
$imgBet.='|'.intval(($betAmountArr[$i]-$min)/$cha*100);
$imgWin.='|'.intval(($winAmountArr[$i]-$min)/$cha*100);
$z0=intval((0-$min)/$cha*100);
}else{
$imgBet.=','.intval(($betAmountArr[$i]-$min)/$cha*100);
$imgWin.=','.intval(($winAmountArr[$i]-$min)/$cha*100);
if($min<0){
$z0.=','.intval((0-$min)/$cha*100);
}
}
}
$imgSrc='http://chart.apis.google.com/chart?chxl=0:'.$imgX.'|1:'.$imgY.'&chxt=x,y&chs=400x140&cht=lc&chd=t:'.$z0.$imgWin.$imgBet.'&chls=1|2|2&chma=10,10,10,10&chdl=0点线|盈亏|投注额&chco=FF0000,76A4FB,80C65A';
;echo '    <header><h3 class="tabs_involved">盈亏统计</h3></header>
	<article class="stats_graph" style="margin:10px;">
		<img src="';echo $imgSrc;echo '" width="400" height="140" alt="" />
	</article>
	<article style="margin:10px; width:20%; float:left;">
        <table align="center" style="text-align:center">
        	<thead>
            <tr>
            	<td height="24">月份</td><td>投注金额</td><td>盈亏</td>
            </tr>
            </thead>
            <tbody>
			';for($i=0;$i<($arrId+1);$i++){;echo '            <tr>
            	<td height="24">';echo $monthArr[$i];echo '</td><td>';echo intval($betAmountArr[$i]);echo '</td><td>';echo intval($winAmountArr[$i]);echo '</td>
            </tr>
			';};echo '            </tbody>
        </table>
	</article>
	<article class="stats_overview" style="margin:10px;">
		';$data=$this->getDateCount($date);;echo '		<div class="overview_today">
			<p class="overview_day">今日统计</p>
			<p class="overview_count">';echo number_format($data['betAmount']-$data['zjAmount']-$data['fanDianAmount']-$data['brokerageAmount'],0);echo '</p>
			<p class="overview_type">盈亏</p>
			<p class="overview_count">';echo number_format($data['betAmount'],0);echo '</p>
			<p class="overview_type">投注额</p>
		</div>
		';
$date=strtotime("00:00")-24*3600;
$data=$this->getDateCount($date);
;echo '		<div class="overview_previous">
			<p class="overview_day">昨日统计</p>
			<p class="overview_count">';echo number_format($data['betAmount']-$data['zjAmount']-$data['fanDianAmount']-$data['brokerageAmount'],0);echo '</p>
			<p class="overview_type">盈亏</p>
			<p class="overview_count">';echo number_format($data['betAmount'],0);echo '</p>
			<p class="overview_type">投注额</p>
		</div>
	</article>
	<div class="clear"></div>
</article>

<article class="module width_full">
    <header><h3 class="tabs_involved">彩种投注金额统计<span class="spn1">（彩种名称：投注金额）</span></h3></header>
    <div class="module_content">
	';
$sql="select type, sum(beiShu*mode*actionNum) amount from {$this->prename}bets where lotteryNo!='' group by type";
$data=$this->getObject($sql,'type');
$this->getTypes();
if($this->types) foreach($this->types as $var){
if($var['isDelete']==0 &&$var['enable']==1){
;echo '        <div class="cztz"><span class="title">';echo $var['title'];echo '</span><span class="spn2">￥';echo number_format($this->ifs($data[$var['id']]['amount'],0),2);echo '</span></div>
	';}};echo '    </div>
</article>

<article class="module width_full">
	<header><h3 class="tabs_involved">玩法统计<span class="spn1">（玩法统计：投注金额 / 注数）</span></h3></header>
	<div class="module_content">
	';
$sql="select playedId, sum(beiShu*mode*actionNum) amount,sum(actionNum) actionNumA from {$this->prename}bets where lotteryNo!='' group by playedId";
$data=$this->getObject($sql,'playedId');
$this->getPlayeds();
if($this->playeds) foreach($this->playeds as $var){
;echo '		<div class="cztz"><span class="title">';echo $var['name'];echo '</span><span class="spn2">￥';echo number_format($this->ifs($data[$var['id']]['amount'],0),2);echo ' / ';echo $this->ifs($data[$var['id']]['actionNumA'],0);echo '注</span></div>
	';};echo '	</div>
</article>

';
$date=strtotime(date("Y-m-d",$this->time)." 00:00:00");
$sql="select count(uid) allUser, sum(regTime>=$date) todayReg, sum(type) dlCount, sum(type=0) memberCount, sum(coin+fcoin) amountCount from {$this->prename}members where isDelete=0";
$data=$this->getRow($sql);
;echo '<article class="module width_full">
	<header><h3 class="tabs_involved">用户统计</h3></header>
	<table class="tablesorter" cellspacing="0"> 
	<thead> 
		<tr> 
			<th>用户总数</th> 
			<th>今日注册人数</th> 
			<th>代理人数</th> 
			<th>会员人数</th> 
			<th>当前在线人数</th>
			<th>余额总数</th>
		</tr> 
	</thead> 
	<tbody> 
		<tr> 
			<td>';echo $data['allUser'];echo '</td> 
			<td>';echo $data['todayReg'];echo '</td> 
			<td>';echo $data['dlCount'];echo '</td> 
			<td>';echo $data['memberCount'];echo '</td> 
			<td>';echo $this->getValue("select count(distinct uid) from {$this->prename}member_session where isOnLine=1 and accessTime-{$this->time}>{$GLOBALS['conf']['member']['sessionTime']}");echo '</td> 
			<td>';echo number_format($data['amountCount']);echo '</td> 
		</tr> 
	</tbody> 
	</table>
</article>

<!-- <div class="tip">提示：本页数据被缓存5分钟，你看到的可能是几分钟之前的数据！</div> -->
';
?>