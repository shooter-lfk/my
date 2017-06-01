<?php
echo '<input type="hidden" name="playedGroup" value="';echo $this->groupId;echo '" />
<input type="hidden" name="playedId" value="';echo $this->played;echo '" />
<input type="hidden" name="type" value="';echo $this->type;echo '" />
<div class="zhixu115 unique">
	';foreach(array('首位红投') as $var){;echo '    <div class="pp pp11" action="tzAllSelect" length="1" delimiter=" ">
        <div class="title">';echo $var;echo '</div>
        <input type="button" value="19" class="code d max" />
        <input type="button" value="20" class="code s max" />
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