<?php
echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
';
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
}
$uid=$this->user['uid'];
if($para['parentId']=intval($para['parentId'])){
$userWhere="and u.parentId={$para['parentId']}";
$uid=$para['parentId'];
}elseif($para['uid']){
$uParentId=$this->getValue("select parentId from {$this->prename}members where uid=?",$para['uid']);
$userWhere="and u.uid=$uParentId";
$uid=$uParentId;
}elseif($para['username'] &&$para['username']!='用户名'){
$uid=$this->getValue("select uid from {$this->prename}members where username=? and concat(',',parents,',') like '%,{$this->user['uid']},%'",$para['username']);
$userWhere="and u.username='{$para['username']}' and concat(',', u.parents, ',') like '%,{$this->user['uid']},%'";
}else{
$userWhere="and u.uid=$uid";
}
$userWhere3="and concat(',', u.parents, ',') like '%,$uid,%'";
if($para['userType']){
switch(intval($para['userType'])){
case 1:
$userWhere="and u.uid=$uid and concat(',', u.parents, ',') like '%,{$this->user['uid']},%'";
break;
case 2:
$userWhere="and u.parentId=$uid";
break;
case 3:
$userWhere="and concat(',', u.parents, ',') like '%,$uid,%'";
break;
}
}
$sql="select u.username, u.coin, u.uid, u.parentId, sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount, (select sum(c.amount) from ssc_member_cash c where c.`uid`=u.`uid` and c.state=0 $cashTimeWhere) cashAmount,(select sum(r.amount) from ssc_member_recharge r where r.`uid`=u.`uid` and r.state in(1,2,9) and r.actionUid=0 $rechargeTimeWhere) rechargeAmount, (select sum(l.coin) from ssc_coin_log l where l.`uid`=u.`uid` and l.liqType in(50,51,52,53) $brokerageTimeWhere) brokerageAmount from ssc_members u left join ssc_bets b on u.uid=b.uid and b.isDelete=0 $betTimeWhere where 1 $userWhere";
$this->pageSize-=1;
if($this->action!='countSearch') $this->action='countSearch';
$list=$this->getPage($sql .' group by u.uid',$this->page,$this->pageSize);
if(!$list['total']) {
$uParentId2=$this->getValue("select parentId from {$this->prename}members where uid=?",$para['parentId']);
$list=array(
'total'=>1,
'data'=>array(array(
'parentId'=>$uParentId2,
'uid'=>$para['parentId'],
'username'=>'没有用户'
))
);
$noChildren=true;
}$params=http_build_query($_REQUEST,'','&');
$count=array();
$sql="select sum(coin) from {$this->prename}coin_log where uid=? and liqType in(2,3) $fanDiaTimeWhere";
$rel="/index.php/{$this->controller}/{$this->action}";
;echo '<div>
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_1">
	<thead class="tr-top">
		<tr>
			<th>用户名</th>
			<th>投注总额</th>
			<th>中奖总额</th>
			<th>总返点</th>
			<th>佣金</th>
			<th>充值</th>
			<th>提现</th>
			<th>余额</th>
			<th>盈亏</th>
			<th>查看</th>
		</tr>
	</thead>
	<tbody class="tr-cont">
	';
