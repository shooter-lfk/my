<?php
 $z3Pl=$this->getPl($this->type,19);$z6Pl=$this->getPl($this->type,20);;echo '<input type="hidden" name="playedGroup" value="';echo $this->groupId;echo '" />
<input type="hidden" name="type" value="';echo $this->type;echo '" />
<div class="pp" action="tzSscHhzxInput" played="后" length="3" z3min="';echo $z3Pl['bonusPropBase'];echo '" z6min="';echo $z6Pl['bonusPropBase'];echo '" z3max="';echo $z3Pl['bonusProp'];echo '" z6max="';echo $z6Pl['bonusProp'];echo '">
	<textarea id="textarea-code"></textarea>
</div>
<script type="text/javascript">
$(function(){
	gameSetPl(';echo json_encode($z3Pl);echo ', true);
})
</script>
'
?>