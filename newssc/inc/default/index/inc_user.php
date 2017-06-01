<?php
 $this->freshSession();;echo '<div class="user"><div class="u-cont">
  <ul>
    <li class="username"><span>';echo $this->user['username'];echo '</span><!--a onClick="art.dialog.open(\'/index.php/score/viewRule\', {id: \'testID4\',lock: true,title: \'积分规则\',width:445});">Lv';echo $this->user['grade'];echo '</a--></li>
    <li>可用余额：<a href="#" title="刷新余额" onclick="reloadMemberInfo()">';echo number_format($this->user['coin'],2);echo '</a></li>
    <li>冻结金额：<a onClick="art.dialog.open(\'/index.php/report/fcoinModal\', {id: \'testID4\',lock: true,title: \'冻结资金项目\',width:800});">';echo number_format($this->user['fcoin'],2);echo '</a></li>';$date=strtotime('00:00:00');;echo '    <li>今日中奖：<a onClick="art.dialog.open(\'/index.php/record/dateModal?state=1\', {id: \'testID4\',lock: true,title: \'今日中奖列表\',width:800, height:535});">';echo number_format($this->getValue("select sum(bonus) from {$this->prename}bets where kjTime > ? and uid={$this->user['uid']}",$date),2);echo '</a></li>
    <li>今日消费：<a onClick="art.dialog.open(\'/index.php/record/dateModal\', {id: \'testID4\',lock: true,title: \'今日投注列表\',width:800, height:535});">';echo number_format($this->getValue("select sum(beiShu * mode * actionNum) from {$this->prename}bets where actionTime > ? and uid={$this->user['uid']} and isDelete=0",$date),2);echo '</a></li>
    <li class="minout"><a onClick="art.dialog.open(\'/index.php/cash/recharge\', {id: \'testID4\',lock: true,title: \'自动到账充值系统\',width:542, height:528});">充值</a> <a onClick="art.dialog.open(\'/index.php/cash/toCash\', {id: \'testID4\',lock: true,title: \'提现\',width:542, height:318});">提现</a></li>
  </ul>
</div></div>
';
?>