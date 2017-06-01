<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'充值记录');;echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
<script type="text/javascript">
$(function(){
	$(\'.search select\').change(function(){
		//this.form.submit();
		$(this).closest(\'form\').submit();
	});
	$(\'.chazhao\').click(function(){
		$(this).closest(\'form\').submit();
	});
	
	$(\'.search input[name=username]\')
	.focus(function(){
		if(this.value==\'用户名\') this.value=\'\';
	})
	.blur(function(){
		if(this.value==\'\') this.value=\'用户名\';
	})
	.keypress(function(e){
		if(e.keyCode==13) $(this).closest(\'form\').submit();
	});
	
	$(\'.bottompage a[href], .caozuo\').live(\'click\', function(){
		$(\'.biao-cont\').load($(this).attr(\'href\'));
		return false;
	});
	
	$(\'.sure[id]\').click(function(){
		var $this=$(this),
		cashId=$this.attr(\'id\'),
		
		call=function(err, data){
			if(err){
				alert(err);
			}else{
				this.parent().text(\'已到帐\');
			}
		}
		
		$.ajax(\'/index.php/cash/toCashSure/\'+cashId,{
			dataType:\'json\',
			
			error:function(xhr, textStatus, errThrow){
				call.call($this, errThrow||textStatus);
			},
			
			success:function(data, textStatus, xhr){
				var errorMessage=xhr.getResponseHeader(\'X-Error-Message\');
				if(errorMessage){
					call.call($this, decodeURIComponent(errorMessage), data);
				}else{
					call.call($this, null, data);
				}
			}
		});
	});
});
function teamBeforeSearchMember(){}
function teamSearchMember(err, data){
	if(err){
		alert(err);
	}else{
		$(\'.biao-cont\').html(data);
	}
}
</script>
</head>
<body>
<div class="pright" style="width:720px;min-height:476px;padding:0;">
 <div class="main_top">
	<div class="dtime" style="width:270px;">
		<form action="/index.php/team/searchMember" dataType="html" method="get" onajax="teamBeforeSearchMember" call="teamSearchMember">
			<div class="but_sum" onclick="$(this).closest(\'form\').submit()">查询</div>
			<select name="type" style="margin:0 5px 0 0;width:90px; height:"><option value="0">所有人</option><option value="1" selected>我自己</option><option value="2">直属下线</option><option value="3">所有下线</option></select>
			<div class="input"><input height="20" name="username" value="用户名" onblur="if(this.value==\'\'){this.value=\'用户名\'}" onfocus="if(this.value==\'用户名\'){this.value=\'\'}"  style="width:100px;"/></div>
			<div style="display:none;"><input type="submit" value=""/></div>
		</form>
	</div>
	<span>团队成员列表</span>
 </div>
 <div class="game-left" style="width:720px;padding:0;">
	<div class="biao-cont">
		';$_GET['type']=1;$this->display('team/member-search-list.php');;echo '	</div>
 </div>
</div>
</body>
</html>
';
?>