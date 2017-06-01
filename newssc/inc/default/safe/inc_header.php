<?php
echo '
	';$this->display('inc_header.php');;echo '</div>	
       <div class="main"><div class="indexbg">
    <div class="pleft">
        	<!--top-->
    	 
<div class="leftbox">
<div class="titletext">安全中心</div>
	<ul class="dhleft">
		<li ';echo $this->iff($this->action=='info','class="current img01"');echo '><a href="/index.php/safe/info" class="cai">个人资料管理</a></li>
		<li ';echo $this->iff($this->action=='passwd','class="current img01"');echo '><a class="cai" href="/index.php/safe/passwd">密码管理</a></li>
	
	</ul>
</div>
'
?>