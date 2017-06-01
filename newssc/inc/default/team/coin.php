<?php

$teamAll=$this->getRow("select sum(u.coin) coin, sum(u.fcoin) fcoin from {$this->prename}members u where u.isDelete=0 and concat(',', u.parents, ',') like '%,{$this->user['uid']},%'");
;echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
<div class="tbbox1">
	<table width="540" border="0" cellpadding="0" cellspacing="1" class="table_3">
		<tr><th width="96">我的账号：</th><td width="444" style="background:none;"> ';echo $this->user['username'];echo '<!-- (';echo $this->iff($this->user['type'],'代理','会员');echo ') &nbsp;&nbsp; 用户编号：';echo $this->user['uid'];echo ' &nbsp;&nbsp; 等级：Lv';echo $this->user['grade'];echo ' &nbsp;&nbsp; 返点：';echo $this->user['fanDian'];echo '%--></td></tr>
		<tr><th>可用资金：</th><td style="background:none;"> ';echo $teamAll['coin'];echo '元</td></tr>
		<tr><th>冻结资金：</th><td style="background:none;"> ';echo $teamAll['fcoin'];echo '元</td></tr>
		<tr><th>全部资金：</th><td style="background:none;"> ';echo $teamAll['coin']+$teamAll['fcoin'];echo '元</td></tr>
		<tr><th>返点：</th><td style="background:none;"> ';echo number_format($this->getValue("select sum(coin) from {$this->prename}coin_log where uid=? and liqType between 2 and 3",$this->user['uid']),2);echo '元</td></tr>
	</table>
</div>';
?>