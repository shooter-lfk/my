<?php
echo '<div class="top img-bj">
	';$this->display('inc_header.php');;echo '	<ul class="dh2 img01">
	';
$sql="select id,type,title,shortName from {$this->prename}type where isDelete=0 and enable=1 order by sort";
if($types=$this->getRows($sql))
foreach($types as $key=>$var){
if(!$this->type) $this->type=$var['id'];
;echo '		<li ';echo ($var['id']==$this->type)?' class="current img01"':'';echo '>
			<a href="/index.php/index/main/';echo $var['id'];echo '" class="cai-bj">';echo $var['shortName']?$var['shortName']:$var['title'];echo '</a>
			<a href="/index.php/index/main/';echo $var['id'];echo '" class="cai">';echo $var['shortName']?$var['shortName']:$var['title'];echo '</a>
			<a href="/index.php/index/main/';echo $var['id'];echo '" class="fgline img01"></a>
		</li>
	';};echo '		<li><a class="fgline img01"></a></li>
	</ul>
</div>
';
?>