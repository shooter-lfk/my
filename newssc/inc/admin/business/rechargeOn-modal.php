<?php

$sql="select r.*,u.username username from {$this->prename}member_recharge r, {$this->prename}members u where r.uid=u.uid and r.id=?";
$rechargeData=$this->getRow($sql,$args[0]);
;echo '<div>
<form action="/admin.php/business/rechargeHandle"  target="ajax" method="post" call="rechargeSubmitCode" onajax="rechargeBeforeSubmit" dataType="html">
	<input type="hidden" name="id" value="';echo $args[0];echo '"/>
<table cellpadding="0" cellspacing="0" width="320" class="layout">
	<tr>
		<th>用户名：</th>
		<td><input type="text" value="';echo $rechargeData['username'];echo '" /></td>
	</tr>
	<tr>
		<th>充值金额：</th>
		<td><input type="text" name="amount" value="';echo $rechargeData['amount'];echo '" /></td>
	</tr>
	<tr>
		<th>实际到账：</th>
		<td><input type="text" name="rechargeAmount" value="';echo $rechargeData['amount'];echo '"/></td>
	</tr>
	<tr>
		<th><span class="spn9">提示：</span></th>
		<td><span class="spn9">实际到账默认为充值金额，可更改！</span></td>
	</tr>
</table>
</form>
</div>';
?>