<?php
echo '<article class="module width_full">
	<header><h3 class="tabs_involved">系统设置</h3></header>
	<form name="system_install" action="/admin.php/system/updateSettings" method="post" target="ajax" call="sysSettings" onajax="sysSettingsBefor">
	<table class="tablesorter left" cellspacing="0" width="100%">
		<thead>
			<tr>
				<td width="160" style="text-align:left;">配置项目</td>
				<td style="text-align:left;">配置值</td>
			</tr>
		</thead>
		<tbody class="left">
			<tr>
				<td>平台名称</td>
				<td><input type="text" value="';echo $this->settings['webName'];echo '" name="webName"/></td>
			</tr>
			<tr>
				<td>网站服务开关</td>
				<td>
					<label><input type="radio" value="1" name="switchWeb" ';echo $this->iff($this->settings['switchWeb'],'checked="checked"');echo '/>开启</label>
					<label><input type="radio" value="0" name="switchWeb" ';echo $this->iff(!$this->settings['switchWeb'],'checked="checked"');echo '/>关闭</label>
				</td>
			</tr>
			<tr>
				<td>手机端开关</td>
				<td>
					<label><input type="radio" value="1" name="switchAndroid" ';echo $this->iff($this->settings['switchAndroid'],'checked="checked"');echo '/>开启</label>
					<label><input type="radio" value="0" name="switchAndroid" ';echo $this->iff(!$this->settings['switchAndroid'],'checked="checked"');echo '/>关闭</label>
				</td>
			</tr>
			<tr>
				<td>关闭网站公告</td>
				<td>
					<textarea name="webCloseServiceResult" cols="56" rows="5">';echo $this->settings['webCloseServiceResult'];echo '</textarea>
				</td>
			</tr>
			<tr>
				<td>抢庄功能开关</td>
				<td>
					<label><input type="radio" value="1" name="switchMaster" ';echo $this->iff($this->settings['switchMaster'],'checked="checked"');echo '/>开启</label>
					<label><input type="radio" value="0" name="switchMaster" ';echo $this->iff(!$this->settings['switchMaster'],'checked="checked"');echo '/>关闭</label>
				</td>
			</tr>
			<tr>
				<td>最大返点限制</td>
				<td>
                	  元模式：<input type="text" class="textWid1" value="';echo $this->settings['betModeMaxFanDian0'];echo '" name="betModeMaxFanDian0"/>%
                	　角模式：<input type="text" class="textWid1" value="';echo $this->settings['betModeMaxFanDian1'];echo '" name="betModeMaxFanDian1"/>%
                	　分模式：<input type="text" class="textWid1" value="';echo $this->settings['betModeMaxFanDian2'];echo '" name="betModeMaxFanDian2"/>%
                </td>
			</tr>
			<tr>
				<td>最大投注限制</td>
				<td>
                	  最大注数：<input type="text" class="textWid1" value="';echo $this->settings['betMaxCount'];echo '" name="betMaxCount"/>注
                	　最大中奖：<input type="text" class="textWid1" value="';echo $this->settings['betMaxZjAmount'];echo '" name="betMaxZjAmount"/>元
                </td>
			</tr>
			<tr>
				<td>充值限制</td>
				<td>
                	最低金额：<input type="text" value="';echo $this->settings['rechargeMin'];echo '" name="rechargeMin"/>元&nbsp;&nbsp; 
                    最高金额：<input type="text" value="';echo $this->settings['rechargeMax'];echo '" name="rechargeMax"/>元
                    <br /><br />
                	支付宝/财付通：最低金额 <input type="text" value="';echo $this->settings['rechargeMin1'];echo '" name="rechargeMin1"/>元&nbsp;&nbsp;最高金额 <input type="text" value="';echo $this->settings['rechargeMax1'];echo '" name="rechargeMax1"/>元&nbsp;&nbsp;
                    
                </td>
			</tr>
			<tr>
				<td>提现限制</td>
				<td>
					最低金额：<input type="text" value="';echo $this->settings['cashMin'];echo '" name="cashMin"/>元&nbsp;&nbsp;
					最高金额：<input type="text" value="';echo $this->settings['cashMax'];echo '" name="cashMax"/>元&nbsp;&nbsp;
					时间段： 从 <input type="time" value="';echo $this->settings['cashFromTime'];echo '" name="cashFromTime" class="textWid1"/> 到 <input type="time" value="';echo $this->settings['cashToTime'];echo '" name="cashToTime" class="textWid1"/>
                    <br /><br />
                	支付宝/财付通：最低金额 <input type="text" value="';echo $this->settings['cashMin1'];echo '" name="cashMin1"/>元&nbsp;&nbsp;最高金额 <input type="text" value="';echo $this->settings['cashMax1'];echo '" name="cashMax1"/>元&nbsp;&nbsp;
				</td>
			</tr>
			<tr>
				<td>清理账号规则</td>
				<td>账户金额低于&nbsp;<input type="text" value="';echo $this->settings['clearMemberCoin'];echo '" name="clearMemberCoin" id="clearMemberCoin"/>元，&nbsp;且&nbsp;<input type="text" value="';echo $this->settings['clearMemberDate'];echo '" name="clearMemberDate" id="clearMemberDate"/> &nbsp;天未登录&nbsp;&nbsp;<a method="post" target="ajax" onajax="clearUsersBefor" call="clearDataSuccess" title="数据清除不可修复，是否继续！" dataType="json" id="alt_btn3" href="/admin.php/System/clearUser">清理</a></td>
			</tr>
			<tr>
				<td>清理数据</td>
				<td>清除当前 <input type="date" readonly="readonly" id="clearData" /> 日期及以前数据&nbsp;&nbsp;<a method="post" target="ajax" onajax="clearDataBefor" call="clearDataSuccess" title="数据清除不可修复，是否继续！" dataType="json" id="alt_btn3" href="/admin.php/System/clearData">清理</a></td>
			</tr>
			<tr>
				<td>赠送活动</td>
				<td>首次注册绑定工行送<input type="text" value="';echo $this->settings['huoDongRegister'];echo '" name="huoDongRegister"/>元 &nbsp;&nbsp;每天签到每次送<input type="text" value="';echo $this->settings['huoDongSign'];echo '" name="huoDongSign"/>元，如果为0则关闭活动</td>
			</tr>
			<tr>
				<td>充值佣金活动</td>
				<td>每天首次充值金额<input type="text" value="';echo $this->settings['rechargeCommissionAmount'];echo '" name="rechargeCommissionAmount"/>元以上，上家送<input type="text" value="';echo $this->settings['rechargeCommission'];echo '" name="rechargeCommission"/>元佣金，上上家送<input type="text" value="';echo $this->settings['rechargeCommission2'];echo '" name="rechargeCommission2"/>元佣金，如果为0则关闭活动</td>
			</tr>
			<tr>
				<td>消费佣金活动</td>
				<td>
				<p>每天消费达<input type="text" value="';echo $this->settings['conCommissionBase'];echo '" name="conCommissionBase"/>元时，上家送<input type="text" value="';echo $this->settings['conCommissionParentAmount'];echo '" name="conCommissionParentAmount"/>元佣金，如果为0则关闭活动</p>
				
				<p>每天消费达<input type="text" value="';echo $this->settings['conCommissionBase2'];echo '" name="conCommissionBase2"/>元时，上家送<input type="text" value="';echo $this->settings['conCommissionParentAmount2'];echo '" name="conCommissionParentAmount2"/>元佣金，如果为0则关闭活动</p></td>
			</tr>
			<tr>
				<td>返点最大值</td>
				<td><input type="text" value="';echo $this->settings['fanDianMax'];echo '" name="fanDianMax"/>% &nbsp;&nbsp;不定位返点最大值<input type="text" value="';echo $this->settings['fanDianBdwMax'];echo '" name="fanDianBdwMax"/>%</td>
			</tr>
			<tr>
				<td>上下级返点最小差值</td>
				<td><input type="text" value="';echo $this->settings['fanDianDiff'];echo '" name="fanDianDiff"/>%</td>
			</tr>
			<tr>
				<td>最低限制人数返点</td>
				<td><input type="text" value="';echo $this->settings['minFanDianUserCount'];echo '" name="minFanDianUserCount"/>%</td>
			</tr>
			<tr>
				<td>积分比例</td>
				<td>
					<input type="text" value="';echo $this->settings['scoreProp'];echo '" name="scoreProp"/> 每消费1元积的分数
				</td>
			</tr>
			<tr>
				<td>积分规则</td>
				<td>
					<textarea name="scoreRule" cols="56" rows="5">';echo $this->settings['scoreRule'];echo '</textarea>
				</td>
			</tr>
			<tr>
				<td>聊天室状态</td>
				<td>
					<label><input type="radio" value="1" name="chatStatus" ';echo $this->iff($this->settings['chatStatus'],'checked="checked"');echo '/>开启</label>
					<label><input type="radio" value="0" name="chatStatus" ';echo $this->iff(!$this->settings['chatStatus'],'checked="checked"');echo '/>关闭</label>
					　　
					<input type="text" value="';echo $this->settings['chatFrequency'];echo '" name="chatFrequency"/> 秒发言一次
				</td>
			</tr>
			<tr>
				<td>聊天室公告</td>
				<td>
					<textarea name="chatGG" cols="56" rows="5">';echo $this->settings['chatGG'];echo '</textarea>
				</td>
			</tr>
			<tr>
				
				<td class="tdEnd">网站风格主题</td>
				<td class="tdEnd">
				<div class="submit_link" style="float:left">
				<select style="width:90px;">
					<option>蓝色妖姬</option>
				</select>
				</div>
				</td>
			</tr>
		</tbody>
	</table>
	<footer>
		<div class="submit_link">
			<input type="submit" value="保存修改设置" title="保存设置" class="alt_btn">&nbsp;&nbsp;
			<input type="button" onclick="load(\'system/settings\')" value="重置" title="重置原来的设置" >
		</div>
	</footer>
	</form>
</article>';
?>