<?php

$sql="select groupName from {$this->prename}played_group where id=?";
$groupName=$this->getValue($sql,$this->groupId);
$sql="select id, name, playedTpl, enable from {$this->prename}played where enable=1 and groupId=?";
$playeds=$this->getRows($sql,$this->groupId);
if(!$playeds) {echo '<div style="height:150px;margin-top:50px;text-align:center;color:#f00">暂无玩法</div>';return;}
if(!$this->played) $this->played=$playeds[0]['id'];
;echo '<div class="game-btn2">
	<div class="on-btn img02">';echo $groupName;echo '&nbsp;&nbsp;<span class="spn7">||</span></div>
	';
if($playeds) foreach($playeds as $played){
if($this->played==$played['id']) $tpl=$played['playedTpl'];
if($played['enable']){
;echo '	<div class="ul-li"><a href="/index.php/index/played/';echo $this->type;echo '/';echo $played['id'];echo '"';echo ($played['id']==$this->played)?' class="current"':'';echo '>';echo $played['name'];echo '</a></div>
	';}};echo '</div>
<div class="num-table" id="num-select">
';
if(!$played['enable']) {echo '<div style="height:100px;text-align:center;color:#f00">暂无玩法</div>';return;}
$this->display("index/game-played/$tpl.php");;echo '</div>'
?>