<?php

$sql="select c.*, u.username user, u.coin coin, b.name bankName from {$this->prename}member_cash c,{$this->prename}members u, {$this->prename}bank_list b where b.id=c.bankId and c.uid=u.uid and b.isDelete=0 and c.id={$args[0]}";
$cashInfo=$this->getRow($sql,$args[0]);
;echo '<div class="cash-modal popupModal">
	<table width="100%" cellpadding="2" cellspacing="2">
		<tr>
			<td class="title" width="180">用户</td>
			<td>';echo $cashInfo['user'];echo '</td>
		</tr>
		<tr>
			<td class="title">提现金额</td>
			<td>';echo $cashInfo['amount'];echo '元</td>
		</tr>
		<tr>
			<td class="title">提现前可用资金</td>
			<td>';echo number_format($cashInfo['coin']);echo '元</td>
		</tr>
		<tr>
			<td class="title">银行</td>
			<td>';echo $cashInfo['bankName'];echo '</td>
		</tr>
		<tr>
			<td class="title">账号</td>
			<td>';echo $cashInfo['account'];echo '</td>
		</tr>
		<tr>
			<td class="title">开户名</td>
			<td>';echo $cashInfo['username'];echo '</td>
		</tr>
        <tr>
			<td class="title">申请时间</td>
			<td>';echo date("Y-m-d H:i:s",$cashInfo['actionTime']);echo '</td>
		</tr>
	</table>
</div>';
?>