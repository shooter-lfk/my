<?php
	$sql="select id, type, time, number, data from {$this->prename}data where type={$this->type} order by number desc limit {$args[0]}";
$types=$this->getTypes();
$times=$types[$this->type]['data_ftime'];
if($data=$this->getRows($sql)) foreach($data as $var){
;echo '';if($var['type']==19){;echo '	<li><span class="expect">';echo $var['number'];echo '</span><span class="opencode codes">';echo $var['data'];echo '</span><span class="opentime">';echo date('H:i',$var['time']);echo '</span></li>
';}else if($var['type']==9||$var['type']==10||$var['type']==14){;echo '	<li><span class="expect">';echo $var['number'];echo '</span><span class="opencode"><em>';echo str_replace(',','</em><em>',$var['data']);echo '</em></span><span class="opentime">';echo date('m-d',$var['time']);echo '</span></li>
';}else{;echo '	<li><span class="expect">';echo $var['number'];echo '</span><span class="opencode"><em>';echo str_replace(',','</em><em>',$var['data']);echo '</em></span><span class="opentime">';echo date('H:i',$var['time']);echo '</span></li>
';}}
?>