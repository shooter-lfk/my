<?php

$sql="select groupName from {$this->prename}played_group where id=?";
$groupName=$this->getValue($sql,$this->groupId);
$sql="select id, name, playedTpl, enable from {$this->prename}played where groupId=?";
$playeds=$this->getRows($sql,$this->groupId);
if(!$this->played) $this->played=$playeds[0]['id'];
;echo '<div class="on-btn img02">';echo $groupName;echo '&nbsp;&nbsp;<span class="spn7">||</span></div>
';
if($playeds) foreach($playeds as $played){
if($played['enable']){
;echo '<div class="ul-li"><a href="/index.php/index/played/';echo $this->type;echo '/';echo $played['id'];echo '"';echo ($played['id']==$this->played)?' class="current"':'';echo '>';echo $played['name'];echo '</a></div>
';}}
?>