<?php

$para=$_GET;
if($para['fromTime'] &&$para['toTime']){
$fromTime=strtotime($para['fromTime']);
$toTime=strtotime($para['toTime'])+24*3600;
$betTimeWhere="and actionTime between $fromTime and $toTime";
$cashTimeWhere="and c.actionTime between $fromTime and $toTime";
$rechargeTimeWhere="and r.actionTime between $fromTime and $toTime";
$fanDiaTimeWhere="and actionTime between $fromTime and $toTime";
$fanDiaTimeWhere2="and l.actionTime between $fromTime and $toTime";
$brokerageTimeWhere=$fanDiaTimeWhere2;
}elseif($para['fromTime']){
$fromTime=strtotime($para['fromTime']);
$betTimeWhere="and b.actionTime >=$fromTime";
$cashTimeWhere="and c.actionTime >=$fromTime";
$rechargeTimeWhere="and r.actionTime >=$fromTime";
$fanDiaTimeWhere="and actionTime >= $fromTime";
$fanDiaTimeWhere2="and l.actionTime >= $fromTime";
$brokerageTimeWhere=$fanDiaTimeWhere2;
}elseif($para['toTime']){
$toTime=strtotime($para['toTime'])+24*3600;
$betTimeWhere="and b.actionTime < $toTime";
$cashTimeWhere="and c.actionTime < $toTime";
$rechargeTimeWhere="and r.actionTime < $toTime";
$fanDiaTimeWhere="and actionTime < $toTime";
$fanDiaTimeWhere2="and l.actionTime < $toTime";
$brokerageTimeWhere=$fanDiaTimeWhere2;
}else{
$toTime=strtotime('00:00');
$betTimeWhere="and b.actionTime > $toTime";
$cashTimeWhere="and c.actionTime > $toTime";
$rechargeTimeWhere="and r.actionTime > $toTime";
$fanDiaTimeWhere="and actionTime > $toTime";
$fanDiaTimeWhere2="and l.actionTime > $toTime";
$brokerageTimeWhere=$fanDiaTimeWhere2;
}
$amountTitle='全部总结';
if($para['parentId']=intval($para['parentId'])){
$userWhere="and u.parentId={$para['parentId']}";
$parentIdWhere="and u.parentId={$para['parentId']}";
$uid=$para['parentId'];
$userWhere3="and concat(',', u.parents, ',') like '%,$uid,%'";
$amountTitle='团队统计';
}
if($para['uid']){
$uParentId=$this->getValue("select parentId from {$this->prename}members where uid=?",$para['uid']);
$userWhere="and u.uid=$uParentId";
$uid=$uParentId;
$userWhere3="and concat(',', u.parents, ',') like '%,$uid,%'";
$amountTitle='团队统计';
}
if($para['username'] &&$para['username']!='用户名'){
$userWhere="and u.username='{$para['username']}'";
$uid=$this->getValue("select uid from {$this->prename}members where username='{$para['username']}'");
$userWhere3="and concat(',', u.parents, ',') like '%,$uid,%'";
$amountTitle='团队统计';
}
$sql="select u.username, u.coin, u.uid, u.parentId, sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount, (select sum(c.amount) from ssc_member_cash c where c.`uid`=u.`uid` and c.state=0 $cashTimeWhere) cashAmount,(select sum(r.amount) from ssc_member_recharge r where r.`uid`=u.`uid` and r.state in(1,2,9) $rechargeTimeWhere) rechargeAmount, (select sum(l.coin) from ssc_coin_log l where l.`uid`=u.`uid` and l.liqType in(50,51,52,53) $brokerageTimeWhere) brokerageAmount from ssc_members u left join ssc_bets b on u.uid=b.uid and b.isDelete=0 $betTimeWhere where 1 $userWhere";
$this->pageSize-=1;
if($this->action!='betDate') $this->action='betDate';
$list=$this->getPage($sql .' group by u.uid',$this->page,$this->pageSize);
if(!$list['total']) {
$uParentId2=$this->getValue("select parentId from {$this->prename}members where uid=?",$para['parentId']);
$list=array(
'total'=>1,
'data'=>array(array(
'parentId'=>$uParentId2,
'uid'=>$para['parentId'],
'username'=>'没有下级了'
))
);
$noChildren=true;
}
$params=http_build_query($_REQUEST,'','&');
$count=array();
$sql="select sum(coin) from {$this->prename}coin_log where uid=? and liqType between 2 and 3 $fanDiaTimeWhere";
$sql2="select sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount from ssc_members u left join ssc_bets b on u.uid=b.uid and b.isDelete=0 $betTimeWhere $userWhere3";
$all=$this->getRow($sql2);
$all['fanDianAmount']=$this->getValue("select sum(l.coin) from {$this->prename}coin_log l, {$this->prename}members u where l.liqType between 2 and 3 and l.uid=u.uid $fanDiaTimeWhere2 $userWhere3",$var['uid']);
$all['brokerageAmount']=$this->getValue("select sum(l.coin) from {$this->prename}coin_log l, {$this->prename}members u where l.liqType in(50,51,52,53) and l.uid=u.uid $brokerageTimeWhere $userWhere3",$var['uid']);
$all['rechargeAmount']=$this->getValue("select sum(r.amount) from {$this->prename}member_recharge r, {$this->prename}members u where r.state in (1,2,9) and r.uid=u.uid $rechargeTimeWhere $userWhere3",$var['uid']);
$all['cashAmount']=$this->getValue("select sum(c.amount) from {$this->prename}member_cash c, {$this->prename}members u  where c.state=0 and c.uid=u.uid $cashTimeWhere $userWhere3",$var['uid']);
$all['coin']=$this->getValue("select sum(u.coin) coin from {$this->prename}members u where 1 $userWhere3",$var['uid']);
;echo '
<table class="tablesorter" cellspacing="0">
	<thead>
		<tr>
			<td>用户名</td>
			<td>投注总额</td>
			<td>中奖总额</td>
			<td>总返点</td>
			<td title="包括充值佣金，注册佣金，消费佣金，签到">佣金</td>
			<td>充值</td>
			<td>提现</td>
			<td>余额</td>
			<td>盈亏</td>
			<td>团队盈亏</td>
			<td>查看下级</td>
		</tr>
	</thead>
	<tbody>
	';
