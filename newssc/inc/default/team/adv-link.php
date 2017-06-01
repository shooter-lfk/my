<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'团队推广链接');;echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
</head>

<!--//复制程序 flash+js-->
<script type="text/javascript" src="/skin/js/swfobject.js"></script>
<script language="JavaScript">
function Alert(msg) {
	AlertDialogyes(\'复制成功！\');
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
<!--//复制程序 flash+js------end-->

<body>
';
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/classes/Xxtea.class';
$key=Xxtea::encrypt($args[0],$args[1]);
$key=base64_encode($key);
$key=str_replace(array('+','/','='),array('-','*',''),$key);
;echo '<div class="tbbox1" style="position:relative; margin:30px 0 0 0;width:540px;" id="display-dom">
    <ul class="backr backc">
      <li><b>注册推广链接：</b><input class="input_text" style="width:315px;height:21px;line-height:21px;font-size:12px;" id="adv-url" readonly="readonly" value="http://';echo $_SERVER['HTTP_HOST'];echo '/index.php/user/register/';echo $key;echo '" /><div class="copy1">
                <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="62" height="23" id="copy-advlink" align="top">
                	<param name="allowScriptAccess" value="always" />
                	<param name="movie" value="/skin/js/copy.swf?movieID=copy-advlink&inputID=adv-url" />
                	<param name="quality" value="high" />
                	<param name="bgcolor" value="#ffffff" />
                	<param name="scale" value="noscale" /><!-- FLASH原始像素显示-->
                	<embed src="/skin/js/copy.swf?movieID=copy-advlink&inputID=adv-url" width="62" height="23" name="copy-advlink" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
                </object>
              </div></li>
      <li class="sm spn12" style=" margin-left:10px;color:#f90;">说明：将推广链接复制发布到网络上，通过推广链接注册的会员将成为您的下级会员。</li>
    </ul>
</div>
</body>
</html>
';
?>