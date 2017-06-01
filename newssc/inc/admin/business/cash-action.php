<?php
echo '<div class="cash-modal" data="';echo $args[0]['id'];echo '">
<form action="/admin.php/business/cashDealWith/';echo $args[0]['id'];echo '"  target="ajax" method="post" call="rechargeSubmitCode" dataType="html">
	<ul>
		<li><input type="button" class="copy" value="复制" rel="';echo $args[0]['bankName'];echo '"/> 银行类型：';echo $args[0]['bankName'];echo '&nbsp;&nbsp;<a href="';echo $args[0]['home'];echo '" style="color:#f00;">进入>></a></li>
		<li><input type="button" class="copy" value="复制" rel="';echo $args[0]['username'];echo '"/> 开户姓名：';echo $args[0]['username'];echo '</li>
		<li><input type="button" class="copy" value="复制" rel="';echo $args[0]['account'];echo '"/> 银行帐号：';echo $args[0]['account'];echo '</li>
		<li><input type="button" class="copy" value="复制" rel="';echo $args[0]['amount'];echo '"/> 提取金额：';echo $args[0]['amount'];echo '</li>
	</ul>
	<p>
		<label><input type="radio" name="type" value="0" checked onclick="cashTrue()"/>提现成功（扣除冻结款）</label>
		<label><input type="radio" name="type" value="1" onclick="cashFalse()"/>提现失败（返还冻结款）</label>
        <input type="text" class="cashFalseSM" name="info" style="display:none; overflow-y:auto; width:100%;"  value=""/>
	</p>
</form>
</div>';
?>