<?php
 
$uid=$args[0];
$son=$this->getRow("select count(*) teamNum, sum(coin) teamCoin, sum(fcoin) teamFcoin from {$this->prename}members where concat(',', parents, ',') like '%,$uid,%'");
;echo '<div>
';
echo $son['teamNum'];
if($son['teamNum']-1>0){;echo '<form target="ajax" method="post" call="nothin" dataType="html">
	<input type="hidden" name="uid" value="';echo $uid;echo '" />
	<input type="hidden" name="teamCoin" value="';echo $son['teamCoin'];echo '" />
	<input type="hidden" name="teamFcoin" value="';echo $son['teamFcoin'];echo '" />
	 团队还有成员';echo $son['teamNum'];echo '人，团队资金';echo $this->ifs($son['teamCoin'],'0.00');echo '元,团队冻结';echo $this->ifs($son['teamFcoin'],'0.00');echo '元，请先删除团队成员。
</form>
';}else{;echo '<form action="/admin.php/Member/deleteed/';echo $uid;echo '" target="ajax" method="post" call="userDataSubmitCode" dataType="html">
	<input type="hidden" name="uid" value="';echo $uid;echo '" />
	<input type="hidden" name="teamCoin" value="';echo $son['teamCoin'];echo '" />
	<input type="hidden" name="teamFcoin" value="';echo $son['teamFcoin'];echo '" />
	无团队成员，个人资金';echo $this->ifs($son['teamCoin'],'0.00');echo '元,团队冻结';echo $this->ifs($son['teamFcoin'],'0.00');echo '元。<br />
	<span style="color:#F00; text-align:center; line-height:50px;">确定删除将不能恢复，是否确定？</span><br />
</form>
';};echo '</div>';
?>