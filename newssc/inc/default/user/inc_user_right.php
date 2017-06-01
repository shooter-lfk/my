<?php
 $this->freshSession();;echo '<div class="userbg">
<div class="ubg-left img-bj"></div>
<div class="ubg-right img-bj">
<div class="user user2">
	<div class="u-title">
		<div class="user-img img01"></div>
		<span class="spn1">用户</span>&nbsp;&nbsp;<span class="spn2">';echo $this->user['username'];echo '</span>
	</div>
	<div class="u-cont">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<table class="u-tab"  cellpadding="0" cellspacing="0">
					<tr>
                        <td class="u-td0" nowrap><div class="tag-grade img01"></div>等级<span class="spn3"> ';echo $this->user['grade'];echo '级</span></td>
                        <td class="u-td0" nowrap><div class="tag-score img01"></div>积分<span class="spn3"> ';echo $this->user['score'];echo '</span></td>
					</tr>
				</table>
			</tr>
			<tr>
				<table class="u-tab" cellpadding="0" cellspacing="0">
					<tr>
                        <td class="bj-zj"><div class="tag-fund img01"></div>资<br />金<br />￥</td>
						<td>
							<table  cellpadding="0" cellspacing="0">
								<tr>
									<td class="u-td1">可用</td>
									<td class="u-td1">冻结</td>
								</tr>
								<tr>
									<td class="u-td2"><a href="#" title="刷新余额" onclick="reloadMemberInfo()">';echo number_format($this->user['coin'],2);echo '</a></td>
									<td class="u-td2"><a href="/index.php/report/fcoinModal" width="800" title="冻结资金项目" target="modal" button="确定:defaultModalCloase">';echo number_format($this->user['fcoin'],2);echo '</td>
								</tr>
                                <tr>
                                    <td class="u-td1 u-tk"><a href="/index.php/cash/recharge">充值</a></td>
                                    <td class="u-td1 u-tk"><a href="/index.php/cash/toCash">提款</a></td>
                                </tr>
							</table>
						</td>
					</tr>
				</table>
			</tr>
			<tr>
				<table class="u-tab" cellpadding="0" cellspacing="0">
					<tr>
                        <td class="bj-zhj"><div class="tag-win img01"></div>￥</td>
						<td>
							<table  cellpadding="0" cellspacing="0">
								<tr>
									<td class="u-td1">今日中奖</td>
									<td class="u-td1">今日消费</td>
								</tr>
								<tr>
									';$date=strtotime('00:00:00');;echo '									<td class="u-td2"><a href="/index.php/record/dateModal?state=1" title="今日中奖列表" target="modal" width="800" button="确定:defaultModalCloase">
								';echo number_format($this->getValue("select sum(bonus) from {$this->prename}bets where kjTime > ? and uid={$this->user['uid']}",$date),2);echo '</td>
									<td class="u-td2"><a href="/index.php/record/dateModal" title="今日投注列表" target="modal" width="800" button="确定:defaultModalCloase">
                                ';echo number_format($this->getValue("select sum(beiShu * mode * actionNum) from {$this->prename}bets where actionTime > ? and uid={$this->user['uid']} and isDelete=0",$date),2);echo '								</a></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</tr>
		</table>
	</div>
</div>
</div>
</div>
';
?>