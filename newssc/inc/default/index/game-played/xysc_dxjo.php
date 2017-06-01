<?php
echo '<input type="hidden" name="playedGroup" value="';echo $this->groupId;echo '" />
<input type="hidden" name="playedId" value="';echo $this->played;echo '" />
<input type="hidden" name="type" value="';echo $this->type;echo '" />
<div class="zhixu115 unique">
	';foreach(array('冠军') as $var){;echo '    <div class="pp pp11" action="tzAllSelect" length="1" delimiter=" ">
	<div class="title">';echo $var;echo '</div>
		<div class="dxjo"><input type="button" value="01 03 05" class="code mind dxds"><br>小奇</div>
		<div class="dxjo"><input type="button" value="02 04 06" class="code mins dxds"><br>小偶</div>
		<div class="dxjo"><input type="button" value="07 09 11" class="code maxd dxds"><br>大奇</div>
		<div class="dxjo"><input type="button" value="08 10 12" class="code maxs dxds"><br>大偶</div>
  </div>
';
}
$maxPl=$this->getPl($this->type,$this->played);
;echo '</div>

<script type="text/javascript">
$(function(){
	gameSetPl(';echo json_encode($maxPl);echo ');
})
</script>

';
?>