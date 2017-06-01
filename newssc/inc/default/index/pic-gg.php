<?php
echo '<script type="text/javascript">
$(\'<div><img width="290" height="160" src="';echo $this->settings['picGG'];echo '"/></div>\').dialog({
	title:';echo json_encode($this->settings['picGGTitle']);echo ',
	width:320,
	height:210,
	resizable:false,
	position:[\'right\',\'bottom\']
});
</script>'
?>