if($list['data']) foreach($list['data'] as $var){
if($var['username']!='没有下级了'){
$var['fanDianAmount']=$this->getValue($sql,$var['uid']);
$pId=$var['uid'];
$var['teamwin']=$this->getValue("select sum(l.coin) fandianAll from {$this->prename}coin_log l, ssc_members u where l.liqType in(2,3) and l.uid=u.uid and concat(',', u.parents, ',') like '%,$pId,%' $fanDiaTimeWhere") +$this->getValue("select sum(b.bonus-b.mode * b.beiShu * b.actionNum) betZjAmount from ssc_members u ,ssc_bets b where u.uid=b.uid and b.isDelete=0 and concat(',', u.parents, ',') like '%,$pId,%' $betTimeWhere");
}
$count['betAmount']+=$var['betAmount'];
$count['zjAmount']+=$var['zjAmount'];
$count['fanDianAmount']+=$var['fanDianAmount'];
$count['brokerageAmount']+=$var['brokerageAmount'];
$count['cashAmount']+=$var['cashAmount'];
$count['coin']+=$var['coin'];
$count['rechargeAmount']+=$var['rechargeAmount'];
$count['teamwin']+=$var['teamwin'];
;echo '		<tr>
			<td>';echo $this->ifs($var['username'],'--');echo '</td>
			<td>';echo $this->ifs($var['betAmount'],'--');echo '</td>
			<td>';echo $this->ifs($var['zjAmount'],'--');echo '</td>
			<td>';echo $this->ifs($var['fanDianAmount'],'--');echo '</td>
			<td>';echo $this->ifs($var['brokerageAmount'],'--');echo '</td>
			<td>';echo $this->ifs($var['rechargeAmount'],'--');echo '</td>
			<td>';echo $this->ifs($var['cashAmount'],'--');echo '</td>
			<td>';echo $this->ifs($var['coin'],'--');echo '</td>
			<td>';echo $this->ifs($var['zjAmount']-$var['betAmount']+$var['fanDianAmount'],'--');echo '</td>
			<td>';echo $this->ifs($var['teamwin'],'--');echo '</td>
			<td>
                ';if(!$noChildren){;echo '                <a target="ajax" dataType="html" call="defaultList" href="';echo "/admin.php/countData/betDateSearch/?parentId={$var['uid']}&fromTime={$para['fromTime']}&toTime={$para['toTime']}";echo '">下级</a>
				';};echo '                ';if($var['parentId']){;echo '                  <a target="ajax" dataType="html" call="defaultList" href="';echo "/admin.php/countData/betDateSearch/?uid={$var['uid']} &fromTime={$para['fromTime']}&toTime={$para['toTime']}";echo '">上级</a>
				';};echo '            </td>
		</tr>
	';};echo '		<tr>
			<td><span class="spn9">本页总结</span></td>
			<td>';echo $this->ifs($count['betAmount'],'--');echo '</td>
			<td>';echo $this->ifs($count['zjAmount'],'--');echo '</td>
			<td>';echo $this->ifs($count['fanDianAmount'],'--');echo '</td>
            <td>';echo $this->ifs($count['brokerageAmount'],'--');echo '</td>
			<td>';echo $this->ifs($count['rechargeAmount'],'--');echo '</td>
			<td>';echo $this->ifs($count['cashAmount'],'--');echo '</td>
			<td>';echo $this->ifs($count['coin'],'--');echo '</td>
			<td>';echo $this->ifs($count['zjAmount']-$count['betAmount']+$count['fanDianAmount'],'--');echo '</td>
			<td>';echo $this->ifs($count['teamwin'],'--');echo '</td>
			<td></td>
		</tr>
		<tr>
			<td><span class="spn9">';echo $amountTitle;echo '</span></td>
			<td>';echo $this->ifs($all['betAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['zjAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['fanDianAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['brokerageAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['rechargeAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['cashAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['coin'],'--');echo '</td>
			<td>';echo $this->ifs($all['zjAmount']-$all['betAmount']+$all['fanDianAmount']+$all['brokerageAmount'],'--');echo '</td>
			<td>--</td>
			<td></td>
		</tr>
	</tbody>
</table>
<footer>
	';
$rel=get_class($this).'/betDate-{page}?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$list['total'],$rel,'defaultReplacePageAction');
;echo '</footer>'
?>