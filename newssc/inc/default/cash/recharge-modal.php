<?php
echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
';
$sql="select r.* from {$this->prename}member_recharge r where r.id={$args[0]}";
$rechargeInfo=$this->getRow($sql,$args[0]);
if($rechargeInfo['mBankId']){
$sql="select mb.username accountName, mb.account account, b.name bankName from {$this->prename}members u,{$this->prename}member_bank mb, {$this->prename}bank_list b where u.uid={$rechargeInfo['uid']} and mb.id={$rechargeInfo['mBankId']} and mb.bankId=b.id and b.isDelete=0";
$bankInfo=$this->getRow($sql);
}
;echo '<div class="recharge-modal popupModal">
	<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_1">
		<tr>
			<td class="title">用户</td>
			<td>';echo $rechargeInfo['username'];echo '</td>
		</tr>
		<tr>
			<td class="title">充值金额</td>
			<td>';echo $rechargeInfo['amount'];echo '元</td>
		</tr>
		<tr>
			<td class="title">充值前资金</td>
			<td>';echo number_format($rechargeInfo['coin'],2);echo '元</td>
		</tr>
		<tr>
			<td class="title">充值银行</td>
			<td>';echo $this->ifs($bankInfo['bankName'],'--');echo '</td>
		</tr>
		<tr>
			<td class="title">银行账号</td>
			<td>';echo $this->ifs($bankInfo['account'],'--');echo '</td>
		</tr>
		<tr>
			<td class="title">开户名</td>
			<td>';echo $this->ifs($bankInfo['accountName'],'--');echo '</td>
		</tr>
        <tr>
			<td class="title">充值时间</td>
			<td>';echo date("Y-m-d H:i:s",$rechargeInfo['rechargeTime']);echo '</td>
		</tr>
	</table>
</div>';
?>