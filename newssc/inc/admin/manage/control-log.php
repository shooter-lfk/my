<?php
echo '<script type="text/javascript">
$(function(){
	$(\'.tabs_involved input[name=username]\')
	.focus(function(){
		if(this.value==\'管理员\') this.value=\'\';
	})
	.blur(function(){
		if(this.value==\'\') this.value=\'管理员\';
	})
	.keypress(function(e){
		if(e.keyCode==13) $(this).closest(\'form\').submit();
	});
	
});

function adminLogBeforeSubmit(){
	//alert(this.name);
}
function adminLogList(err, data){
	if(err){
		alert(err);
	}else{
		$(\'.tab_content\').html(data);
	}
}

</script>
<article class="module width_full">
	<header>
		<h3 class="tabs_involved">帐变明细
		<form action="/admin.php/manage/controlLogList" class="submit_link wz" target="ajax" dataType="html" onajax="adminLogBeforeSubmit" call="adminLogList">
            管理员：<input type="text" class="alt_btn" style="width:60px;" value="管理员" name="username"/>&nbsp;&nbsp;
			类型：<select style="width:100px" name="type">
					<option value="">所有类型</option>                    
                    <option value="1">提现处理</option>
                    <option value="2">充值确认</option>
                    <option value="3">管理员充值</option>
                    <option value="4">增加用户</option>
                    <option value="5">修改用户</option>
                    <option value="6">删除用户</option>
                    <option value="7">添加管理员</option>
                    <option value="8">修改管理员密码</option>
                    <option value="9">删除管理员</option>
                    <option value="10">修改系统设置</option>
                    <option value="11">银行设置</option>
                    <option value="12">彩种设置</option>
                    <option value="13">玩法设置</option>
                    <option value="14">等级设置修改</option>
                    <option value="15">兑换订单处理</option>
                    <option value="16">兑换商品操作</option>
                    <option value="17">手动开奖</option>
				</select>&nbsp;&nbsp;
			时间：从<input type="date" class="alt_btn" name="fromTime" value="';echo date("Y-m-d",$this->time);echo '"/> 到 <input type="date" class="alt_btn" name="toTime"/>&nbsp;&nbsp;
			<input type="submit" value="查找" class="alt_btn">
			<input type="reset" value="重置条件">
		</form>
		</h3>
	</header><!--id 	uid 	username 	type 操作类型	actionTime 	actionIP 	action 操作描述	extfield0 	extfield1-->
    
    <div class="tab_content">
    ';$this->display("manage/control-log-list.php") ;echo '    </div>
    
</article>';
?>