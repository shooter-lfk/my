<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'团队金额－成员提现记录');;echo '<script type="text/javascript">
$(function(){
	$(\'.chazhao\').click(function(){
		$(this).closest(\'form\').submit();
	});
	
	$(\'.search input[name=username]\')
	.focus(function(){
		//console.log(this.value);
		if(this.value==\'用户名\') this.value=\'\';
	})
	.blur(function(){
		if(this.value==\'\') this.value=\'用户名\';
	})
	.keypress(function(e){
		if(e.keyCode==13) $(this).closest(\'form\').submit();
	});
	
	$(\'.bottompage a[href]\').live(\'click\', function(){
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
function teamBeforeSearchCashRecord(){}
function teamSearchCashRecord(err, data){
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
	<div class="dtime ';echo $this->userType;echo '" style="width:500px;">
		<form action="/index.php/team/searchCashRecord" target="ajax" onajax="teamBeforeSearchCashRecord" call="teamSearchCashRecord" dataType="html">
			<div class="chazhao but_sum">查询</div>
			<div class="input"><input height="20" name="toTime" value="';echo date('Y-m-d',strtotime('+1 day'));echo '" type="date"/></div>
			<div class="input"><input height="20" name="fromTime" value="';echo date('Y-m-d');echo '" type="date"/></div>
			<div style="display:none;"><input type="submit" value=""/></div>
		</form>
	</div>
	<span>团队成员提现记录</span>
</div>
 <div class="game-left" style="width:720px;padding:0;">
	<div class="biao-cont">
	';
$this->display('team/cash-record-list.php');
;echo '	</div>
</div>
</div>
</body>
</html>
';
?>