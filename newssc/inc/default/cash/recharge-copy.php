<?php
if ($args[0]['bankco']!=''){
	header("Location:/ecpss/pay.php?rechargeId=".$args[0]['rechargeId']."&amount=".$args[0]['amount']."&bankco=".$args[0]['bankco']);	
}
echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
<!--//复制程序 flash+js------end-->

';
$mBankId=$args[0]['mBankId'];
$sql="select mb.*, b.name bankName, b.logo bankLogo, b.home bankHome from {$this->prename}member_bank mb, {$this->prename}bank_list b where mb.id=$mBankId and b.isDelete=0 and mb.bankId=b.id";
$memberBank=$this->getRow($sql);
;echo '<!--左边栏body-->
	<div class="tbbox1" style="position:relative; margin:20px 0 0 0;width:540px;" id="display-dom">
		<div class="heng heng-w" style="margin-bottom:12px;">
			<div class="aq-txt aq-txt2">银行类型：</div>
			<img id="bank-type-icon" class="bankimg" src="/';echo $memberBank['bankLogo'];echo '" title="';echo $memberBank['bankName'];echo '" />
			<a id="bank-link" target="_blank" href="';echo $memberBank['bankHome'];echo '" class="spn11 enterlink">进入';echo $memberBank['bankName'];echo '网站>></a>
		</div>
		<div class="heng heng-w">
			<div class="aq-txt">银行账号：</div><input id="bank-account" class="t-c" readonly value="';echo $memberBank["account"];echo '" />
			<div class="copy" for="bank-account">
				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="62" height="23" id="copy-account" align="top">
					<param name="allowScriptAccess" value="always" />
					<param name="movie" value="/skin/js/copy.swf?movieID=copy-account&inputID=bank-account" />
					<param name="quality" value="high" />
					<param name="wmode" value="transparent">
					<param name="bgcolor" value="#ffffff" />
					<param name="scale" value="noscale" /><!-- FLASH原始像素显示-->
					<embed src="/skin/js/copy.swf?movieID=copy-account&inputID=bank-account" width="62" height="23" name="copy-account" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" />
				</object> 
			</div>
		</div>
		<div class="heng heng-w">
			<div class="aq-txt">账户名：</div><input id="bank-username" class="t-c" readonly value="';echo $memberBank["username"];echo '" />
			<div class="btn-a img01 copy" for="bank-username">
				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="62" height="23" id="copy-bankuser" align="top">
					<param name="allowScriptAccess" value="always" />
					<param name="movie" value="/skin/js/copy.swf?movieID=copy-bankuser&inputID=bank-username" />
					<param name="quality" value="high" />
					<param name="wmode" value="transparent">
					<param name="bgcolor" value="#ffffff" />
					<param name="scale" value="noscale" /><!-- FLASH原始像素显示-->
					<embed src="/skin/js/copy.swf?movieID=copy-bankuser&inputID=bank-username" width="62" height="23" name="copy-bankuser" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" />
				</object> 
			</div>
		</div>
		<div class="heng heng-w">
			<div class="aq-txt">充值金额：</div><input id="recharg-amount" class="t-c" readonly value="';echo $args[0]['amount'];echo '" />
			<div class="btn-a img01 copy" for="recharg-amount">
				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="62" height="23" id="copy-recharg" align="top">
					<param name="allowScriptAccess" value="always" />
					<param name="movie" value="/skin/js/copy.swf?movieID=copy-recharg&inputID=recharg-amount" />
					<param name="quality" value="high" />
					<param name="wmode" value="transparent">
					<param name="bgcolor" value="#ffffff" />
					<param name="scale" value="noscale" /><!-- FLASH原始像素显示-->
					<embed src="/skin/js/copy.swf?movieID=copy-recharg&inputID=recharg-amount" width="62" height="23" name="copy-recharg" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" />
				</object> 
			</div>
			<div class="spn12 paystate">*网银充值金额必须与网站填写金额一致方能到账！</div>
		</div>
		<div class="heng heng-w">
			<div class="aq-txt">充值编号：</div><input id="username" class="t-c" readonly value="';echo $args[0]['rechargeId'];echo '" />
			<div class="btn-a img01 copy" for="username">
				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="62" height="23" id="copy-username" align="top">
					<param name="allowScriptAccess" value="always" />
					<param name="movie" value="/skin/js/copy.swf?movieID=copy-username&inputID=username" />
					<param name="quality" value="high" />
					<param name="wmode" value="transparent">
					<param name="bgcolor" value="#ffffff" />
					<param name="scale" value="noscale" /><!-- FLASH原始像素显示-->
					<embed src="/skin/js/copy.swf?movieID=copy-username&inputID=username" width="62" height="23" name="copy-username" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" />
				</object> 
			</div>
			<div class="spn12 paystate">*每个充值编号仅用于一笔充值，重复使用将不能到账！</div>
		</div>
		<div class="heng heng-w">
        ';if($memberBank["rechargeDemo"]){;echo '<div class="example">充值图示：<div class="example2" rel="';echo $memberBank["rechargeDemo"];echo '">查看</div></div>';};echo '		</div>
    
    <div class="tbbox1 payexplain">
        <div class="a-top"><div class="a-title spn12">充值说明：</div></div>
        <p>1.每次"充值编号"均不相同,务必将"充值编号"正确复制填写到银行汇款页面的"附言"栏目中。<br />
        2.帐号不固定，转帐前请仔细核对该帐号。<br />  
        3.充值金额与网友转账金额不符，充值将无法到账。<br />
        4.转账后如超过5分钟未到账，请联系客服，告知您的充值编号、充值金额、银行用户姓名。</p>
    </div>
    <!--左边栏body end-->';
?>