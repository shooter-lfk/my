<?php
echo '<script type="text/javascript">
var err=';echo json_encode($args[0]);echo ';
top.alert(err);
history.back();
</script>'
?>