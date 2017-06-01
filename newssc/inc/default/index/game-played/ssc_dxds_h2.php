<?php
echo '<input type="hidden" name="playedGroup" value="';echo $this->groupId;echo '" />
<input type="hidden" name="playedId" value="';echo $this->played;echo '" />
<input type="hidden" name="type" value="';echo $this->type;echo '" />
';foreach(array('十','个') as $var){;echo '<div class="pp" action="tzDXDS" length="2" random="sscRandom">
	<div class="title">';echo $var;echo '位</div>
	<input type="button" value="大" class="code" />
	<input type="button" value="小" class="code" />
	<input type="button" value="单" class="code" />
	<input type="button" value="双" class="code" />

</div>
';
}
$maxPl=$this->getPl($this->type,$this->played);
;echo '<script type="text/javascript">
$(function(){
	gameSetPl(';echo json_encode($maxPl);echo ',false,';echo $this->user['fanDianBdw'];echo ');
})
</script>
';
?>