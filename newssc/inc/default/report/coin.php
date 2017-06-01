<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'帐变列表');;echo '<script type="text/javascript">
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

	$(\'.chazhao\').click(function(){
		$(this).closest(\'form\').submit();
	});

	$(\'.bottompage a[href]\').live(\'click\', function(){
		$(\'.biao-cont\').load($(this).attr(\'href\'));
		return false;
	});
});
function searchCoinLog(err, data){
	if(err){
		alert(err);
	}else{
		$(\'.biao-cont\').html(data);
	}
}
</script>
</head>
<body>
<div class="pright" style="width:720px;min-height:450px;padding:0;">
	<div class="main_top">
	<div class="dtime ';echo $this->userType;echo '" style="width:625px;">
		<form action="/index.php/report/coinlog/';echo $this->type;echo '" dataType="html" target="ajax" call="searchCoinLog">
			<div class="chazhao but_sum">查询</div>
			<div class="input inputw"><input height="20" value="用户名" onblur="if(this.value==\'\'){this.value=\'用户名\'}" onfocus="if(this.value==\'用户名\'){this.value=\'\'}" name="username"/></div>
			<select name="userType" style="width:80px;"><!-- <option value="0">所有人</option> --><option value="1" selected>我自己</option><option value="2">直属下线</option><!-- <option value="3">所有下线</option> --></select>
			<select name="liqType" style="width:162px;">
				<option value="">所有帐变类型</option>
				<option value="1">充值</option>
				<option value="2">返点</option><!--3,分红-->
				<!--<option value="4">抽水金额</option>
				<option value="5">停止追号</option>-->
				<option value="6">中奖金额</option>
				<option value="7">撤单</option>
				<option value="8">提现失败返回冻结金额</option>
				<option value="9">上级充值</option>
				<!--<option value="10">解除抢庄冻结金额</option>
				<option value="11">收单金额</option>-->
				<option value="50">签到赠送</option>
				<option value="51">首次绑定工行卡赠送</option>
				<option value="52">充值佣金</option>
				<option value="53">消费佣金</option>
				<!--<option value="100">抢庄冻结金额</option>
				<option value="101">投注冻结金额</option>
				<option value="102">追号投注</option>
				<option value="103">抢庄返点金额</option>
				<option value="104">抢庄抽水金额</option>
				<option value="105">抢庄赔付金额</option>-->
				<option value="106">提现冻结</option>
				<option value="107">提现成功扣除冻结金额</option>
				<option value="108">开奖扣除冻结金额</option>
			</select>
			<div class="input"><input class="fqr-in" height="20" name="toTime" value="';echo date('Y-m-d',strtotime('+1 day'));echo '" type="date"/></div>
			<div class="input"><input class="fqr-in" height="20" name="fromTime" value="';echo date('Y-m-d');echo '" type="date"/></div>
			<div style="display:none;"><input type="submit" value=""/></div>
		</form>
	</div>
	<span>帐变报表</span>
	</div>
		<div class="game-left" style="width:720px;padding:0;">
			<div class="biao-cont">
				<!--下注列表-->
				';
$_REQUEST['userType']=1;
$this->display('report/coin-log.php');
;echo '				<!--下注列表 end -->
			</div>
		</div>
</div>
</body>
</html>
';
?>