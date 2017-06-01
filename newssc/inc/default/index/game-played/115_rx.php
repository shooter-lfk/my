<?php
echo '<input type="hidden" name="playedGroup" value="';echo $this->groupId;echo '" />
<input type="hidden" name="playedId" value="';echo $this->played;echo '" />
<input type="hidden" name="type" value="';echo $this->type;echo '" />
';foreach(array('一','二','三') as $var){;echo '<div class="pp pp11" action="tzAllSelect" length="3" random="sscRandom">
	<div class="title">';echo $var;echo '位</div>
	<input type="button" value="1" class="code d min" />
	<input type="button" value="2" class="code s min" />
	<input type="button" value="3" class="code d min" />
	<input type="button" value="4" class="code s min" />
	<input type="button" value="5" class="code d min" />
	<input type="button" value="6" class="code s max" />
	<input type="button" value="7" class="code d max" />
	<input type="button" value="8" class="code s max" />
	<input type="button" value="9" class="code d max" />
	<input type="button" value="10" class="code s max" />
	<input type="button" value="11" class="code d max" />
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

';
?>