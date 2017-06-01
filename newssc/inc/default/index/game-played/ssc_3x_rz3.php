<?php
 $z3Pl=$this->getPl($this->type,22);$z6Pl=$this->getPl($this->type,23);;echo '<input type="hidden" name="playedGroup" value="';echo $this->groupId;echo '" />
<input type="hidden" name="type" value="';echo $this->type;echo '" />
<div class="pp" action="tzSscHhzxInput" played="任选" length="3" z3min="';echo $z3Pl['bonusPropBase'];echo '" z6min="';echo $z6Pl['bonusPropBase'];echo '" z3max="';echo $z3Pl['bonusProp'];echo '" z6max="';echo $z6Pl['bonusProp'];echo '">
	<div id="wei-shu" length="3">
		<label><input type="checkbox" value="16" />万</label>
		<label><input type="checkbox" value="8" />千</label>
		<label><input type="checkbox" value="4" />百</label>
		<label><input type="checkbox" value="2" />十</label>
		<label><input type="checkbox" value="1" />个</label>
	</div>
	<textarea id="textarea-code"></textarea>
</div>
<script type="text/javascript">
$(function(){
	gameSetPl(';echo json_encode($z3Pl);echo ');
})
</script>';
?>