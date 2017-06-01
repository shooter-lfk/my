<?php

$this->getTypes();
$this->getPlayeds();
$para=$_GET;
if($para['username']){
$userWhere="and u.username like '%{$para['username']}%'";
}
if($para['liqType']){
$liqTypeWhere="and l.liqType={$para['liqType']}";
if($_REQUEST['liqType']==2) $liqTypeWhere=' and liqType=2 or liqType=3';
}
if($_REQUEST['type']){
$typeWhere="and b.type={$_REQUEST['type']}";
}
if($_REQUEST['fromTime'] &&$_REQUEST['toTime']){
$fromTime=strtotime($_REQUEST['fromTime']);
$toTime=strtotime($_REQUEST['toTime'])+24*3600;
$timeWhere="and l.actionTime between $fromTime and $toTime";
}elseif($_REQUEST['fromTime']){
$fromTime=strtotime($_REQUEST['fromTime']);
$timeWhere="and l.actionTime>=$fromTime";
}elseif($_REQUEST['toTime']){
$toTime=strtotime($_REQUEST['toTime'])+24*3600;
$timeWhere="and l.actionTime<$fromTime";
}else{
$timeWhere=' and l.actionTime>'.strtotime('00:00');
}
$sql="select l.*, u.username from {$this->prename}coin_log l, {$this->prename}members u where l.uid=u.uid $timeWhere $liqTypeWhere $typeWhere $userWhere and l.liqType not in(4,11,104) order by l.id desc";
$data=$this->getPage($sql,$this->page,$this->pageSize);
$mname=array(
'2.00'=>'元',
'0.20'=>'角',
'0.02'=>'分'
);
$sql="select mode, playedId, actionNo from {$this->prename}bets where id=?";
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
;echo '<article class="module width_full">
	<header>
		<h3 class="tabs_involved">帐变明细
		<form action="/admin.php/business/coinLog" class="submit_link wz" target="ajax" call="defaultSearch" dataType="html">
			会员：<input type="text" class="alt_btn" name="username" style="width:60px;"/>&nbsp;&nbsp;
			类型：<select style="width:100px" name="liqType">
					<option value="">所有帐变类型</option>
                    <option value="1">充值</option>
                    <option value="2">返点</option><!--3,分红-->
                    <!--<option value="4">抽水金额</option>-->
                    <option value="5">停止追号</option>
                    <option value="6">中奖金额</option>
                    <option value="7">撤单</option>
                    <option value="8">提现失败返回冻结金额</option>
                    <option value="9">上级充值</option>
                    <option value="10">解除抢庄冻结金额</option>
                    <!--<option value="11">收单金额</option>-->
                    <option value="50">签到赠送</option>
                    <option value="51">首次绑定工行卡赠送</option>
                    <option value="52">充值佣金</option>
                    <option value="53">消费佣金</option>
                    <option value="100">抢庄冻结金额</option>
                    <option value="101">投注</option>
                    <option value="102">追号投注</option>
                    <option value="103">抢庄返点金额</option>
                    <!--<option value="104">抢庄抽水金额</option>-->
                    <option value="105">抢庄赔付金额</option>
                    <option value="106">提现冻结</option>
                    <option value="107">提现成功扣除冻结金额</option>
                    <option value="108">开奖扣除冻结金额</option>
				</select>&nbsp;&nbsp;
			时间：从<input type="date" class="alt_btn" name="fromTime"/> 到 <input type="date" class="alt_btn" name="toTime"/>&nbsp;&nbsp;
			<select style="width:90px;" name="type">
				<option value="">全部彩种</option>
			';if($this->types) foreach($this->types as $var){
if($var['enable'] &&!$var['isDelete']){
;echo '				<option value="';echo $var['id'];echo '" title="';echo $var['title'];echo '">';echo $this->ifs($var['shortName'],$var['title']);echo '</option>
			';}};echo '			</select>&nbsp;&nbsp;
			<input type="submit" value="查找" class="alt_btn">
			<input type="reset" value="重置条件">
		</form>
		</h3>
	</header>
	<table class="tablesorter" cellspacing="0">
	<thead>
		<tr>
			<th>时间</th>
			<th>用户名</th>
			<th>帐变类型</th>
			<th>单号</th>
			<th>游戏</th>
			<th>玩法</th>
			<th>期号</th>
			<th>模式</th>
			<th>资金</th>
			<th>余额</th>
			
		</tr>
	</thead>
	<tbody>
	';if($data['data']) foreach($data['data'] as $var){
if($var['extfield0']>0){
$bet=$this->getRow($sql,$var['extfield0']);
}else{
$bet=array();
}
;echo '		<tr>
			<td>';echo date('m-d H:i',$var['actionTime']);echo '</td>
			<td>';echo $var['username'];echo '</td>
			<!--<td>';echo $liqTypeName[$var['liqType']];echo '</td>-->
			<td>';echo $var['info'];echo '</td>
            
            ';if($var['extfield0'] &&in_array($var['liqType'],array(2,3,4,5,6,7,10,11,100,101,102,103,104,105,108))){;echo '                <td><a target="modal" button="关闭:defaultCloseModal" width="510" title="投注信息" href="/admin.php/business/betInfo/';echo $var['extfield0'];echo '">';echo $this->ifs($var['extfield0'],'--');echo '</a>
                </td>
                <td>';echo $this->iff($var['type'],$this->types[$var['type']]['title'],'--');echo '</td>
                <td>';echo $this->iff($bet['playedId'],$this->playeds[$bet['playedId']]['name'],'--');echo '</td>
                <td>';echo $this->ifs($bet['actionNo'],'--');echo '</td>
                <td>';echo $this->iff($bet['mode'],$mname[$bet['mode']],'--');echo '</td>
			';}elseif(in_array($var['liqType'],array(1,9,52))){;echo '                <td><a href="/admin.php/business/rechargeInfo/';echo $var['extfield0'];echo '" width="500" title="充值信息" button="关闭:defaultCloseModal" target="modal">';echo $var['extfield1'];echo '</a></td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
			';}elseif(in_array($var['liqType'],array(8,106,107))){;echo '                <td><a href="/admin.php/business/cashInfo/';echo $var['extfield0'];echo '" width="500" title="提现信息" button="关闭:defaultCloseModal" target="modal">';echo $var['extfield0'];echo '</a></td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                
            ';}else{;echo '                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
            ';};echo '            
			<td>';echo $var['coin'];echo '</td>
			<td>';echo $var['userCoin'];echo '</td>
			
		</tr>
	';}else{;echo '		<tr>
			<td colspan="10">暂时没有帐变记录</td>
		</tr>
	';};echo '	</tbody>
	</table>
	<footer>
	';
$rel=get_class($this).'/coinLog-{page}?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$data['total'],$rel,'betLogSearchPageAction');
;echo '	</footer>
</article>'
?>