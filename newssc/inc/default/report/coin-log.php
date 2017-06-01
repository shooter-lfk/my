<?php
echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
';
$this->getTypes();
$this->getPlayeds();
if($_REQUEST['fromTime'] &&$_REQUEST['toTime']){
$timeWhere=' and l.actionTime between '.strtotime($_REQUEST['fromTime']).' and '.strtotime($_REQUEST['toTime']);
}elseif($_REQUEST['fromTime']){
$timeWhere=' and l.actionTime >='.strtotime($_REQUEST['fromTime']);
}elseif($_REQUEST['toTime']){
$timeWhere=' and l.actionTime =<'.strtotime($_REQUEST['toTime']);
}else{
$timeWhere=' and l.actionTime>='.strtotime('00:00');
}
if($_REQUEST['liqType']){
$liqTypeWhere=' and liqType='.$_REQUEST['liqType'];
if($_REQUEST['liqType']==2) $liqTypeWhere=' and liqType between 2 and 3';
}
if($_REQUEST['username'] &&$_REQUEST['username']!='用户名'){
$userWhere=" and u.parents like '%,{$this->user['uid']},%' and u.username like '%{$_REQUEST['username']}%'";
}elseif($_REQUEST['userType']){
unset($_REQUEST['username']);
switch($_REQUEST['userType']){
case 1:
$userWhere=" and u.uid={$this->user['uid']}";
break;
case 2:
$userWhere=" and u.parentId={$this->user['uid']}";
break;
case 3:
$userWhere=" and u.parents like '%,{$this->user['uid']},%' and u.uid!={$this->user['uid']}";
break;
}
}else{
$userWhere=" and u.parents like '%,{$this->user['uid']},%' and u.uid!={$this->user['uid']}";
}
if($this->type){
$typeWhere=" and b.type={$this->type}";
}
if($this->action=='fcoinModal'){
$fcoinModalWhere='and l.fcoin!=0';
}
$sql="select b.type, b.playedId, b.actionNo, b.mode, l.liqType, l.coin, l.fcoin, l.userCoin, l.actionTime, l.extfield0, l.extfield1, l.info, u.username from {$this->prename}members u, {$this->prename}coin_log l left join {$this->prename}bets b on b.id=extfield0 where l.uid=u.uid $liqTypeWhere $timeWhere $userWhere $typeWhere $fcoinModalWhere and l.liqType not in(4,11,104) order by l.id desc";
$list=$this->getPage($sql,$this->page,$this->pageSize);
$params=http_build_query($_REQUEST,'','&');
$modeName=array('2.00'=>'元','0.20'=>'角','0.02'=>'分');
$liqTypeName=array(
1=>'充值',
2=>'返点',
5=>'停止追号',
6=>'中奖金额',
7=>'撤单',
8=>'提现失败返回冻结金额',
9=>'上级充值',
10=>'解除抢庄冻结金额',
50=>'签到赠送',
51=>'首次绑定工行卡赠送',
52=>'充值佣金',
53=>'消费佣金',
100=>'抢庄冻结金额',
101=>'投注冻结金额',
102=>'追号投注',
103=>'抢庄返点金额',
105=>'抢庄赔付金额',
106=>'提现冻结',
107=>'提现成功扣除冻结金额',
108=>'开奖扣除冻结金额'
);
;echo '<div>
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_1">
	<thead class="tr-top">
		<tr>
			<th>时间</th>
			<th>用户名</th>
			<th>帐变类型</th>
			<th>单号</th>
			<th>游戏玩法</th>
			<th>期号</th>
			<!--th>模式</th-->
			<th>金额</th>
			<th>余额</th>
		</tr>
	</thead>
	<tbody class="tr-cont">
		';if($list['data']) foreach($list['data'] as $var){;echo '		<tr>
			<td>';echo substr(date('Y-m-d H:i:s',$var['actionTime']),2);echo '</td>
			<td>';echo $var['username'];echo '</td>
			<td title="';echo $var['info'];echo '">';echo $liqTypeName[$var['liqType']];echo '</td>
			
			';if($var['extfield0'] &&in_array($var['liqType'],array(2,3,4,5,6,7,10,11,100,101,102,103,104,105,108))){;echo '				<td><a onClick="art.dialog.open(\'/index.php/record/betInfo2/';echo $var['extfield0'];echo '\', {id: \'testID2\',lock: true,title: \'投注信息\',width:510, height:360});">…';echo $var['extfield0'];echo '</a></td>
				<td>';echo $this->types[$var['type']]['shortName'];echo '';echo $this->playeds[$var['playedId']]['name'];echo '</td>
				<td>';echo $var['actionNo'];echo '</td>
				<!--td>';echo $modeName[$var['mode']];echo '</td-->
			';}elseif(in_array($var['liqType'],array(1,9,52))){;echo '				<td><a onClick="art.dialog.open(\'/index.php/cash/rechargeModal/';echo $var['extfield0'];echo '\', {id: \'testID2\',lock: true,title: \'充值信息\',width:510, height:360});">';echo $var['extfield1'];echo '</a></td>
				<td>--</td>
				<td>--</td>
			';}elseif(in_array($var['liqType'],array(8,106,107))){;echo '				<td><a onClick="art.dialog.open(\'/index.php/cash/cashModal/';echo $var['extfield0'];echo '\', {id: \'testID2\',lock: true,title: \'提现信息\',width:510, height:360});">…';echo $var['extfield0'];echo '</a></td>
				<td>--</td>
				<td>--</td>
      ';}else{;echo '				<td>--</td>
				<td>--</td>
				<td>--</td>
      ';};echo '            
      <td>';echo $var['coin'];echo '</td>
			<td>';echo $var['userCoin'];echo '</td>
		</tr>
		';};echo '	</tbody>
</table>
';
$this->display('inc_page.php',0,$list['total'],$this->pageSize,"/index.php/{$this->controller}/{$this->action}-{page}/{$this->type}?$params");
;echo '</div>'
?>