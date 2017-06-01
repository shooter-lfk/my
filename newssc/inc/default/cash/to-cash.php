<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'提现');;echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
<script type="text/javascript">
function beforeToCash(){
	if(!this.amount.value) throw(\'请填写提现金额\');
	if(!this.amount.value.match(/^[0-9]*[1-9][0-9]*$/)) throw(\'提现金额错误\');
	var amount=parseInt(this.amount.value);
	if($(\'input[name=bankId]\').val()==2||$(\'input[name=bankId]\').val()==3){
		if(amount<parseFloat(';echo json_encode($this->settings['cashMin1']);echo ')) throw(\'支付宝/财付通提现最小限额为';echo $this->settings['cashMin1'];echo '元\');
		if(amount>parseFloat(';echo json_encode($this->settings['cashMax1']);echo ')) throw(\'支付宝/财付通提现最大限额为';echo $this->settings['cashMax1'];echo '元\');
	}else{
		if(amount<parseFloat(';echo json_encode($this->settings['cashMin']);echo ')) throw(\'提现最小限额为';echo $this->settings['cashMin'];echo '元\');
		if(amount>parseFloat(';echo json_encode($this->settings['cashMax']);echo ')) throw(\'提现最大限额为';echo $this->settings['cashMax'];echo '元\');
	}
	if(!this.coinpwd.value) throw(\'请输入资金密码\');
	if(this.coinpwd.value<6) throw(\'资金密码至少6位\');
}

function toCash(err, data){
	if(err){
		AlertDialog(err)
	}else{
		$(\':password\').val(\'\');
		$(\'input[name=amount]\').val(\'\');
		AlertDialog(data);
	}
}
$(function(){
	$(\'input[name=amount]\').keypress(function(event){
		event.keyCode=event.keyCode||event.charCode;
		
		return !!(
			// 数字键
			(event.keyCode>=48 && event.keyCode<=57)
			|| event.keyCode==13
			|| event.keyCode==8
			|| event.keyCode==46
			|| event.keyCode==9
		)
	});
	
	//var form=$(\'form\')[0];
	//form.account.value=\'\';
	//form.username.value=\'\';
});
</script>
</head>
';
$bank=$this->getRow("select m.*,b.logo logo, b.name bankName from {$this->prename}member_bank m, {$this->prename}bank_list b where m.bankId=b.id and b.isDelete=0 and m.uid=? limit 1",$this->user['uid']);
;echo '<body>
';
if($bank['bankId']){
;echo '<div class="tbbox1" style="position:relative">
<form action="/index.php/cash/ajaxToCash" method="post" target="ajax" datatype="json" onajax="beforeToCash" call="toCash"><input name="account" style="display:none" readonly value="';echo $bank['account'];echo '" /><input name="username" style="display:none" class="input_text" readonly value="';echo $bank['username'];echo '" />
    <ul class="backr">
      <li><b class="hig">提现帐号：</b><div class="bank"><img class="bankimg" style="position:absolute; z-index:0;" src="/';echo $bank['logo'];echo '" title="';echo $bank['bankName'];echo '"/><abbr>';echo preg_replace('/^(\w{1}).*(\w{1})$/','\1*\2',$bank['username']);echo ' | ';echo preg_replace('/^(\w{3}).*(\w{3})$/','\1***\2',$bank['account']);echo '</abbr></div></li>
      <li><b>提款金额：</b><input name="amount" class="input_text"  onKeyUp="this.value=this.value.replace(/[^\\d]/g,\'\');" onbeforepaste="clipboardData.setData(\'text\',clipboardData.getData(\'text\').replace(/[^\\d]/g,\'\'))" />
      	<span>请输入
				';if($bank['bankId']==2 ||$bank['bankId']==3){;echo '					';echo $this->settings['cashMin1'];echo '至';echo $this->settings['cashMax1'];echo '				';}else{;echo '					';echo $this->settings['cashMin'];echo '至';echo $this->settings['cashMax'];echo '				';};echo '的整数金额！</span></li>
      <li><b>资金密码：</b><input name="coinpwd" type="password" class="input_text" value="" /></li>
      <li><input type="submit" class="buttonabc" value="提交申请"/></li>
    </ul>
  	<div class="backl"><strong>资产概况</strong>
	<div class="usinfo">
    <span>登录户名：';echo $this->user['username'];echo '</span>
		<span>用户编号：';echo $this->user['uid'];echo '</span>
		<span>可用积分：';echo $this->user['score'];echo '</span>
		<span>可用资金：';echo $this->user['coin'];echo '元</span>
		<span>冻结资金：';echo $this->user['fcoin'];echo '元</span>
	</div></div>
</form>
</div>
<div class="tbbox1" style="position:relative;margin-top:-5px;">
	<div class="payexplain">
		<div class="a-top"><div class="a-title spn12">提现说明：</div></div>
		<p>1.每天最多可以申请';echo $this->getValue("select maxToCashCount from {$this->prename}member_level where level=?",$this->user['grade']);echo '次提现，最大提现金额';echo $this->settings['cashMax'];echo '元<br />2.提现10分钟内到账。(如遇高峰期，可能需要延迟到三十分钟内到帐)<br />3.每天提现时间在';echo $this->settings['cashFromTime'];echo '—';echo $this->settings['cashToTime'];echo '</p>
   </div>
	';}else{;echo '	<div class="tishi" style="font-size:20px;margin-top:120px;font-size:14px; text-align:center;">尚未设置您的银行账户！&nbsp;&nbsp;<a onClick="art.dialog.open(\'/index.php/safe/info\', {id: \'testID3\',lock: true,title: \'个人资料管理\',width:542, height:428});"  style="color:green; text-decoration:none;">马上设置>></a></div>
	';};echo '</div>
</body>
</html>
';
?>