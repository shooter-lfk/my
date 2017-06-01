<?php
echo '<!doctype html>
<html>
<head>
<meta content="IE=EmulateIE8" http-equiv="X-UA-Compatible" />
<meta charset="utf-8"/>
<title>内容管理系统</title>
<link rel="stylesheet" href="/skin/admin/layout.css" type="text/css" />
<!--[if IE]>
	<link rel="stylesheet" href="/skin/admin/ie.css" type="text/css" />
	<script src="/skin/js/html5.js"></script>
<![endif]-->
<script src="/skin/js/jquery-1.7.2.min.js"></script>
<script src="/skin/admin/onload.js"></script>
<script src="/skin/admin/config.js"></script>
<script>
function checkLogin(){
	if(!this.username.value) throw(\'用户名不能为空\');
	if(!this.password.value) throw(\'密码不能为空\');
	if(!this.vcode.value) throw(\'验证码不能为空\');
}

function doLogin(err, data){
	if(err){
		//alert(err);
		alert("登录错误,请尝试删除cookie");
	}else{
		//alert(\'验证成功\');
		location=SCRIPT_NAME;
	}
}


//window.attachEvent("onload", correctPNG);
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #1b365f;
}
-->
</style>
</head>

<body>
<table width="100%" height="166" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="40" class="login-buttom-bg"></td>
  </tr>
  <tr class="login-center">
    <td valign="top"><table width="100%" height="532" border="0" cellpadding="0" cellspacing="0" class="login_bg">
      <tr>
        <td width="49%"><table width="91%" height="532" border="0" cellpadding="0" cellspacing="0" class="login_bg2">
            <tr>
              <td height="138" valign="top"><table width="89%" height="427" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="100">&nbsp;</td>
                </tr>
                <tr>
                  <!---td height="128" valign="top"><img src="/skin/admin/images/logo.png" style="float:right; margin-right:20px;"></td--->
                </tr>
              </table></td>
            </tr>
            
        </table></td>
        <td width="1%" >&nbsp;</td>
        <td width="50%" valign="bottom"><table width="100%" height="59" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="4%">&nbsp;</td>
              <td width="96%" height="38"><span class="login_txt_bt">后台管理员登陆</span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="21"><table cellSpacing="0" cellPadding="0" width="100%" border="0" height="328">
                  <tr>
                    <td height="164" colspan="2" align="middle"><form target="ajax" onajax="checkLogin" call="doLogin" action="/admin.php/user/checkLogin" method="post" >
                        <table cellSpacing="0" cellPadding="0" width="100%" border="0" height="143">
                          <tr>
                            <td width="80" height="38" class="login_hui_text"><span class="login_txt">管理员：</span></td>
                            <td height="38" colspan="2" class="login_hui_text"><input type="text" name="username" class="editbox4" value="" size="20">                            </td>
                          </tr>
                          <tr>
                            <td width="80" height="35" class="login_hui_text"><span class="login_txt">密码：</span></td>
                            <td height="35" colspan="2" class="login_hui_text"><input class="editbox4" type="password" size="20" name="password">
                              <img src="/skin/admin/images/luck.gif" width="19" height="18"> </td>
                          </tr>
                          <tr>
                            <td width="80" height="35" class="login_hui_text"><span class="login_txt">验证码：</span></td>
                            <td height="35" colspan="2" class="login_hui_text"><input class="wenbenkuang" name="vcode" type="text" maxLength="4" size="10"/>
							<img align="absmiddle" onClick="this.src=\'/admin.php/user/vcode/\'+(new Date()).getTime()" title="看不清楚，换一张图片" src="/admin.php/user/vcode/';echo $this->time;echo '" width="72" height="24"/>
                              </td>
                          </tr>
                          <tr>
                            <td height="35" >&nbsp;</td>
                            <td width="20%" height="35" class="login_hui_text"><input type="submit" class="button" value="登 陆"> </td>
                            <td width="67%" class="login_hui_text">&nbsp;</td>
                          </tr>
                        </table>
                        <br>
                    </form></td>
                  </tr>
                  <tr>
                    <td width="433" height="164" align="right" valign="bottom"><img src="/skin/admin/images/login-wel.gif" width="242" height="138"></td>
                    <td width="57" align="right" valign="bottom">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
          </table>
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="40" align="center" class="login-buttom-bg">Copyright &copy; 内容管理系统</td>
  </tr>
</table>
</body>
</html>
';
?>