<?php
echo '<div class="game mt10">
<div class="game-left">
<div id="bet-game">
	<div class="game-btn"><div class="znzbtn"><a href="#" class="cai-bj" id="switch-znz-bet"  data-status="';echo $this->settings['switchMaster'];echo '"  title="庄内庄"  style="float:right; display:block; cursor:pointer; color:#000; margin:5px; background:#ffdf1b; border:#feef91 solid 1px; border-bottom:#ceb102 solid 1px; border-right:#ceb102 solid 1px; line-height:18px; text-decoration:none; text-align:center; width:80px;"> 庄内庄 </a></div>
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
	<div class="game-cont">
<div class="game-btn2">
		';$this->display('index/inc_game_played.php');;echo '<div class="spaceline"></div>
		<div class="num-table" style="height:auto;" id="game-dom">
			<div class="fandian">
				<div class="fandian-k">
					<span class="spn8">奖金/返点：</span>
                    <div class="danwei">
					<span class="spn8">模式：</span>
									<label>元<input type="radio" value="2.00" data-max-fan-dian="';echo $this->settings['betModeMaxFanDian0'];echo '" name="danwei" ';echo $this->iff($mode=='2.00','checked');echo ' /></label>
					<label>角<input type="radio" value="0.20" data-max-fan-dian="';echo $this->settings['betModeMaxFanDian1'];echo '" name="danwei" ';echo $this->iff($mode=='0.20','checked');echo ' /></label>
					<label>分<input type="radio" value="0.02" data-max-fan-dian="';echo $this->settings['betModeMaxFanDian2'];echo '" name="danwei" ';echo $this->iff($mode=='0.02','checked');echo ' /></label>
				</div>

					<div class="fandian-box">
						<input type="button" class="min" value="" step="-0.1"/>
						<div id="slider" class="slider" value="';echo $this->ifs($_COOKIE['fanDian'],0);echo '" data-bet-count="';echo $this->settings['betMaxCount'];echo '" data-bet-zj-amount="';echo $this->settings['betMaxZjAmount'];echo '" max="';echo $this->user['fanDian'];echo '" game-fan-dian="';echo $this->settings['fanDianMax'];echo '" fan-dian="';echo $this->user['fanDian'];echo '" game-fan-dian-bdw="';echo $this->settings['fanDianBdwMax'];echo '" fan-dian-bdw="';echo $this->user['fanDianBdw'];echo '" min="0" step="0.1" slideCallBack="gameSetFanDian"></div>
						<input type="button" class="max" value="" step="0.1"/>
					</div>
					<span id="fandian-value">';echo $maxPl;echo '/0%</span>
				</div>
				  <div class="hacker"></div>
                  <div class="san">
				<div class="beishu"><span class="spn8">倍数：</span><input id="beishu" value="';echo $this->ifs($_COOKIE['beishu'],1);echo '"/></div>
				<div class="btn-preserve img01" onclick="setBeiShuCookie(\'#beishu\')"></div>
			</div>
</div>
<div class="touzhu"><div class="prompt" id="game-tip-dom"><!--提示：必须选满三位数再投注！--></div>
			<!--<select size="7" class="touzhu-cont" id="select-code" ></select>-->
			<div class="touzhu-cont">
				<table width="100%">
					
				</table>
			</div>
			<div class="touzhu-bottom">
            
				<div class="tz-tongji">总投注数：<span class="spn10" id="all-count">0</span>&nbsp;注&nbsp;&nbsp;&nbsp;&nbsp;购买金额：<span class="spn10" id="all-amount">0.00</span>&nbsp;元</div>
				<div class="tz-buytype">
					<label><input type="checkbox" name="qzEnable" value="1" checked="checked" />庄内庄</label>
					<!-- <input type="checkbox" name="buy_type" /><label for="type-hm">合买</label> -->
				<label><input type="checkbox" name="zhuiHao" value="1" />追号</label>
				</div>
				
			</div>
		</div>
		
		 <!--按钮区-->
        <div class="btnarea">
        <div class="tztj-btn"><div class="tztj-hover" onclick="gameActionAddCode()"></div></div>
        <!--<button class="tz-top-btn img02" onclick="gameActionRandom(1)">机选一注</button>
				<button class="tz-top-btn img02" onclick="gameActionRandom(5)" >机选五注</button>-->
				<button class="tz-top-btn" onclick="gameActionRemoveCode()"></button>
                <div class="tz-true-btn"><div class="tz-true-hover" id="btnPostBet"></div></div>
        </div>
       </div>


	 <!--确认投注-->
        
          <div class="hacker"></div>
		<div class="touzhu-true">
			<table width="100%">
				<thead>
					<tr>
						<td width="10%">单号</td>
						<td width="10%">投注时间</td>
						<td width="10%">彩种</td>
						<td width="10%">玩法</td>
						<td width="15%">期号</td>
						<td width="12%">投注号码</td>
						<td width="5%">注数</td>
						<td width="5%">倍数</td>
						<td width="8%">金额</td>
						<td width="5%">模式</td>						
						<td width="10%">操作</td>
					</tr>
				</thead>
				<tbody id="order-history">';$this->display('index/inc_game_order_history.php');;echo '</tbody>
			</table>
		</div>
	</div>
</div>
<div id="znz-game" style="display:none;"></div>
</div>		<!--游戏body  end-->
       <div class="hacker"></div> 
    </div>
    </div>
	
	<div class="hacker"></div>
 </div>
   <div class="hacker"></div>
</div>
</div>
';
?>