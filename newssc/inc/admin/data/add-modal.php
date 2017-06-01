<?php
 $para=$args[0];
if($para['type']==1){
$actionNo=date('Ymd-',strtotime($para['actionTime'])).substr($para['actionNo']+1000,1);
if($para['actionNo']==120) $actionNo=date('Ymd-',strtotime($para['actionTime'])-24*3600).substr($para['actionNo']+1000,1);
}else if($para['type']==3||$para['type']==6||$para['type']==7||$para['type']==15||$para['type']==16||$para['type']==17||$para['type']==18||$para['type']==20||$para['type']==21){
$actionNo=date('Ymd-',strtotime($para['actionTime'])).substr($para['actionNo']+1000,1);
}else if($para['type']==11){
$actionNo=date('Ymd-',strtotime($para['actionTime'])).substr($para['actionNo']+100,1);
}else if($para['type']==12){
$actionNo=date('Ymd-',strtotime($para['actionTime'])).substr($para['actionNo']+100,1);
}else if($para['type']==19){
$actionNo=substr(date('Yz',strtotime($para['actionTime'])),4,6)*179+$para['actionNo']+337580;
}
;echo '<div>
<form action="/admin.php/data/added" target="ajax" method="post" call="dataSubmitCode" onajax="dataBeforeSubmitCode" dataType="html">
	<input type="hidden" name="type" value="';echo $para['type'];echo '"/>
	<table class="popupModal">
		<tr>
			<td class="title">期号：</td>
			<td><input type="text" name="number" value="';echo $actionNo
;echo '"/></td>
		</tr>
		<tr>
			<td class="title">开奖时间：</td>
			<td><input type="text" name="time" value="';echo $para['actionTime'];echo '"/></td>
		</tr>
		<tr>
			<td class="title">开奖号码：</td>
			<td><input type="text" name="data"/></td>
		</tr>
		<tr>
			<td colspan="2" align="left"><span class="spn4">请确认【期号】和【开奖号码】正确，输入后不可更改！<br/>号码格式如: 1,2,3,4,5</span></td>
		</tr>
	</table>
</form>
</div>';
?>