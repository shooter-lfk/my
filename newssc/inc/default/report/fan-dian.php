<?php
echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
				<div class="tbbox1">
					<div class="heng"><div class="aq-txt txt-w">我的用户：</div><div class="t-a t-1"><input readonly="readonly" class="t-c"  value="';echo $this->user['username'];echo '"/></div></div>
					<div class="heng"><div class="aq-txt txt-w">今日返点总额：</div><div class="t-a t-1"><input readonly="readonly" class="t-c spn9" value="';echo number_format($this->getValue("select sum(coin) from {$this->prename}coin_log where uid=? and liqType between 2 and 3",$this->user['uid']),2);echo '元"/></div></div>
				</div>';
?>