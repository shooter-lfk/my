<?php

if($list=$this->getGameNos($this->type,$args[1]))
foreach($list as $var){
;echo '<tr>
	<td><input type="checkbox" />
	<td>';echo $var['actionNo'];echo '</td>
	<td><input type="text" class="beishu" value="1"/></td>
	<td><span class="amount">';echo $args[0];echo '</span>元</td>
	<td>';echo date('Y-m-d H:i',$var['actionTime']);echo '</td>
</tr>
';}
?>