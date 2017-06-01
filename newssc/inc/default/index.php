<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0,'首页');;echo '<script type="text/javascript" src="/skin/main/game.js"></script>
<script type="text/javascript" src="/skin/js/jquery.simplemodal.src.js"></script>
<script type="text/javascript" src="/skin/js/MessageDialogQQ.js"></script>
</head>
<body >

';$this->display('inc_header.php');;echo '';$this->display('index/inc_user.php');;echo '';$this->display('index/inc_header.php');;echo '';$this->display('index/inc_data_winner.php');;echo '</div>
</div>
    
';$this->display('index/inc_data_current.php');;echo '';$this->display('index/inc_data_history.php');;echo '';$this->display('index/inc_game.php');;echo '';$this->display('foot.php');;echo '<!--提示-->		
	<!---	<div id="message" style="z-index: 100;  position: absolute; bottom: 0px; right: 0px; overflow: hidden; width: 256px; height: 185px;>
    <div id="backimage"><img src="/skin/main/images/tips_bg.jpg" alt="温馨提示"></div>
    <div style="width: 100%; height: 25px; overflow: hidden; margin-top: -185px;" id="messageTool">
        <div style="padding: 3px 0 0 35px; width: 100px; line-height: 20px; text-align: center;overflow: hidden; position: absolute;" id="msgtitle"></div>
        <span id="message_close" style="right: 10px; width: 16px; text-align: center; cursor: pointer;position: absolute; color:#FC0;">×</span>
        <div style="clear: both;"></div>
    </div>
    <div id="message_content" style="margin: 0 5px 0 5px; padding: 10px 0 10px 5px; width: 239px;height: 135px; text-align: left; overflow: hidden; color:#e2e2e2;">
        <label id="qishu" style="color:#FC0;"></label>期：<br/>您共有<label id="tzs" style="color:#FC0;"></label>条投注数，净盈亏<label id="ykje" style="color:#FC0;"></label>元
    </div>
</div>--->
<!--提示  end-->

';
if(!$_COOKIE['pic-gg'] &&$this->settings['picGG']){
$this->display('index/pic-gg.php');
}
;echo '<script type="text/javascript">
var game={
	type:';echo json_encode($this->type);echo ',
	played:';echo json_encode($this->played);echo ',
	groupId:';echo json_encode($this->groupId);echo '},
user="';echo $this->user['username'];echo '",
aflag=';echo json_encode($this->user['admin']==1);echo ';
</script>
<!--签到有奖浮动-->
';
$liqType=50;
$sql="select count(*) from {$this->prename}coin_log where actionTime>=? and liqType=$liqType and `uid`={$this->user['uid']}";
if(!$this->getValue($sql,strtotime('00:00'))){
;echo '<!--签到有奖浮动 end-->
';
if(floatval($this->settings['huoDongSign'])){
;echo '';
}};echo '</body>
</html>'
?>