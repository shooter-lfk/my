<?php
echo '<div class="game-left img-bj">
<div id="bet-game">
	<div class="game-btn img02">
	';
if($_COOKIE['mode']){
$mode=$_COOKIE['mode'];
}else{
$mode=2;
}
$this->getTypes();
$sql="select id, groupName, enable from {$this->prename}played_group where enable=1 and type=?";
$groups=$this->getObject($sql,'id',$this->types[$this->type]['type']);
if($this->groupId &&!$groups[$this->groupId]) unset($this->groupId);
if($groups) foreach($groups as $key=>$group){
if(!$this->groupId) $this->groupId=$group['id'];
;echo '		<div class="ul-li';echo ($this->groupId==$group['id'])?' current img01':'';echo '">
			<a class="cai" href="/index.php/index/group/';echo $this->type .'/'.$group['id'];echo '">';echo $group['groupName'];echo '</a>
			<a class="wfline img01"></a>
		</div>
	';};echo '	</div>
	<div class="game-cont img02">
		';$this->display('index/inc_game_played.php');;echo '		<div class="num-table" style="height:auto;" id="game-dom">
			<div class="fandian">
				<div class="fandian-k">
					<span class="spn8">奖金/返点：</span>
					<div class="fandian-box img02">
						<input type="button" class="min" value="" step="-0.1"/>
						<div id="slider" class="slider" value="';echo $this->ifs($_COOKIE['fanDian'],0);echo '" max="';echo $this->user['fanDian'];echo '" game-fan-dian="';echo $this->settings['fanDianMax'];echo '" fan-dian="';echo $this->user['fanDian'];echo '" game-fan-dian-bdw="';echo $this->settings['fanDianBdwMax'];echo '" fan-dian-bdw="';echo $this->user['fanDianBdw'];echo '" min="0" step="0.1" slideCallBack="gameSetFanDian"></div>
						<input type="button" class="max" value="" step="0.1"/>
					</div>
					<span id="fandian-value">';echo $maxPl;echo '/0%</span>
				</div>
				<div class="danwei">
					<span class="spn8">模式：</span>
					<label>元<input type="radio" value="2.00" name="danwei" checked /></label>
					<label>角<input type="radio" value="0.20" name="danwei" /></label>
					<!--<label>分<input type="radio" value="0.02" name="danwei" ';
;echo '/></label>-->
				</div>
				<div class="beishu"><span class="spn8">倍数：</span><input id="beishu" value="';echo $this->ifs($_COOKIE['beishu'],1);echo '"/><span>倍</span></div>
				<div class="btn-preserve img01" onclick="setBeiShuCookie(\'#beishu\')">保&nbsp;存</div>
			</div>
			
		</div>
		<div class="touzhu img02">
			<div class="touzhu-top">
				<!--<button class="tz-top-btn img02" onclick="gameActionRandom(1)">机选一注</button>
				<button class="tz-top-btn img02" onclick="gameActionRandom(5)" >机选五注</button>-->
				<button class="tz-top-btn img02" onclick="gameActionRemoveCode()">清空号码</button>
                <div class="prompt" id="game-tip-dom"><!--提示：必须选满三位数再投注！--></div>
				<div class="tztj-btn img02"><div class="tztj-hover img01" onclick="gameActionAddCode()"></div></div>
			</div>
			<!--<select size="7" class="touzhu-cont" id="select-code" ></select>-->
			<div class="touzhu-cont">
				<table width="100%">
					
				</table>
			</div>
			<div class="touzhu-bottom">
				<div class="tz-tongji">总投注数：<span class="spn10" id="all-count">0</span>&nbsp;注&nbsp;&nbsp;&nbsp;&nbsp;购买金额：<span class="spn10" id="all-amount">0.00</span>&nbsp;元</div>
				<div class="tz-buytype">
					<label><input type="checkbox" name="qzEnable" value="1" />庄内庄</label>
					<!-- <input type="checkbox" name="buy_type" /><label for="type-hm">合买</label> -->
					<label><input type="checkbox" name="zhuiHao" value="1" />追号</label>
				</div>
				<div class="tz-true-btn img02"><div class="tz-true-hover img01" id="btnPostBet"></div></div>
			</div>
		</div>
		<div class="touzhu-true">
			<table width="100%">
				<thead>
					<tr>
						<td width="5%">单号</td>
						<td width="10%">投注时间</td>
						<td width="10%">彩种</td>
						<td width="10%">玩法</td>
						<td width="10%">期号</td>
						<td width="15%">投注号码</td>
						<td width="5%">注数</td>
						<td width="5%">倍数</td>
						<td width="10%">金额</td>
						<td width="5%">模式</td>
						<td width="15%">奖-返</td>
						<td width="5%">操作</td>
					</tr>
				</thead>
				<tbody id="order-history">';$this->display('index/inc_game_order_history.php');;echo '</tbody>
			</table>
		</div>
	</div>
</div>
<div id="znz-game" style="display:none;"></div>
</div>'
?>