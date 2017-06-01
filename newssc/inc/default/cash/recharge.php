<?php
echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
<script type="text/javascript" src="/skin/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="/skin/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/skin/js/Array.ext.js"></script>
<script type="text/javascript" src="/skin/main/onload.js"></script>
<script type="text/javascript" src="/skin/main/function.js?v1.0.7"></script>
<script type="text/javascript" src="/skin/js/artDialog/artDialog.js?skin=aero"></script>
<script type="text/javascript" src="/skin/js/artDialog/plugins/iframeTools.source.js"></script>
<script type="text/javascript">
$(function(){
	$(\'form\').trigger(\'reset\');
	//$(\':radio\').click(function(){
		
		var data=$(this).data(\'bank\'),
		box=$(\'#display-dom\');
		
		//$(\'#bank-type-icon\', box).attr(\'src\', \'/\'+data.logo);
		//$(\'#bank-link\', box).attr(\'href\', data.home);
		//$(\'#bank-account\', box).val(data.account);
		//$(\'#bank-username\', box).val(data.username);
		//$(\'.example2\', box).attr(\'rel\', data.rechargeDemo);
		
		//if($.cookie(\'rechargeBank\')!=data.id) $.cookie(\'rechargeBank\', data.id, 360*24);
	//});
	
	//var bankId=$.cookie(\'rechargeBank\')||$(\':radio\').attr(\'value\');
	//$(\':radio[value=\'+bankId+\']\').click();
	
	$(\'.copy\').click(function(){
		var text=document.getElementById($(this).attr(\'for\')).value;
		if(!CopyToClipboard(text, function(){
			alert(\'复制成功\');
		}));
	});
	
	$(\'.example2\').click(function(){
		var src=\'/\'+$(this).attr(\'rel\');
		if(src) $(\'<div>\').append($(\'<img>\',{src:src,width:\'640px\',height:\'480px\'})).AlertDialog({width:630,height:500,title:\'充值演示\'});
	});
});

function checkRecharge(){
	if(!this.amount.value) throw(\'请填写充值金额\');
	//if(isNaN(amount)) throw(\'充值金额错误\');
	if(!this.amount.value.match(/^\\d+(\\.\\d{0,2})?$/)) throw(\'充值金额错误\');
	var amount=parseInt(this.amount.value),
	$this=$(\'input[name=amount]\',this),
	min=parseInt($this.attr(\'min\')),
	max=parseInt($this.attr(\'max\'));
	min1=parseInt($this.attr(\'min1\')),
	max1=parseInt($this.attr(\'max1\'));
	
	if($(\'input[name=mBankId]\').val()==2||$(\'input[name=mBankId]\').val()==3){
		if(amount<min1) throw(\'支付宝/财付通充值金额最小为\'+min1+\'元\');
		if(amount>max1) throw(\'支付宝/财付通充值金额最多限额为\'+max1+\'元\');
	}else{
		if(amount<min) throw(\'充值金额最小为\'+min+\'元\');
		if(amount>max) throw(\'充值金额最多限额为\'+max+\'元\');
	}
	
	if(!this.coinpwd.value) throw(\'请输入资金密码\');
	if(this.coinpwd.value<6) throw(\'资金密码至少6位\');
}
function toCash(err, data){
	//console.log(err);
	if(err){
		alert(err)
	}else{
		$(\':password\').val(\'\');
		$(\'input[name=amount]\').val(\'\');
		$(\'.biao-cont\').html(data);
	}
}
$(function(){
	$(\'input[name=amount]\').keypress(function(event){
		//console.log(event);
		event.keyCode=event.keyCode || event.charCode;
		return !!(
			// 数字键
			(event.keyCode>=48 && event.keyCode<=57)
			|| event.keyCode==13
			|| event.keyCode==8
			|| event.keyCode==9
			|| event.keyCode==46
		)
	});
});
</script>
<script type="text/javascript">
$(function(){
	$(\'.example2\').click(function(){
		var src=\'/\'+$(this).attr(\'rel\');
		if(src) $(\'<img>\',{src:src}).css({width:\'640px\',height:\'480px\'}).dialog({width:660,height:500,title:\'充值演示\'});
	});
	
	//$(\'.copy\').click(function(){
	//	var text=document.getElementById($(this).attr(\'for\')).value;
	//	if(!CopyToClipboard(text, function(){
	//		alert(\'复制成功\');
	//	}));
	//});
});
</script>

<!--//复制程序 flash+js-->

<script language="JavaScript">
function Alert(msg) {
	alert(msg);
}
function thisMovie(movieName) {
	 if (navigator.appName.indexOf("Microsoft") != -1) {   
		 return window[movieName];   
	 } else {   
		 return document[movieName];   
	 }   
 } 
function copyFun(ID) {
	thisMovie(ID[0]).getASVars($("#"+ID[1]).attr(\'value\'));
}
</script>
<script type="text/javascript" src="/skin/js/swfobject.js"></script>
<div class="game-left">
	<div class="biao-cont leftcont2">
	<form action="/index.php/cash/inRecharge" method="post" target="ajax" onajax="checkRecharge" name="drawform" call="toCash" dataType="html">
	';
$sql="select * from {$this->prename}bank_list b, {$this->prename}member_bank m where m.admin=1 and m.enable=1 and b.isDelete=0 and b.id=m.bankId order by b.sort";
$banks=$this->getRows($sql);
if($banks){
if($this->user['coinPassword']){
;echo '	<div class="tbbox2-w">
	<table cellpadding="0" cellspacing="0" border="0"><tr><td>
		<div class="tbbox2-top"><div class="tbx-title img02 spn14">选择充值银行</div></div>
		';
		
$set=$this->getSystemSettings();
$hcbank = array(
		'ICBC'=> '/img/banklogo/bank_icbc.gif',
		'ABC'=> '/img/banklogo/bank_abc.gif',
		'BOCSH'=> '/img/banklogo/bank_boc.gif',
		'CCB'=> '/img/banklogo/bank_ccb.gif',
		'CMB'=> '/img/banklogo/bank_cmb.gif',
		'SPDB'=> '/img/banklogo/bank_spdb.gif',
		'GDB'=> '/img/banklogo/bank_gdb.gif',
		'BOCOM'=> '/img/banklogo/bank_bcom.gif',
		'PSBC'=> '/img/banklogo/bank_post.gif',
		'CNCB'=> '/img/banklogo/bank_citic.gif',
		'CMBC'=> '/img/banklogo/bank_cmbc.gif',
		'CEB'=> '/img/banklogo/bank_ceb.gif',
		'HXB'=> '/img/banklogo/bank_hxb.gif',
		'CIB'=> '/img/banklogo/bank_cib.gif',
		'SRCB'=> '/img/banklogo/bank_shrcc.gif',
		'PAB'=> '/img/banklogo/bank_pab.gif',
		'BCCB'=> '/img/banklogo/bank_bob.gif',
		'UNIONPAY'=> '/img/banklogo/bank_icbc.gif',		
	);
if($banks) foreach($banks as $bank){
	if ($bank['id'] == 33){
		foreach($hcbank as $k=>$v){
		echo '		<div class="bankchoice">
			<label><input value="';echo $k;echo '" onclick="setBank(1);" type="radio" name="bankco"  /><span style="background:url(';echo $v;echo ') 0px 8px no-repeat" ></span></label>
		</div>
		';
		}
		echo '<input value="33" type="radio" name="mBankId" id="bank_33" style="display:none;" data-bank=\'';echo json_encode($bank);echo '\' />';
	 }else{
;		echo '		<div class="bankchoice">
			<label><input onclick="setBank(2);unselectBank()" value="';echo $bank['id'];echo '" type="radio" name="mBankId" data-bank=\'';echo json_encode($bank);echo '\' /><span style="background:url(/';echo $bank['logo'];echo ') no-repeat;" ></span></label>
		</div>
		';
	}
		};echo '	</td></tr></table>
	</div>
	<!--uid 	username 	amount 充值资金	coin 充值前用户资金	fcoin 充值前用户冻结资金	actionUid 操作用户ID	actionIP 	actionTime 	isDelete-->
	<div class="tbbox1" style="position:relative; margin:30px 0 0 0;width:540px;" id="display-dom">
    <ul class="backr backc">
      <li style="display:none;"><b class="hig">银行类型：</b><img id="bank-type-icon" class="bankimg" src="" title="" style=" margin:0 0 10px 2px;"/></li>
      <li><b>充值金额：</b><input name="amount" min="';echo $set['rechargeMin'];echo '" max="';echo $set['rechargeMax'];echo '" min1="';echo $set['rechargeMin1'];echo '" max1="';echo $set['rechargeMax1'];echo '" class="input_text" value="" />
      	<span style="float:left;width:540px;">*请一次性充值';if($bank['bankId']==2 ||$bank['bankId']==3){;echo '';echo $set['rechargeMin1'];echo '';}else{;echo '';echo $set['rechargeMin'];echo '';};echo '元以上金额！</span></li>
      <li><b>资金密码：</b><input name="coinpwd" type="password" class="input_text" value="" /></li>
      <li><input type="submit" class="buttonabc" value="下一步"/></li>
    </ul>
	</div>

	';}else{;echo '	<div class="tishi" style="font-size:20px;line-height:400px;font-size:14px; text-align:center;">尚未设置您的资金管理密码！&nbsp;&nbsp;<a onClick="art.dialog.open(\'/index.php/safe/passwd\', {id: \'testID3\',lock: true,title: \'密码管理\',width:542, height:428});" style="color:green; text-decoration:none;">马上设置>></a></div>
	';};echo '	';}else{;echo '	<div class="tishi" style="font-size:20px;margin-top:170px; text-align:center;">暂停充值</div>
	';};echo '	</form>
</div></div>';
?>
<script>
$(function(){ setBank(1);});
		function setBank(id){
			if (id==1){
				document.drawform.target="_blank";
				document.getElementById('bank_33').checked = true;
			}else{
				document.drawform.target="ajax";
				document.getElementById('bank_33').checked = false;
			}
		}
		function unselectBank(){
			
			document.drawform.target="_self";
				var oForm = document.drawform;
				for(var i=0; i<oForm.bankco.length;i++){
					oForm.bankco[i].checked = false;
				}
		}
</script>
<?php 
echo '
</body>
</html>
';
?>