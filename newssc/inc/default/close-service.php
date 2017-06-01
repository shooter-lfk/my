<?php
echo '﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="/skin/main/css_blue.css" />
<style>
.close-bg0{width:176px;height:257px;float:right;background:url(/skin/main/images/close-bg0.png) no-repeat;}
.close-bg{ border:#FF0 solid 5px;width:680px;height:250px; margin:150px auto; background:url(/skin/main/images/close-bg.png) no-repeat;color:#fff; font-size:24px; font-family:"Microsoft YaHei","黑体";}
.cont{ padding:30px;padding-left:240px;line-height:42px;}
.cont a{color:#fff; text-decoration:none}
.cont a:hover{color:#f00;}
</style>
<!--[if IE 6]>
    <script src="/skin/js/DD_belatedPNG.js" type="text/javascript"></script>
    <script type="text/javascript">

    jQuery(document).ready(function() {
      jQuery(\'div.pricebox h3\').unbind(\'click\');
      jQuery(\'#header\').removeClass(\'sprite\');
      DD_belatedPNG.fix(\'.close-bj0,.close-bj,.logo\');
    });
    
    </script>

<![endif]-->
<title>';echo $this->settings['webName'];echo '</title>
</head>
<body>
<div>
    <!--<div class="logo"></div>
    <div class="close-bg0"></div>-->
    <div class="close-bg">
		<div class="cont">';echo $this->settings['webCloseServiceResult'];echo '</div>
    </div>
</div>
</body>
</html>';
?>