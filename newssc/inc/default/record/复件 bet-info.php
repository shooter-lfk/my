<?php
echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
<script type="text/javascript" src="/skin/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="/skin/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/skin/js/Array.ext.js"></script>
<script type="text/javascript" src="/skin/main/onload.js"></script>
<script type="text/javascript" src="/skin/main/function.js?v1.0.7"></script>
<script type="text/javascript" src="/skin/js/artDialog/artDialog.js?skin=aero"></script>
<script type="text/javascript" src="/skin/js/artDialog/plugins/iframeTools.source.js"></script>
';
$bet=$this->getRow("select * from {$this->prename}bets where id=?",$args[0]);
if(!$bet) throw new Exception('单号不存在');
$modeName=array('2.00'=>'元','0.20'=>'角','0.02'=>'分');
$weiShu=$bet['weiShu'];
if($weiShu){
if(game.type==7){
$w=array(8=>'自',4=>'仰',2=>'蛙',1=>'蝶');
}else{
$w=array(16=>'万',8=>'千',4=>'百',2=>'十',1=>'个');
}
foreach($w as $p=>$v){
if($weiShu &$p) $wei.=$v;
}
$wei.=':';
}
$betCont=$bet['mode'] * $bet['beiShu'] * $bet['actionNum'];
;echo '<div class="bet-info popupModal">
	<table border="0" cellpadding="0" cellspacing="1" class="table_1" width="480">
		<tr>
			<td align="right">号码：</td>
			<td colspan="3"><textarea cols="45" rows="5">';echo $wei.$bet['actionData'];echo '</textarea></td>
		</tr>
		<tr>
			<td width="80" align="right">单号：</td>
			<td width="160">';echo $bet['id'];echo '</td>
			<td width="80" align="right">投注数量：</td>
			<td width="160">';echo $bet['actionNum'];echo '</td>
		</tr>
		<tr>
			<td align="right">发起人：</td>
			<!--<td>';echo $this->iff($bet['username']==$this->user['username'],$bet['username'],preg_replace('/^(\w).*(\w{2})$/','\1***\2',$bet['username']));echo '</td>-->
			<td>';echo preg_replace('/^(\w).*(\w{2})$/','\1***\2',$bet['username']);echo '</td>
			<td align="right">模式：</td>
			<td>';echo $modeName[$bet['mode']];echo '</td>
		</tr>
		<tr>
			<td align="right">倍数：</td>
			<td>';echo $bet['beiShu'];echo '</td>
			<td align="right">中奖注数：</td>
			<td>';echo $this->iff($bet['lotteryNo'],$bet['zjCount'],'－');echo '</td>
		</tr>
		<tr>
			<td align="right">彩种：</td>
			<td>';echo $this->types[$bet['type']]['title'];echo '</td>
			<td align="right">奖金－返点：</td>
			<td>';echo number_format($bet['bonusProp'],2);echo '－';echo number_format($bet['fanDian'],1);echo '%</td>
		</tr>
		<tr>
			<td align="right">期号：</td>
			<td>';echo $bet['actionNo'];echo '</td>
			<td align="right">玩法：</td>
			<td>';echo $this->playeds[$bet['playedId']]['name'];echo '</td>
		</tr>
		<tr>
			<td align="right">开奖号：</td>
			<td>';echo $this->ifs($bet['lotteryNo'],'－');echo '</td>
			<td align="right">投注时间：</td>
			<td>';echo date('m-d H:i',$bet['actionTime']);echo '</td>
		</tr>
		<tr>
			<td align="right">订单状态：</td>
			<td>
			';
if($bet['isDelete']==1){
echo '<font color="#999999">已撤单</font>';
}elseif(!$bet['lotteryNo']){
echo '<font color="#cccccc">未开奖</font>';
}elseif($bet['zjCount']){
echo '<font color="red">已派奖</font>';
}else{
echo '<font color="green">未中奖</font>';
}
;echo '			</td>
			<td align="right">发起庄内庄：</td>
			<td>';echo $this->iff($bet['qzEnable'],'是','否');echo '</td>
		</tr>
		<tr>
			<td align="right">抢庄状态：</td>
			<td>';echo $this->iff($bet['qz_uid'],'抢庄','未抢');echo '</td>
			<td align="right">抢庄人：</td>
			<td>';echo $this->ifs($bet['qz_username'],'－');echo '</td>
		</tr>
		';if($this->user['uid']==$bet['qz_uid']){;echo '		<!-- 抢庄开始　-->
		<tr>
			<td align="right">抢庄投注：</td>
			<td>';echo number_format($bet['beiShu'] * $bet['mode'] * $bet['actionNum'],2);echo '</td>
			<td align="right">抢庄返点：</td>
			<td>';echo number_format(-($bet['fanDian']/100)*$betCont,2);echo '</td>
		</tr>
		<tr>
			<td align="right">抢庄赔付：</td>
			<td>';echo number_format(-$bet['bonus'] -($bet['fanDian']/100)*$betCont -$bet['qz_chouShui'],2);echo '</td>
			<td align="right">抢庄盈亏：</td>
			<td>';echo number_format($bet['beiShu'] * $bet['mode'] * $bet['actionNum'] -$bet['bonus'] -($bet['fanDian']/100)*$betCont -$bet['qz_chouShui'],2);echo '</td>
		</tr>
		<!-- 抢庄结束 -->
		';};echo '		';if($this->user['uid']==$bet['uid']){;echo '		<!-- 投注开始 -->
		<tr>
			<td align="right">投注：</td>
			<td>';echo number_format($betCont,2);echo '元</td>
			<td align="right">中奖：</td>
			<td>';echo $this->iff($bet['lotteryNo'],number_format($bet['bonus'],2) .'元','－');echo '</td>
		</tr>
		<tr>
			<td align="right">返点：</td>
			<td>';echo $this->iff($bet['lotteryNo'],number_format(($bet['fanDian']/100)*$betCont,2).'元','－');echo '</td>
			<td align="right">个人盈亏：</td>
			<td>';echo $this->iff($bet['lotteryNo'],number_format($bet['bonus'] -$betCont +($bet['fanDian']/100)*$betCont,2) .'元','－');echo '</td>
		</tr>
		<!-- 投注结束 -->
		';};echo '        <tr>
        	<td align="right">来源：</td>
            <td colspan="3">';if($bet['betType']==0){echo 'web端';}else if($bet['betType']==1){echo '手机端';}else if($bet['betType']==2){echo '客户端';};echo '</td>
        </tr>
	</table>
</div>'
?>