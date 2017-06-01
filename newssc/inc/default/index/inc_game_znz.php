<?php

$sql="select u.username, u.fanDian userFanDian, b.id, b.type, b.playedId, b.mode, b.beiShu, b.actionNo, b.actionNum, b.actionData, b.qz_uid, b.fanDian, b.bonusProp from {$this->prename}bets b, {$this->prename}members u where b.uid=u.uid and kjTime>{$this->time} and b.isDelete=0 and qzEnable=1";
$this->getGameFanDian();
$pageSize=20;
if(!$page=$args[0]) $page=1;
$data=$this->getPage($sql,$page,$pageSize);
$modeName=array('2.00'=>'元','0.20'=>'角','0.02'=>'分');
;echo '<div class="game-left">
			<div class="biao-top">
				<div class="top2 top3">
					<ul class="notopline">
	<p style="margin:5px;color:#000;font-weight:bold;font-size:14px; float:left">庄内庄</p><a onclick="sxznz()" style="float:right; display:block; cursor:pointer; color:#000; margin:5px; background:#ffdf1b; border:#feef91 solid 1px; border-bottom:#ceb102 solid 1px; border-right:#ceb102 solid 1px; line-height:18px; text-decoration:none; text-align:center; width:40px;">刷新</a>
	</ul>
				</div>
			</div>
			<div class="biao-cont leftcont2">
	<!--下注列表-->
	<table width="100%">
		<thead>
			<tr class="tr-top">
				<th>单号</th>
				<th>彩种</th>
				<th>期号</th>
				<th>用户名</th>
				<th>玩法</th>
				<th>号码</th>
				<th>状态</th>
				<th>注数</th>
				<th>金额</th>
				<th>奖-返</th>
				<th>模式</th>
				<th>倍数</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody id="znz-code-list">
		';if($data['data']) foreach($data['data'] as $var){
$var['gameFanDian']=$this->gameFanDian;
$var['fanDianMax']=$this->settings['fanDianMax'];
$var['myFanDian']=$this->user['fanDian'];
$var['setFanDian']=$var['fanDian'];
$var['zjFun']=$this->playeds[$var['playedId']]['zjMax'];
;echo '			<tr class="tr-cont" data-code=\'';echo json_encode($var);echo '\'>
				<td><a onClick="art.dialog.open(\'/index.php/record/betInfo2/';echo $var['id'];echo '\', {id: \'testID3\',lock: true,title: \'投注信息\',width:510, height:384});">…';echo $var['id'];echo '</a></td>
				<td>';echo $this->ifs($this->types[$var['type']]['shortName'],$this->types[$var['type']]['shortName']);echo '</td>
				<td>';echo $var['actionNo'];echo '</td>
				<td>';echo preg_replace('/^(\w).*(\w{3})$/','\1***\2',$var['username']);echo '</td>
				<td>';echo $this->playeds[$var['playedId']]['name'];echo '</td>
				<td>';echo Object::CsubStr($var['actionData'],0,10);echo '</td>
				<td>';echo $this->iff($var['qz_uid'],'<font color="red">被抢</font>','<font color="#33CC33">未抢</font>');echo '</td>
				<td>';echo $var['actionNum'];echo '</td>
				<td>';echo number_format($var['actionNum'] * $var['mode'] * $var['beiShu'],2);echo '</td>
				<td>';echo $var['bonusProp'].'-'.$var['fanDian'].'%';echo '</td>
				<td>';echo $modeName[$var['mode']];echo '</td>
				<td>';echo $var['beiShu'];echo '</td>
				<td>
					';if($var['qz_uid']){;echo '					--
					';}else{;echo '					<div class="qzbtn">抢庄</div>
					';};echo '				</td>
			</tr>
		';};echo '		</tbody>
	</table>
	<!--下注列表 end -->
</div>
';
?>