<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'提现记录');;echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
<script type="text/javascript">
$(function(){
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
</script>
</head>
<body>
<div class="pright" style="width:720px;min-height:260px;padding:0;">
<div class="main_top">
	<div class="dtime" style="width:270px;">
		<form action="/index.php/cash/toCashLog" method="get">
			<div class="but_sum" onclick="$(this).closest(\'form\').submit()">查询</div>
			<div class="input"><input class="fqr-in" type="date" name="endTime" value="';echo date('Y-m-d');echo '" height="20"/></div>
			<div class="input"><input class="fqr-in" type="date" name="fromTime" value="';echo date('Y-m-d',strtotime('-1 day'));echo '" height="20"/></div>
			<div style="display:none;"><input type="submit" value=""/></div>
		</form>
	</div>
	<span>提现记录</span>
</div>
		<div class="game-left" style="width:720px;padding:0;">
			<div class="biao-cont">
				<!--下注列表-->
				<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_1">
					<thead class="tr-top">
					<tr>
						<th width="150">申请时间</th>
						<th width="120">提现银行</th>
						<!--th width="120">银行尾号</th-->
						<th width="120">提现金额</th>
						<th>状态</th>
					</tr>
					</thead>
					<tbody class="tr-cont">
					';
$sql="select c.*, b.name bankName from {$this->prename}member_cash c, {$this->prename}bank_list b where c.bankId=b.id and uid={$this->user['uid']} and b.isDelete=0 and c.isDelete=0 order by id desc";
if($_GET['fromTime'] &&$_GET['endTime']){
$fromTime=strtotime($_GET['fromTime']);
$endTime=strtotime($_GET['endTime'])+3600*24;
$sql.=" and actionTime between $fromTime and $endTime";
}elseif($_GET['fromTime']){
$sql.=' and actionTime>='.strtotime($_GET['fromTime']);
}elseif($_GET['endTime']){
$sql.=' and actionTime<'.(strtotime($_GET['endTime'])+3600*24);
}
$stateName=array('提现成功','提交到银行处理','已取消','已支付','银行处理失败');
$list=$this->getPage($sql,$this->page,$this->pageSize);
if($list['data']) foreach($list['data'] as $var){
;echo '					<tr>
						<td>';echo date('m-d H:i:s',$var['actionTime']);echo '</td>
						<td>';echo $var['bankName'];echo '</td>
						<!--td>';echo preg_replace('/^.*(.{3})$/',"$1",$var['account']);echo '</td-->
						<td>';echo $var['amount'];echo '</td>
						<td>
						';
if($var['state']==3){
echo '<div class="sure" id="',$var['id'],'"></div>';
}else if($var['state']==4){
echo $this->iff($var['state']==4,$this->iff($var['info'],$var['info'],$var['bankName'].'返回错误信息:675051'),$var['bankName'].' 处理完成');
}else{
echo $var['bankName'].'处理完成，'.$stateName[$var['state']];
}
;echo '						</td>
					</tr>
					';};echo '					</tbody>
				</table>
				';
$this->display('inc_page.php',0,$list['total'],$this->pageSize,"/index.php/cash/toCashLog-{page}?fromTime={$_GET['fromTime']}&endTime={$_GET['endTime']}");
;echo '				<!--下注列表 end -->
			</div>
		</div>
</div>
</body>
</html>
'
?>