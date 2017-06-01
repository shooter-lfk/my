<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'礼品兑换');$good=$args[0];;echo '<script type="text/javascript">
function scoreBeforeSwapGood(){
	if(!this.address.value) throw(\'请填写邮寄地址\');
	if(!this.mobile.value) throw(\'请填写收件电话\');
	if(!this.coinpwd.value) throw(\'请填写资金密码\');
}
function scoreSwapGood(err, data){
	if(err){
		alert(err);
	}else{
		this.reset();
		alert(data);
	}
}

</script>
</head>
<body>
<div class="pright">
		<div class="game-left">
			<div class="biao-cont leftcont2" style="min-height:425px;">
				<div class="tbbox1">
				<form action="/index.php/score/swapGood" method="post" target="ajax" onajax="scoreBeforeSwapGood" call="scoreSwapGood">
					<input type="hidden" name="goodId" value="';echo $good['id'];echo '"/>
					<div class="txtcss1 spn11">此次兑换将扣除您 <span class="spn16">';echo $good['score'];echo '</span> 积分！</div>
					<div class="txtcss1">温馨提示：实物商品将在活动结束后三日内给您邮寄出！</div>
					<div class="a-top"><div class="a-title spn9">请填写您的邮寄收件信息</div></div>
					<div class="heng"><div class="aq-txt w">邮寄地址：</div><div class="t-a t-2"><input name="address" class="t-c" value="';echo $this->user['province'].$this->user['city'].$this->user['address'];echo '"/></div></div>
					<div class="heng"><div class="aq-txt w">收件电话：</div><div class="t-a t-2"><input name="mobile" class="t-c" value="';echo $this->user['mobile'];echo '"/></div></div>
					<div class="heng"><div class="aq-txt w">资金密码：</div><div class="t-a t-2"><input name="coinpwd" type="password" class="t-c" value=""/></div></div>
					<div class="heng"><input type="submit" class="btn-a img01 xiugai" value="确认兑换"/><input type="button" class="btn-a img01 xiugai" style="margin-left:10px" onclick="history.back()" value="等等再说"/></div>
				</form>
				</div>
			</div>
		</div>
</div>
</body>
</html>
'
?>