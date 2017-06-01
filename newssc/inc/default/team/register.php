<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0,'注册');;echo '<style>
html,body {padding:0px;margin:0px;font-family: arial, Helvetica, sans-serif;background:#000 url(/skin/main/images/login-bj.jpg) no-repeat center 20px; font-size:12px; height:100%; width:100%;}
* {padding:0px;margin:0px;line-height:1.5; list-style-type:none;}
img {border:none;}
div{padding:0px;margin:0px;font-size:12px;}
table,td,th,input{font-family:arial, Helvetica, sans-serif;font-size:12px}
.header{width:100%;height:158px;background:url(/skin/main/images/logo.gif) no-repeat center 0;position:absolute;z-index:99;top:16px;}
.reg {width:100%;height:400px;position:absolute;z-index:9;top:110px;}
#reg {border:1px solid #3d3d3d;width:600px;height:400px;background:#0e0e0e url(/skin/main/images/reg.jpg) no-repeat center -1px;filter:alpha(opacity=90);-moz-opacity:.90;opacity:0.9;margin:0 auto;}
#reg table {line-height:35px;margin-top:100px;}
#reg table td {color:#ababab;padding:5px;}
#reg table td.red {color: #c17700;text-align:left;}
.reginput {width:282px;height:28px;line-height:28px;text-indent:5px;border:2px solid #1c1c1c;background:#3a3a3a;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#3a3a3a\', endColorstr=\'#666666\');background:linear-gradient(top, #3a3a3a, #666666);background:-moz-linear-gradient(top, #3a3a3a, #666666);background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#3a3a3a), to(#666666));text-shadow:0 0 1px #666;-moz-box-shadow:0 0 1px #666 inset;-webkit-box-shadow:0 0 1px #666 inset;box-shadow:0 0 1px #666 inset;}
.regbtn {float:left;margin-left:93px;border:0px;width:126px;background:#0e0e0e url(/skin/main/images/regbtn.gif) no-repeat;height:40px;cursor:pointer;}
.tips{text-align:center; padding-top:200px; line-height:50px; color:#f30; font-size:20px; font-weight:bold;}
</style>
</head>
<body>
<div class="header"></div>
<div class="reg"><div id="reg" align="center">';if($args[0]){;echo '<form action="/index.php/user/registered" method="post" onajax="registerBeforSubmit" enter="true" call="registerSubmit" target="ajax"><input type="hidden" name="parentId" value="';echo $args[0];echo '" /><table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="72" align="right">用户名：</td>
        <td width="160"><input id=username class=reginput onKeyUp="value=value.replace(/[\\W]/g,\'\')" onBlur="this.value=ignoreSpaces(this.value);" maxLength=16 name=username></td>
        <td class=red><span>*</span>只能用英文和数字</td>
	</tr>
	<tr>
        <td align="right">密码：</td>
        <td><input id=password class=reginput onKeyUp="value=value.replace(/[\\W]/g,\'\')" maxLength=16 type=password  name=password></td>
        <td class=red><span>*</span>必填6-16个字符</td>
	</tr>
	<tr>
        <td align="right">密码确认：</td>
        <td><input id=cpasswd class=reginput onKeyUp="value=value.replace(/[\\W]/g,\'\')"  maxLength=16 type=password name=cpasswd></td>
        <td class=red><span>*</span>必填6-16个字符</td>
	</tr>
	<tr>
        <td align="right">QQ：</td>
        <td><input id=qq class=reginput onKeyUp="this.value=this.value.replace(/[^0123456789]/g,\'\');" onBlur="this.value=this.value.replace(/[^0123456789]/g,\'\');calculatePrice()" maxLength=20 name=qq></td>
        <td class=red><span>*</span>以便及时联系到你</td>
	</tr>
	<tr>
        <td align="right">验证码：</td>
        <td style="position:relative"><img width="72" height="24" border="0" style="margin:0;position:absolute;top:9px;right:9px;" align="absmiddle" src="/index.php/user/vcode/';echo $this->time;echo '" title="看不清楚嘛，点击切换一张图片吧" onclick="this.src=\'/index.php/user/vcode/\'+(new Date()).getTime()"/><input class="reginput" size="4" name="vcode" /></td>
        <td class=red><span>*</span></td>
	</tr>
	<tr>
        <td><div style="display:none;"><input type="submit" value=""/></div></td>
        <td colspan="2"><div class="regbtn" onclick="$(this).closest(\'form\').submit()"></div></td>
	</tr></table></form>
';}else{;echo '	<div class="tips"><sanp>无效链接，请打开完整链接！</sanp></div>
';};echo '</div>
</div>
<div class="lg-bottom">Copyright  2013 英利国际 All Rights Reserved</div>
</body>
</html>
'
?>