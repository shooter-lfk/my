<?php

$sql="select u.username, u.coin, u.uid, u.parentId, sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount, sum(c.amount) cashAmount, sum(r.amount) rechargeAmount from {$this->prename}members u left join {$this->prename}bets b on u.uid=b.uid $betTimeWhere left join {$this->prename}member_cash c on u.uid=c.uid $cashTimeWhere left join {$this->prename}member_recharge r on r.uid=u.uid $rechargeTimeWhere where 1 and u.uid=?";
$var=$this->getRow($sql,$args[0]);
$sql="select sum(coin) from {$this->prename}coin_log where uid=? and liqType between 2 and 3";
$var['fanDianAmount']=$this->getValue($sql,$var['uid']);
;echo '<div>
	<table cellpadding="2" cellspacing="2" class="popupModal">
		<tr>
			<td class="title" width="180">用户名：</td>
			<td><input type="text" readonly="readonly" value="';echo $var['username'];echo '"/></td>
		</tr>
      <td class="title" width="180">投注总额</td>
      <td><input type="text" readonly="readonly" value="';echo $this->ifs($var['betAmount'],'--');echo '"/></td>
		</tr>
		<tr>
			<td class="title">中奖总额</td>
			<td><input type="text" readonly="readonly" value="';echo $this->ifs($var['zjAmount'],'--');echo '"/></td>
		</tr>
		<tr>
			<td class="title">总返点</td>
			<td><input type="text" readonly="readonly" value="';echo $this->ifs($var['fanDianAmount'],'--');echo '"/></td>
		</tr>
		<tr>
			<td class="title">充值</td>
			<td><input type="text" readonly="readonly" value="';echo $this->ifs($var['rechargeAmount'],'--');echo '"/></td>
		</tr>
		<tr>
			<td class="title">提现</td>
			<td><input type="text" readonly="readonly" value="';echo $this->ifs($var['cashAmount'],'--');echo '"/></td>
		</tr>
		<tr>
			<td class="title">余额</td>
			<td><input type="text" readonly="readonly" value="';echo $this->ifs($var['coin'],'--');echo '"/></td>
		</tr>
		<tr>
			<td class="title">个人总结算</td>
			<td><input type="text" readonly="readonly" value="';echo $this->ifs($var['zjAmount']-$var['betAmount']+$var['fanDianAmount'],'--');echo '"/></td>
		</tr>
	</table>
</div>';
?>