<?php
echo '<input type="hidden" name="playedGroup" value="';echo $this->groupId;echo '" />
<input type="hidden" name="playedId" value="';echo $this->played;echo '" />
<input type="hidden" name="type" value="';echo $this->type;echo '" />
';foreach(array('自由泳','仰泳','蛙泳','蝶泳') as $var){;echo '<div class="pp" action="tzAllSelect" length="2" random="sscRandom">
	<div class="title">';echo $var;echo '</div>
	<input type="button" value="1" class="code min d" />
	<input type="button" value="2" class="code min s" />
	<input type="button" value="3" class="code min d" />
	<input type="button" value="4" class="code min s" />
	<input type="button" value="5" class="code max d" />
	<input type="button" value="6" class="code max s" />
	<input type="button" value="7" class="code max d" />
	<input type="button" value="8" class="code max s" />
	<input type="button" value="全" class="action all" />
	<input type="button" value="大" class="action large" />
	<input type="button" value="小" class="action small" />
	<input type="button" value="单" class="action odd" />
	<input type="button" value="双" class="action even" />
	<input type="button" value="清" class="action none" />
</div>
';
}
$maxPl=$this->getPl($this->type,$this->played);
;echo '<script type="text/javascript">
$(function(){
	gameSetPl(';echo json_encode($maxPl);echo ');
})
</script>
';
?>