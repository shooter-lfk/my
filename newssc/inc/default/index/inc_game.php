<?php
echo '<div class="game-left">
<div id="bet-game">
	<div class="game-btn">
		<div class="znzbtn"><a href="#" class="cai-bj" id="switch-znz-bet"  data-status="';echo $this->settings['switchMaster'];echo '"> 庄内庄 </a></div>
	';
if($_COOKIE['mode']){
$mode=$_COOKIE['mode'];
}else{
$mode=2.00;
}
$this->getTypes();
$sql="select id, groupName, enable from {$this->prename}played_group where enable=1 and type=?";
$groups=$this->getObject($sql,'id',$this->types[$this->type]['type']);
if($this->groupId &&!$groups[$this->groupId]) unset($this->groupId);
if($groups) foreach($groups as $key=>$group){
if(!$this->groupId) $this->groupId=$group['id'];
;echo '	  
		<div class="ul-li';echo ($this->groupId==$group['id'])?' current':'';echo '">
			<a class="cai" href="/index.php/index/group/';echo $this->type .'/'.$group['id'];echo '">';echo $group['groupName'];echo '</a>
		</div>
	';};echo '	</div>
	<div class="game-cont ';echo ($this->types[$this->type]['type']==5||$this->types[$this->type]['type']==6)?' carbg':'';echo '';echo ($this->types[$this->type]['type']==7)?' ytdbg':'';echo '">
<!---<div class="game-btn2">--->
		';$this->display('index/inc_game_played.php');;echo '		<div class="num-table" style="height:auto;" id="game-dom">
			<div class="fandian">
				<div class="prompt" id="game-tip-dom"><!--提示：必须选满三位数再投注！--></div>
				<div class="fandian-k">
					<div class="fandian-box">
						<input type="button" class="min" value="" step="-0.1"/>
						<div id="slider" class="slider" value="';echo $this->ifs($_COOKIE['fanDian'],0);echo '" data-bet-count="';echo $this->settings['betMaxCount'];echo '" data-bet-zj-amount="';echo $this->settings['betMaxZjAmount'];echo '" max="';echo $this->user['fanDian'];echo '" game-fan-dian="';echo $this->settings['fanDianMax'];echo '" fan-dian="';echo $this->user['fanDian'];echo '" game-fan-dian-bdw="';echo $this->settings['fanDianBdwMax'];echo '" fan-dian-bdw="';echo $this->user['fanDianBdw'];echo '" min="0" step="0.1" slideCallBack="gameSetFanDian"></div>
						<input type="button" class="max" value="" step="0.1"/>
					</div>			
					<span id="fandian-value">';echo $maxPl;echo '/0%</span>
				</div>
        <div class="san">
					<div class="beishu"><span class="spn8">倍数：</span><input id="beishu" value="';echo $this->ifs($_COOKIE['beishu'],1);echo '"/></div>
					<div class="btn-preserve" onclick="setBeiShuCookie(\'#beishu\')">保存</div>
				</div>
					<div class="danwei">
					<span class="spn8">模式：</span>
					<label><input type="radio" value="2.00" data-max-fan-dian="';echo $this->settings['betModeMaxFanDian0'];echo '" name="danwei" ';echo $this->iff($mode=='2.00','checked');echo ' />元</label>
					<label><input type="radio" value="0.20" data-max-fan-dian="';echo $this->settings['betModeMaxFanDian1'];echo '" name="danwei" ';echo $this->iff($mode=='0.20','checked');echo ' />角</label>
					<label><input type="radio" value="0.02" data-max-fan-dian="';echo $this->settings['betModeMaxFanDian2'];echo '" name="danwei" ';echo $this->iff($mode=='0.02','checked');echo ' />分</label>
					</div>
		  </div>
		<div class="touzhu">
			<!--<select size="7" class="touzhu-cont" id="select-code" ></select>-->
			<div class="touzhu-cont">
				<table width="100%"></table>
			</div>
			<div class="touzhu-bottom">
				<div class="tz-tongji">总 <span class="spn10" id="all-count">0</span> 注 共 <span class="spn10" id="all-amount">0.00</span> 元</div>
				<div class="tz-buytype" style="position:relative;">
					<label><input type="checkbox" name="qzEnable" value="1" checked="checked"/>庄内庄</label>
					<!-- input type="checkbox" name="buy_type" /><label for="type-hm">合买</label -->
					<label style="position:absolute;z-index:-999;"><input type="checkbox" name="zhuiHao" value="1" />追号</label>
				</div>
			</div>
		</div>
				  <!--按钮区-->
        <div class="btnarea">
        <div class="tztj-hover" onclick="gameActionAddCode()">添加号码</div>
        <!--<button class="tz-top-btn img02" onclick="gameActionRandom(1)">机选一注</button>
				<button class="tz-top-btn img02" onclick="gameActionRandom(5)" >机选五注</button>-->
				<div class="tz-top-btn" onclick="gameActionRemoveCode()">清空号码</div>
        <div class="tz-true-hover" id="btnPostBet">确认投注</div>
        </div>
       </div>
        <!--确认投注-->
        
		<div class="touzhu-true" style="padding-top:0;">
		<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_1">
				<thead>
					<tr>
						<th width="10%">单号</th>
						<th width="10%">投注时间</th>
						<th width="10%">彩种</th>
						<th width="10%">玩法</th>
						<th width="15%">期号</th>
						<th width="12%">投注号码</th>
						<th width="5%">注数</th>
						<th width="5%">倍数</th>
						<th width="8%">金额</th>
						<th width="5%">模式</th>						
						<th width="10%">操作</th>
					</tr>
				</thead>
				<tbody id="order-history">';$this->display('index/inc_game_order_history.php');;echo '</tbody>
			</table>
		</div>
	</div>
</div>
<div id="znz-game" style="display:none;"></div>
</div></div></div></div>
';
?>