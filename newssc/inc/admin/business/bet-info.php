<?php

$this->getPlayeds();
$bet=$this->getRow("select * from {$this->prename}bets where id=?",$args[0]);





if(!$bet) throw new Exception('单号不存在');


$type=$this->getRow("select type from {$this->prename}type  where id=?",$bet['type']);

$sql="select id,name  from {$this->prename}played where type = ".$type['type'] ;
if($data=$this->getRows($sql)) {
	
	$select = "<select name=\"playedId\">";
	foreach($data as $key=>$var){
		  $on = $var['id'] == $bet['playedId']?"selected=\"selected\"":"";
	      $select .= "<option value=\"".$var['id']."\" ".$on.">".$var['name']."</option>";
    }
	$select.="</select>";
}





$modeName=array('2.00'=>'元','0.20'=>'角','0.02'=>'分');
$weiShu=$bet['weiShu'];
if($weiShu){
$w=array(16=>'万',8=>'千',4=>'百',2=>'十',1=>'个');
foreach($w as $p=>$v){
if($weiShu &$p) $wei.=$v;
}
$wei.=':';
}
$betCont=$bet['mode'] * $bet['beiShu'] * $bet['actionNum'];

;echo '<form action="/admin.php/business/betInfo_edit/'.$bet['id'].'"  method="post" target="ajax" call="rechargeSubmitCode"><div class="bet-info popupModal" >
	<table cellpadding="0" cellspacing="0" width="480">
		<tr>
			<td align="right">号码：</td>
			<td colspan="3"><textarea cols="45" rows="5" name="actionData">';echo $wei.$bet['actionData'];echo '</textarea></td>
		</tr>
		<tr>
			<td width="80" align="right">单号：</td>
			<td width="160">';echo $bet['id'];echo '</td>
			<td width="80" align="right">投注数量：</td>
			<td width="160">';echo $bet['actionNum'];echo '</td>
		</tr>
		<tr>
			<td align="right">发起人：</td>
			<td>';echo $bet['username'];echo '</td>
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
			<td><span style="display:none;">';echo $this->playeds[$bet['playedId']]['name']."</span>";echo $select.'</td>
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
echo '<font color="#009900">未开奖</font>';
}elseif($bet['zjCount']){
echo '<font color="red">已派奖</font>';
}else{
echo '未中奖';
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
		
		<!-- 抢庄开始　-->
		';if($bet['qz_uid']){;echo '		<tr>
			<td align="right">抢庄投注：</td>
			<td>';echo number_format($bet['beiShu'] * $bet['mode'] * $bet['actionNum'],2);echo '</td>
			<td align="right">抢庄返点：</td>
			<td>';echo number_format(-$bet['fanDianAmount'],2);echo '</td>
		</tr>
		<tr>
			<td align="right">抢庄赔付：</td>
			<td>';echo number_format(-$bet['bonus'] -$bet['fanDianAmount'] -$bet['qz_chouShui'],2);echo '</td>
			<td align="right">抢庄盈亏：</td>
			<td>';echo number_format($bet['beiShu'] * $bet['mode'] * $bet['actionNum'] -$bet['bonus'] -$bet['fanDianAmount'] -$bet['qz_chouShui'],2);echo '</td>
		</tr>
		';};echo '		<!-- 抢庄结束 -->
		
		
		<!-- 投注开始 -->
		<tr>
			<td align="right">投注：</td>
			<td>';echo number_format($betCont,2);echo '元</td>
			<td align="right">中奖：</td>
			<td>';echo $this->iff($bet['lotteryNo'],number_format($bet['bonus'],2) .'元','－');echo '</td>
		</tr>
		<tr>
			<td align="right">返点：</td>
			<td>';echo $this->iff($bet['lotteryNo'],number_format($bet['fanDianAmount'],2).'元','－');echo '</td>
			<td align="right">个人盈亏：</td>
			<td>';echo $this->iff($bet['lotteryNo'],number_format($bet['bonus'] -$betCont +$bet['fanDianAmount'],2) .'元','－');echo '</td>
		</tr>
		<!-- 投注结束 -->
        
        <tr>
        	<td align="right">来源：</td>
            <td colspan="3">';if($bet['betType']==0){echo 'web';}else if($bet['betType']==1){echo '手机';}else{echo '--';};echo '</td>';if($bet['betType']==0){echo 'web端';}else if($bet['betType']==1){echo '手机端';}else if($bet['betType']==2){echo '客户端';};echo '        </tr>
			<tr><td colspan="4"><input type="submit" value="修改投注"/></td></tr>
	</table>
</div></form>'
?>