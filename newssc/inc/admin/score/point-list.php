<?php

if($_REQUEST['username']&&$_REQUEST['username']!="用户名"){
$userWhere="and u.username like '%{$_REQUEST['username']}%'";
}
if($_REQUEST['type']){
if($_REQUEST['type']=='完成') $_REQUEST['type']='0';
$typeWhere="and s.state={$_REQUEST['type']}";
}
if($_REQUEST['fromTime'] &&$_REQUEST['toTime']){
$fromTime=strtotime($_REQUEST['fromTime']);
$toTime=strtotime($_REQUEST['toTime'])+24*3600;
$timeWhere="and s.swapTime between $fromTime and $toTime";
}elseif($_REQUEST['fromTime']){
$fromTime=strtotime($_REQUEST['fromTime']);
$timeWhere="and s.swapTime>=$fromTime";
}elseif($_REQUEST['toTime']){
$toTime=strtotime($_REQUEST['toTime'])+24*3600;
$timeWhere="and s.swapTime<$fromTime";
}
$sql="select s.*, g.title goodsTitle, u.username userName from {$this->prename}score_swap s, {$this->prename}score_goods g, {$this->prename}members u where s.uid=u.uid and s.goodId=g.id $userWhere $typeWhere $timeWhere order by s.id desc";
$data=$this->getPage($sql,$this->page,$this->pageSize);
;echo '
<script type="text/javascript">
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
</script>

<article class="module width_full">
    <header>
    	<h3 class="tabs_involved">兑换订单
            <div class="submit_link wz">
            	<form action="/admin.php/Score/pointList" target="ajax" call="defaultSearch" dataType="html">
                会员：<input name="username" type="text" style="width:75px;" value="用户名"/>&nbsp;&nbsp;
                时间：从 <input type="date" style="width:75px;" name="fromTime"/> 到 <input type="date" style="width:75px;" name="toTime"/>&nbsp;&nbsp;
                <select name="type" style="width:90px;">
                    <option value="">所有状态</option>
                    <option value="1">等待发货</option>
                    <option value="2">正在配送</option>
                    <option value="3">已经取消</option>
                    <option value="完成">完成</option>
                </select>&nbsp;&nbsp;
                <input type="submit" value="查找" class="alt_btn">
                <input type="reset" value="重置条件">
                </form>
            </div>
        </h3>
    </header>
    <div class="tab_content">
	<table class="tablesorter" cellspacing="0"> 
	<thead> 
		<tr> 
			<th>单号</th> 
			<th>商品</th> 
			<th>用户</th> 
			<th>数量</th> 
			<th>积分</th> 
			<th>兑换日期</th> 
			<th>状态</th> <!--（等待发货 > 正在配送 > 配送到达 > 完成/取消）-->
			<th>收件电话</th> 
			<th>邮寄地址</th> 
			<th>操作</th> 
		</tr> 
	</thead> 
	<tbody> 
		';if($data['data']) foreach($data['data'] as $var){
$state="";
$statenext="";
switch($var['state']){
case 1: 
$state="等待发货";
$statenext="【发货】";
break;
case 2:
$state="正在配送";
$statenext="【送达】";
break;
case 3:
$state="配送到达";
$statenext="【完成】";
break;
case 0:
$state="完成";
break;
default: $state='未知出错';
}
if(!$var['enable']) $state="取消:".$state;
;echo '		<tr> 
			<td>';echo $var['id'];echo '</td> 
			<td>';echo $var['goodsTitle'];echo '</td> 
			<td>';echo $var['userName'];echo '</td>
			<td>';echo $var['number'];echo '</td> 
			<td>';echo $var['score'];echo '</td> 
			<td>';echo date('Y-m-d H:i:s',$var['swapTime']);echo '</td> 
			<td><span class="state spn4 ';if($state=="完成") echo 'spn5';echo ' ';if(!$var['enable']) echo 'spn6';echo '">';echo $state;echo '</span></td> 
			<td>';echo $var['mobile'];echo '</td> 
			<td>';echo $var['address'];echo '</td> 
			<td>
            	';if($state!="完成"&&$var['enable']){;echo '<a href="/admin.php/Score/pointState/';echo $var['id'];echo '/';echo $var['state'];echo '" target="ajax" call="pointHandle" dataType="json">';echo $statenext;echo '</a> | ';};echo '                
				';if($statenext!="【完成】"&&$state!="完成"){
if($var['enable']){;echo '                <a href="/admin.php/Score/pointEnable/';echo $var['id'];echo '/';echo $var['enable'];echo '" target="ajax" call="pointHandle" dataType="json">取消</a> |
				';}else{;echo '                <a href="/admin.php/Score/pointEnable/';echo $var['id'];echo '/';echo $var['enable'];echo '" target="ajax" call="pointHandle" dataType="json">重启</a> |
                ';}
};echo '                
                <a href="/admin.php/Score/pointDel/';echo $var['id'];echo '" target="ajax" call="pointHandle" dataType="json">删除</a>
            </td> 
		</tr>
		';}else{;echo '			<tr>
				<td colspan="5">暂时没有兑换订单</td>
			</tr>
		';};echo '	</tbody> 
    </table>
	<footer>
	';
$rel=get_class($this).'/pointList-{page}?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$data['total'],$rel,'betLogSearchPageAction');
;echo '	</footer>
    </div><!-- end of .tab_container -->
</article><!-- end of content manager article -->
';
?>