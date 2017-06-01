<?php
echo '<input type="hidden" name="playedGroup" value="';echo $this->groupId;echo '" />
<input type="hidden" name="playedId" value="';echo $this->played;echo '" />
<input type="hidden" name="type" value="';echo $this->type;echo '" />
<div class="pp" action="tz11x5Select" length="1" random="lhcRandom">
	<input type="button" value="01" class="code min d" />
	<input type="button" value="02" class="code min s" />
	<input type="button" value="03" class="code min d" />
	<input type="button" value="04" class="code min s" />
	<input type="button" value="05" class="code min d" />
	<input type="button" value="06" class="code min s" />
	<input type="button" value="07" class="code min d" />
	<input type="button" value="08" class="code min s" />
	<input type="button" value="09" class="code min d" />
	<input type="button" value="10" class="code min s" />
	<input type="button" value="11" class="code min d" />
	<input type="button" value="12" class="code min s" />
	<input type="button" value="13" class="code min d" />
	<input type="button" value="14" class="code min s" />
	<input type="button" value="15" class="code min d" /><br>
	<input type="button" value="16" class="code min s" />
	<input type="button" value="17" class="code min d" />
	<input type="button" value="18" class="code min s" />
	<input type="button" value="19" class="code min d" />
	<input type="button" value="20" class="code min s" />
	<input type="button" value="21" class="code min d" />
	<input type="button" value="22" class="code min s" />
	<input type="button" value="23" class="code min d" />
	<input type="button" value="24" class="code min s" />
	<input type="button" value="25" class="code min d" />
	<input type="button" value="26" class="code max s" />
	<input type="button" value="27" class="code max d" />
	<input type="button" value="28" class="code max s" />
	<input type="button" value="29" class="code max d" />
	<input type="button" value="30" class="code max s" /><br>
	<input type="button" value="31" class="code max d" />
	<input type="button" value="32" class="code max s" />
	<input type="button" value="33" class="code max d" />
	<input type="button" value="34" class="code max s" />
	<input type="button" value="35" class="code max d" />
	<input type="button" value="36" class="code max s" />
	<input type="button" value="37" class="code max d" />
	<input type="button" value="38" class="code max s" />
	<input type="button" value="39" class="code max d" />
	<input type="button" value="40" class="code max s" />
	<input type="button" value="41" class="code max d" />
	<input type="button" value="42" class="code max s" />
	<input type="button" value="43" class="code max d" />
	<input type="button" value="44" class="code max s" />
	<input type="button" value="45" class="code max d" /><br>
	<input type="button" value="46" class="code max s" />
	<input type="button" value="47" class="code max d" />
	<input type="button" value="48" class="code max s" />
	<input type="button" value="49" class="code max d" />
	<input type="button" value="全" class="action all" style="margin-left:360px;" />
	<input type="button" value="大" class="action large" />
	<input type="button" value="小" class="action small" />
	<input type="button" value="单" class="action odd" />
	<input type="button" value="双" class="action even" />
	<input type="button" value="清" class="action none" />
</div>
';$maxPl=$this->getPl($this->type,$this->played);;echo '<script type="text/javascript">
$(function(){
	gameSetPl(';echo json_encode($maxPl);echo ');
})
</script>
';
?>