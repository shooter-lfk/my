<?php

if($args[0]){
$sql="select mode * beiShu * zjCount * bonusProp/2 amount, id from {$this->prename}bets where zjCount>0 and kjTime>=".strtotime('00:00:00').' order by amount desc limit 7';
}else{
$actionNo=$this->getGameLastNo($this->type);
$sql="select mode * beiShu * zjCount * bonusProp/2 amount, id from {$this->prename}bets where zjCount>0 and actionNo='{$actionNo['actionNo']}' order by amount desc limit 7";
}
if($data=$this->getRows($sql)) foreach($data as $key=>$var){
;echo '<tr>
	<td class="td1 img01" style="width:20px">';echo $key+1;echo '</td>
	<td class="td2" style="width:50px"><a href="/index.php/record/betInfo/';echo $var['id'];echo '" width="510" title="投注信息" button="关闭:defaultModalCloase" target="modal">';echo $var['id'];echo '</a></td>
	<td class="td3" style="width:80px">￥';echo number_format($var['amount'],2);echo '</td>
	<td class="td3" style="width:40px">';if($var['betType']==0){echo 'web端';}else if($var['betType']==1){echo '手机端';}else if($var['betType']==2){echo '客户端';};echo '</td>
</tr>
';}
?>