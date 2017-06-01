<?php
echo '<script type="text/javascript">  
setInterval(function() {
    $("#reget").load(location.href+" #reget>*","");
}, 5000);
</script>  
<div class="kaijiangall">
	<ul class="kja-cont" id="reget">
	<li><span class="expect"><b>Issue</b></span><span class="opencode"><b>Number</b></span><span class="opentime"><b>Time</b></span></li>
	';$this->display('index/inc_data_history_get.php',0,6);;echo '	</ul>
</div>
</div>'
?>