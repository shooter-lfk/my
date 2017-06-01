<?php
echo '<table cellpadding="0" cellspacing="0" width="320" class="layout">
	<tr>
		<th>选择充值：</th>
		<td><label>UserID<input type="radio" name="user" value="1" /></label> <label>用户名<input type="radio" name="user" value="2" checked="checked" /></label></td>
	</tr>
	<tr>
		<th></th>
		<td><input type="text" name="uid" /></td>
	</tr>
	<tr>
		<th>充值金额：</th>
		<td><input type="text" name="amount" min="100" /><span style="color:#F00">负数为扣款！</span></td>
	</tr>
	<tr>
		<th><span class="spn9">提示：</span></th>
		<td><span class="spn9">填写用户名或者用户ID均可充值</span></td>
	</tr>
</table>';
?>