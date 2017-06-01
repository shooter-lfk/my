<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'总结算查询');;echo '<script type="text/javascript">
$(function(){
	$(\'.game form input[name=username]\')
	.focus(function(){
		if(this.value==\'用户名\') this.value=\'\';
	})
	.blur(function(){
		if(this.value==\'\') this.value=\'用户名\';
	})
	.keypress(function(e){
		if(e.keyCode==13) $(this).closest(\'form\').submit();
	});

	$(\'.chazhao\').click(function(){
		$(this).closest(\'form\').submit();
	});

	$(\'.bottompage a[href]\').live(\'click\', function(){
		$(\'.biao-cont\').load($(this).attr(\'href\'));
		return false;
	});
});
function searchData(err, data){
	if(err){
		alert(err);
	}else{
		$(\'.biao-cont\').html(data);
	}
}
</script>
</head>
<body>
<div class="pright" style="width:720px;min-height:450px;padding:0;">
 <div class="main_top">
	<div class="dtime ';echo $this->userType;echo '" style="width:625px;">
		<form action="/index.php/report/countSearch" target="ajax" call="searchData" dataType="html">
			<div class="chazhao but_sum">查询</div>
			<div class="input"><input height="20" name="username" value="用户名" onblur="if(this.value==\'\'){this.value=\'用户名\'}" onfocus="if(this.value==\'用户名\'){this.value=\'\'}"  style="width:100px;"/></div>
			<select name="userType" style="width:80px;height:24px;"><option value="1" selected>我自己</option><option value="2">直属下线</option><option value="3">所有下线</option></select>
			<div class="input"><input height="20" name="toTime" value="';echo date('Y-m-d');echo '" type="date"/></div>
			<div class="input"><input height="20" name="fromTime" value="';echo date('Y-m-d',strtotime('-1 day'));echo '" type="date"/></div>
			<div style="display:none;"><input type="submit" value=""/></div>
		</form>
	</div>
	<span>结算报表</span>
 </div>
	<div class="game-left" style="width:720px;padding:0;">
		<div class="biao-cont report-znz-cont">
			';$this->display('report/count-list.php');;echo '		</div>
			
	</div>
</div>
</body>
</html>
';
?>