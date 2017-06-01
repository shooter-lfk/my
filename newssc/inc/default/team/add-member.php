<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'增加成员－增加成员');;echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
<style>
.table_3 td {background:none;}
.table_3 label {height:25px;line-height:25px;float:left;width:6em;display:inline;overflow:hidden;}
.table_3 label input {margin-top:5px;clear:both;}
</style>
<script type="text/javascript">
function khao(fanDian, bFanDian){
	$(\'input[name=fanDian]\').val(fanDian);
	$(\'input[name=fanDianBdw]\').val(bFanDian);
	location=\'#register\';
}
</script>
</head>
<body>
<form action="/index.php/team/insertMember" method="post" target="ajax" onajax="teamBeforeAddMember" call="teamAddMember"><a name="register"></a>
<div style="float:right;width:180px;display:block;margin:0;padding:10px 0 0 10px;background:#fff;height:323px;line-height:22px;"><b style="display:block;">奖金返点快速设置</b>
';
$sql="select s.*, (select count(*) from {$this->prename}members m where m.parentId={$this->user['uid']} and m.fanDian=s.fanDian) registerUserCount from {$this->prename}params_fandianset s where s.fanDian<{$this->user['fanDian']}";
if($data=$this->getRows($sql)){;echo '		';foreach($data as $var){if($var['userCount']-$var['registerUserCount']>0 or true){;echo '			<a href="javascript:;" onclick="khao(';echo $var['fanDian'];echo ', ';echo $var['bFanDian'];echo ')"><span style="display:block;width:180px;">';echo $var['fanDian']*20+1700;echo ' ';echo $var['fanDian'];echo '% 限额：';echo $var['registerUserCount'];echo '/';echo $var['userCount'];echo '人</span></a>
		';}else{;echo '			<span style="display:block;width:180px;">';echo $var['fanDian']*20+1700;echo ' ';echo $var['fanDian'];echo '% 名额已用完</span>
		';}}};echo '</div>
<div class="tbbox1" style="margin:0;padding:20px 0 30px 0;width:300px;float:right;" id="display-dom">
	<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_3">
				<tr><th width="96">账号类型：</th><td><label><input type="radio" name="type" value="1" title="代理" checked="checked" />代理</label><label><input name="type" type="radio" value="0" title="会员" />会员</label></td></tr>
				<tr><th>用户名：</th><td><input class="input_text" name="username" type="text" value="" onBlur="this.value=ignoreSpaces(this.value);" /></td></tr>
				<tr><th>密码：</th><td><input class="input_text" name="password" type="password" value="" /></td></tr>
				<tr><th>确认密码：</th><td><input class="input_text" id="cpasswd" type="password" value="" /></td></tr>
				<tr><th>联系QQ：</th><td><input class="input_text" name="qq" type="text" value="" /></td></tr>
				<!--tr><th>人数配额：</th><td><input class="input_text" name="subCount" class="input_text" value="" /></td></tr-->
				<tr><th>返点设置：</th><td><input class="input_text" name="fanDian" type="text" max="';echo $this->user['fanDian'];echo '" value="';echo $this->user['fanDian']-$this->settings['fanDianDiff'];echo '" fanDianDiff=';echo $this->settings['fanDianDiff'];echo ' style="width:50px" /> 范围：0-';echo $this->user['fanDian']-$this->settings['fanDianDiff'];echo '</td></tr>
				<tr><th>不定位返点：</th><td><input class="input_text" name="fanDianBdw" type="text" max="';echo $this->user['fanDianBdw'];echo '" value="';echo $this->user['fanDian']-$this->settings['fanDianDiff']-7.5;echo '" style="width:50px"/> 范围：0-';echo $this->user['fanDian']-$this->settings['fanDianDiff']-7.5;echo '</td></tr>
				<tr><th></th><td><input type="submit" class="buttonabc addbtn" value="增加成员"/></td></tr>
	</table>
</div>
</form>
</body>
</html>
'
?>