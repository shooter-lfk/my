<?php

if(!$this->types) $this->getTypes();
if(!$this->playeds) $this->getPlayeds();
$modes=array(
'0.02'=>'分',
'0.20'=>'角',
'2.00'=>'元'
);
$sql="select * from {$this->prename}bets where kjTime>{$this->time} and isDelete=0 and uid={$this->user['uid']} order by actionTime desc";
if($list=$this->getRows($sql,$actionNo['actionNo']))
foreach($list as $var){
;echo '	<tr data-code=\'';echo json_encode($var);echo '\'>
		<td><a onClick="art.dialog.open(\'/index.php/record/betInfo2/';echo $var['id'];echo '\', {id: \'testID3\',lock: true,title: \'投注信息\',width:510, height:374});">…';echo $var['id'];echo '</a></td>
		<td>';echo date('H:i:s',$var['actionTime']);echo '</td>
		<td>';echo $this->types[$var['type']]['shortName'];echo '</td>
		<td>';echo $this->playeds[$var['playedId']]['name'];echo '</td>
		<td>';echo $var['actionNo'];echo '</td>
		<td>';echo Object::CsubStr($var['actionData'],0,9);echo '</td>
		<td>';echo $var['actionNum'];echo '注</td>
		<td>';echo $var['beiShu'];echo '倍</td>
		<td>';echo $var['beiShu']*$var['mode']*$var['actionNum'];echo '元</td>
		<td>';echo $var['bonusProp'];echo '/';echo $var['fanDian'];echo '%</td>
		<td><a target="ajax" call="gameFreshOrdered" title="是否确定撤单？" dataType="json" href="/index.php/game/deleteCode/';echo $var['id'];echo '">撤单</a></td>
	</tr>
';}
?>