<?php

$time=strtotime('00:00:00');
if($args[0]){
$time-=idate('w')*24*3600;
}
$sql="select sum(b.bonus) amount, username from {$this->prename}bets b where zjCount>0 and kjTime>=$time group by b.uid order by amount desc limit 7";
if($data=$this->getRows($sql)) foreach($data as $key=>$var){
;echo '<tr>
	<td class="td1">';echo $key+1;echo '</td>
	<td class="td2">';echo preg_replace('/^(\w).*(\w{2})$/','\1***\2',$var['username']);echo '</td>
	<td class="td3">￥';echo number_format($var['amount'],2);echo '</td>
</tr>
';}
?>