<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'游戏记录');;echo '<script type="text/javascript">
$(function(){
	$(\'.game form input[name=username]\')
	.focus(function(){
		if(this.value==\'用户名\') this.value=\'\';
	})
	.blur(function(){
		if(this.value==\'\') this.value=\'用户名\';
	})
	.keypress(function(e){
		if(e.keyCode==13) $(this).closest(\'form\').submit();
	});
	
	$(\'.game form input[name=betId]\')
	.focus(function(){
		if(this.value==\'输入单号\') this.value=\'\';
	})
	.blur(function(){
		if(this.value==\'\') this.value=\'输入单号\';
	})
	.keypress(function(e){
		if(e.keyCode==13) $(this).closest(\'form\').submit();
	});
	
	$(\'.chazhao\').click(function(){
		$(this).closest(\'form\').submit();
	});
	
	$(\'.bottompage a[href]\').live(\'click\', function(){
		$(\'.biao-cont\').load($(this).attr(\'href\'));
		return false;
	});

});
function recordSearch(err, data){
	if(err){
		alert(err);
	}else{
		$(\'.biao-cont\').html(data);
	}
}
function recodeRefresh(){
	$(\'.biao-cont\').load(
		$(\'.bottompage .pagecurrent\').attr(\'href\')
	);
}

function deleteBet(err, code){
	if(err){
		alert(err);
	}else{
		recodeRefresh();
	}
}
</script>
</head>
<body>
<div class="pright" style="width:720px;min-height:476px;padding:0;">
	<div class="main_top">
	<div class="dtime ';echo $this->userType;echo '" style="width:625px;">
		<form action="/index.php/record/searchGameRecord/';echo $this->userType;echo '" dataType="html" call="recordSearch" target="ajax">
        	<input type="hidden" value="';echo $this->type;echo '" name="type"/><input type="hidden" value="';echo $this->userType;echo '" name="userType"/>
			<div class="chazhao but_sum">查询</div>
					';if($this->userType!='zhuih'){;echo '						<select name="state" style="width:60px;height:23px;">
							<option value="0" selected>状态</option>
							<option value="1">已派奖</option>
							<option value="2">未中奖</option>
							<option value="3">未开奖</option>
							<option value="4">追号</option>
							<option value="5">撤单</option>
						</select>
					<div class="input inputw"><input height="20" value="输入单号" onblur="if(this.value==\'\'){this.value=\'输入单号\'}" onfocus="if(this.value==\'输入单号\'){this.value=\'\'}" name="betId" /></div>
						<select name="qz" style="width:60px;height:23px;display:none;">
							<option value="0" selected title="全部">抢庄</option>
							<option value="2">未抢庄</option>
							<option value="1">已抢庄</option>
						</select>

					';if($this->userType=='team'){;echo '						<select name="type" style="width:80px;height:23px;">
							<option value="0" selected>所有人</option>
							<option value="1">我自己</option>
							<option value="2">直属下线</option>
							<option value="3">所有下线</option>
						</select>
					<div class="input inputw"><input height="20" value="用户名" onblur="if(this.value==\'\'){this.value=\'用户名\'}" onfocus="if(this.value==\'用户名\'){this.value=\'\'}" name="username"/></div>
					';}};echo '			<select name="mode" style="width:50px;height:23px;display:none;">
				<option value="" selected>模式</option>
				<option value="2.00">元</option>
				<option value="0.20">角</option>
				<option value="0.02">分</option>
			</select>
			<div class="input"><input height="20" type="date" value="';echo date('Y-m-d',strtotime('+1 day'));echo '" name="toTime"/></div>
			<div class="input"><input height="20" type="date" value="';echo date('Y-m-d');echo '" name="fromTime" /></div>
		</form>
	</div>
	<span>游戏记录</span>
	</div>
		<div class="game-left" style="width:720px;padding:0;">
			<div class="biao-top">
				<div class="top2">
					<ul>
						<li ';echo $this->iff($this->type==0,'class="current"');echo '><a href="/index.php/record/search">全部彩种</a></li>
						';
if($this->types) foreach($this->types as $var){
if($var['enable']){
;echo '						<li ';echo $this->iff($this->type==$var['id'],'class="current"');echo '>
							<a href="/index.php/record/search/';echo $this->userType .'/'.$var['id'];echo '">';echo $this->iff($var['shortName'],$var['shortName'],$var['title']);echo '</a>
						</li>
						';}};echo '					</ul>
				</div>
			</div>
			<div class="biao-cont">
				<!--下注列表-->
				';$this->display('record/search-list.php');;echo '				<!--下注列表 end -->
			</div>
		</div>
</div>
</body>
</html>
';
?>