if($list['data']) foreach($list['data'] as $var){
if($var['username']!='没有用户'){
$var['fanDianAmount']=$this->getValue($sql,$var['uid']);
$pId=$var['uid'];
}
$count['betAmount']+=$var['betAmount'];
$count['zjAmount']+=$var['zjAmount'];
$count['fanDianAmount']+=$var['fanDianAmount'];
$count['brokerageAmount']+=$var['brokerageAmount'];
$count['cashAmount']+=$var['cashAmount'];
$count['coin']+=$var['coin'];
$count['rechargeAmount']+=$var['rechargeAmount'];
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
      <td>
        ';if(!$noChildren){;echo '        	<a target="ajax" dataType="html" call="searchData" class="qzbtn" href="';echo "{$rel}/?parentId={$var['uid']}&fromTime={$para['fromTime']}&toTime={$para['toTime']}";echo '">下级</a>
				';};echo '        ';if($var['uid']!=$this->user['uid']&&$var['parentId']){;echo '        	<a target="ajax" dataType="html" call="searchData" class="qzbtn" href="';echo "{$rel}/?uid={$var['uid']} &fromTime={$para['fromTime']}&toTime={$para['toTime']}";echo '">上级</a>
				';};echo '       </td>
		</tr>
	';};echo '		
        
        ';if(intval($para['userType'])==1 ||(intval($para['userType'])==0 &&!$para['parentId']) ||($para['username'] &&$para['username']!='用户名')){
$sql2="select sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount from ssc_members u left join ssc_bets b on u.uid=b.uid and b.isDelete=0 $betTimeWhere $userWhere3";
$all=$this->getRow($sql2);
$all['fanDianAmount']=$this->getValue("select sum(l.coin) from {$this->prename}coin_log l, {$this->prename}members u where l.liqType between 2 and 3 and l.uid=u.uid $fanDiaTimeWhere2 $userWhere3",$var['uid']);
$all['brokerageAmount']=$this->getValue("select sum(l.coin) from {$this->prename}coin_log l, {$this->prename}members u where l.liqType in(50,51,52,53) and l.uid=u.uid $brokerageTimeWhere $userWhere3",$var['uid']);
$all['rechargeAmount']=$this->getValue("select sum(r.amount) from {$this->prename}member_recharge r, {$this->prename}members u where r.state in (1,2,9) and r.uid=u.uid and r.actionUid=0 $rechargeTimeWhere $userWhere3",$var['uid']);
$all['cashAmount']=$this->getValue("select sum(c.amount) from {$this->prename}member_cash c, {$this->prename}members u  where c.state=0 and c.uid=u.uid $cashTimeWhere $userWhere3",$var['uid']);
$all['coin']=$this->getValue("select sum(u.coin) coin from {$this->prename}members u where 1 $userWhere3",$var['uid']);
;echo '		<tr>
			<td><span class="spn9">团队总结</span></td>
			<td>';echo $this->ifs($all['betAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['zjAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['fanDianAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['brokerageAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['rechargeAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['cashAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['coin'],'--');echo '</td>
			<td>';echo $this->ifs($all['zjAmount']-$all['betAmount']+$all['fanDianAmount'],'--');echo '</td>
			<td></td>
		</tr>
		';}else{
$sql2="select sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount from ssc_members u left join ssc_bets b on u.uid=b.uid and b.isDelete=0 $betTimeWhere $userWhere";
$all=$this->getRow($sql2);
$all['fanDianAmount']=$this->getValue("select sum(l.coin) from {$this->prename}coin_log l, {$this->prename}members u where l.liqType between 2 and 3 and l.uid=u.uid $fanDiaTimeWhere2 $userWhere",$var['uid']);
$all['brokerageAmount']=$this->getValue("select sum(l.coin) from {$this->prename}coin_log l, {$this->prename}members u where l.liqType in(50,51,52,53) and l.uid=u.uid $brokerageTimeWhere $userWhere",$var['uid']);
$all['rechargeAmount']=$this->getValue("select sum(r.amount) from {$this->prename}member_recharge r, {$this->prename}members u where r.state in (1,2,9) and r.uid=u.uid and r.actionUid=0 $rechargeTimeWhere $userWhere",$var['uid']);
$all['cashAmount']=$this->getValue("select sum(c.amount) from {$this->prename}member_cash c, {$this->prename}members u  where c.state=0 and c.uid=u.uid $cashTimeWhere $userWhere",$var['uid']);
$all['coin']=$this->getValue("select sum(u.coin) coin from {$this->prename}members u where 1 $userWhere",$var['uid']);
;echo '        <tr>
			<td><span class="spn9">本页总结</span></td>
			<td>';echo $this->ifs($count['betAmount'],'--');echo '</td>
			<td>';echo $this->ifs($count['zjAmount'],'--');echo '</td>
			<td>';echo $this->ifs($count['fanDianAmount'],'--');echo '</td>
      <td>';echo $this->ifs($count['brokerageAmount'],'--');echo '</td>
			<td>';echo $this->ifs($count['rechargeAmount'],'--');echo '</td>
			<td>';echo $this->ifs($count['cashAmount'],'--');echo '</td>
			<td>';echo $this->ifs($count['coin'],'--');echo '</td>
			<td>';echo $this->ifs($count['zjAmount']-$count['betAmount']+$count['fanDianAmount'],'--');echo '</td>
			<td></td>
		</tr>
		<tr>
			<td><span class="spn9">';if(intval($para['userType'])==2){echo '直接下级';}else if(intval($para['userType'])==3){echo '所有下级';}else{echo '直接下级';};echo '</span></td>
			<td>';echo $this->ifs($all['betAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['zjAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['fanDianAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['brokerageAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['rechargeAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['cashAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['coin'],'--');echo '</td>
			<td>';echo $this->ifs($all['zjAmount']-$all['betAmount']+$all['fanDianAmount'],'--');echo '</td>
			<td></td>
		</tr>
			';if(intval($para['userType'])!=3){
$sql2="select sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount from ssc_members u left join ssc_bets b on u.uid=b.uid and b.isDelete=0 $betTimeWhere $userWhere3";
$all=$this->getRow($sql2);
$all['fanDianAmount']=$this->getValue("select sum(l.coin) from {$this->prename}coin_log l, {$this->prename}members u where l.liqType between 2 and 3 and l.uid=u.uid $fanDiaTimeWhere2 $userWhere3",$var['uid']);
$all['brokerageAmount']=$this->getValue("select sum(l.coin) from {$this->prename}coin_log l, {$this->prename}members u where l.liqType in(50,51,52,53) and l.uid=u.uid $brokerageTimeWhere $userWhere3",$var['uid']);
$all['rechargeAmount']=$this->getValue("select sum(r.amount) from {$this->prename}member_recharge r, {$this->prename}members u where r.state in (1,2,9) and r.uid=u.uid and r.actionUid=0 $rechargeTimeWhere $userWhere3",$var['uid']);
$all['cashAmount']=$this->getValue("select sum(c.amount) from {$this->prename}member_cash c, {$this->prename}members u  where c.state=0 and c.uid=u.uid $cashTimeWhere $userWhere3",$var['uid']);
$all['coin']=$this->getValue("select sum(u.coin) coin from {$this->prename}members u where 1 $userWhere3",$var['uid']);
;echo '		<tr>
			<td><span class="spn9">所有下级</span></td>
			<td>';echo $this->ifs($all['betAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['zjAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['fanDianAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['brokerageAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['rechargeAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['cashAmount'],'--');echo '</td>
			<td>';echo $this->ifs($all['coin'],'--');echo '</td>
			<td>';echo $this->ifs($all['zjAmount']-$all['betAmount']+$all['fanDianAmount'],'--');echo '</td>
			<td></td>
		</tr>
			';};echo '        ';};echo '	</tbody>
</table>
';
$this->display('inc_page.php',0,$list['total'],$this->pageSize,"$rel-{page}?$params");
;echo '</div>'
?>