<?php
echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
<script type="text/javascript" src="/skin/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="/skin/js/jqueryui/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" src="/skin/js/jqueryui/i18n/jquery.ui.datepicker-zh-CN.js"></script>
<script type="text/javascript" src="/skin/js/artDialog/artDialog.js?skin=aero"></script>
<script type="text/javascript" src="/skin/js/artDialog/plugins/iframeTools.source.js"></script>
';
$para=$_GET;
if($this->type){
$gameTypeWhere="and b.type={$this->type}";
}
if($para['fromTime'] &&$para['toTime']){
$timeWhere='and b.actionTime between '.strtotime($para['fromTime']).' and '.strtotime($para['toTime']);
}elseif($para['fromTime']){
$timeWhere='and b.actionTime>='.strtotime($para['fromTime']);
}elseif($para['toTime']){
$timeWhere='and b.actionTime<'.strtotime($para['toTime']);
}else{
$timeWhere=' and b.actionTime>'.strtotime('00:00');
}
$stateWhere="and b.isDelete=0 ";
switch($para['state']){
case 0:
$stateWhere='';
break;
case 1:
$stateWhere.='and b.zjCount>0';
break;
case 2:
$stateWhere.="and b.zjCount=0 and b.lotteryNo!='' and isDelete=0";
break;
case 3:
$stateWhere.="and b.lotteryNo=''";
break;
case 4:
$stateWhere.='and b.zhuiHao=1';
break;
case 5:
$stateWhere='and b.isDelete=1';
break;
}
if($para['mode']) $modeWhere="and b.mode={$para['mode']}";
if($para['qz']==1){
$qzWhere='and b.qz_uid!=0';
}elseif($para['qz']==2){
$qzWhere='and b.qz_uid=0';
}
if($this->userType=='me'){
if($para['betId'] &&$para['betId']!='输入单号'&&($para['betId']=intval($para['betId']))){
$sql="select b.* from {$this->prename}bets b where b.id={$para['betId']} and (b.uid={$this->user['uid']} or b.qz_uid={$this->user['uid']})";
}else{
$sql="select b.* from {$this->prename}bets b where 1 $timeWhere $gameTypeWhere $stateWhere $modeWhere $qzWhere and (b.uid={$this->user['uid']} or b.qz_uid={$this->user['uid']})";
}
}elseif($this->userType=='zhuih'){
if($para['betId'] &&$para['betId']!='输入单号'&&($para['betId']=intval($para['betId']))){
$sql="select b.* from {$this->prename}bets b where b.uid={$this->user['uid']} and b.id={$para['betId']} and b.zhuiHao=1";
}else{
$sql="select b.* from {$this->prename}bets b where b.uid={$this->user['uid']} and b.zhuiHao=1 $timeWhere $gameTypeWhere $stateWhere $modeWhere $qzWhere";
}
}elseif($this->userType=='team'){
$sql="select b.*, u.username from {$this->prename}bets b, {$this->prename}members u where b.uid=u.uid";
if($para['username'] &&$para['username']!='用户名'){
$sql.=" and u.username like '%{$para['username']}%' and concat(',',u.parents,',') like '%,{$this->user['uid']},%'";
}else{
unset($para['username']);
switch($para['type']){
case 1:
$sql="select b.* from {$this->prename}bets b where b.uid={$this->user['uid']}";
break;
case 2:
$typeWhere=" and u.parentId={$this->user['uid']}";
break;
case 3:
$typeWhere="and concat(',',u.parents,',') like '%,{$this->user['uid']},%' and u.uid!={$this->user['uid']}";
break;
default:
$typeWhere=" and concat(',',u.parents,',') like '%,{$this->user['uid']},%'";
break;
}
}
$sql.=" $timeWhere $gameTypeWhere $stateWhere $modeWhere $qzWhere $typeWhere";
}
$sql.=' order by actionTime desc, id desc';
$data=$this->getPage($sql,$this->page,$this->pageSize);
$params=http_build_query($para,'','&');
$modeName=array('2.00'=>'元','0.20'=>'角','0.02'=>'分');
;echo '<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_1">
	<thead class="tr-top">
		<tr>
			<th>单号</th>
			<th>时间</th>
			<th>发起人</th>
			<th>彩种玩法</th>
			<!--th>模式</td-->
			<th>期号</th>
			<th>开奖号码</th>
			<!--th>抢庄人</th>
			<th>倍数</th-->
			<th>总额</th>
			<th>奖金</th>
			<th>状态</th>
			';if($this->action!='dateModal'){;echo '			<th>操作</th>
			';};echo '		</tr>
	</thead>
	<tbody  class="tr-cont">
	';if($data['data']) foreach($data['data'] as $var){;echo '		<tr>
			<td><a onClick="art.dialog.open(\'/index.php/record/betInfo2/';echo $var['id'];echo '\', {id: \'testID2\',lock: true,title: \'投注信息\',width:510, height:360});">…';echo $var['id'];echo '</a></td>
			<td>';echo date('m-d H:i:s',$var['actionTime']);echo '</td>
			<td>
				';
if($var['username']!=$this->user['username']){
if($var['username']){echo preg_replace('/^(\w).*(\w{2})$/','\1***\2',$var['username']);}else{echo '--';};
}else{
if($var['username']){echo  $var['username'];}else{echo '--';};
}
;echo '            </td>
			<td title="模式：';echo $var['bonusProp'].'/'.$var['fanDian'].'%';echo '">';echo $this->ifs($this->types[$var['type']]['shortName'],$this->types[$var['type']]['title']);echo '';echo $this->playeds[$var['playedId']]['name'];echo '</td>
			<td>';echo $var['actionNo'];echo '</td>
			<td>';echo $this->ifs($var['lotteryNo'],'--');echo '</td>
			<!--td>';
if($var['qz_username']!=$this->user['username']){
if($var['qz_username']){echo preg_replace('/^(\w).*(\w{2})$/','\1***\2',$var['qz_username']);}else{echo '--';};
}else{
if($var['qz_username']){echo '<font color="#ff0000">'.$var['qz_username'].'</font>';}else{echo '--';};
}
;echo '            </td>
			<td>';echo $var['beiShu'];echo '</td>-->
			<td align="right">';echo $var['mode']*$var['beiShu']*$var['actionNum'];echo '</td>
			<td align="right">';echo $this->iff($var['lotteryNo'],number_format($var['bonus'],2),'－');echo '</td>
			<!--<td>';echo $modeName[$var['mode']];echo '</td>-->
			<td>
			';
if($var['isDelete']==1){
echo '<font color="#999999">已撤单</font>';
}elseif(!$var['lotteryNo']){
echo '<font color="#cccccc">未开奖</font>';
}elseif($var['zjCount']){
echo '<font color="red">已中奖</font>';
}else{
echo '<font color="green">未中奖</font>';
}
;echo '			</td>
			';if($this->action!='dateModal'){;echo '			<td>
			';if($var['lotteryNo'] ||$var['isDelete']==1 ||$var['kjTime']<$this->time ||$var['qz_uid']){;echo '				--
			';}else{;echo '				<a target="ajax" call="deleteBet" title="是否确定撤单？" dataType="json" href="/index.php/game/deleteCode/';echo $var['id'];echo '">撤单</a>
			';};echo '			</td>
			';};echo '		</tr>
	';};echo '	</tbody>
</table>
';
$this->display('inc_page.php',0,$data['total'],$this->pageSize,"/index.php/{$this->controller}/{$this->action}-{page}/{$this->userType}/{$this->type }?$params");
?>