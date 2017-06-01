<?php
echo '<script type="text/javascript">
$(function(){
	$(\'.tabs_involved input[name=username]\')
	.focus(function(){
		if(this.value==\'用户名\') this.value=\'\';
	})
	.blur(function(){
		if(this.value==\'\') this.value=\'用户名\';
	})
	.keypress(function(e){
		if(e.keyCode==13) $(this).closest(\'form\').submit();
	});
	
});

function cashBeforeSubmit(){
	//alert(this.name);
}
function cashLogList(err, data){
	if(err){
		alert(err);
	}else{
		$(\'.tab_content\').html(data);
	}
}

function cashFalse(){
	$(\'.cashFalseSM\').css(\'display\',\'block\');
}
function cashTrue(){
	$(\'.cashFalseSM\').css(\'display\',\'none\');
	$(\'.cashFalseSM\').val()=false;
}
</script>
<article class="module width_full">
	<header><h3 class="tabs_involved">提现记录
		<form action="/admin.php/business/cashLogList" class="submit_link wz" target="ajax" dataType="html" onajax="cashBeforeSubmit" call="cashLogList">
            用户：<input type="text" class="alt_btn" style="width:60px;" value="用户名" name="username"/>&nbsp;&nbsp;
			时间：从<input type="date" class="alt_btn" name="fromTime"/> 到 <input type="date" class="alt_btn" name="toTime"/>&nbsp;&nbsp;
			<input type="submit" value="查找" class="alt_btn">
			<input type="reset" value="重置条件">
		</form>
    </h3></header>
	<div class="tab_content">
    	';$this->display("business/cash-log-list.php");;echo '    </div>
</article>';
?>