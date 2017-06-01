<?php
	if(isset($args[0])){
if($args[0]>1){
$recordCount=$args[0];
}else{
$recordCount=1;
}
}else{
$recordCount=1;
}
$pageCount=ceil($recordCount/$this->pageSize);
$listPageSize=10;
$startPage=$this->page-floor($listPageSize/2);
if($startPage<1) $startPage=1;
$prePage=$this->page-1;
if($prePage<1) $prePage=1;
$nextPage=$this->page+1;
if($nextPage>$pageCount) $nextPage=$pageCount;
;echo '<ul class="pageinfo" rel="';echo $args[1];echo '" action="';echo $args[2];echo '">
	<li>页数：';echo $this->page;echo '/';echo $pageCount;echo '</li>
	
	';if($this->page==1){;echo '	<li value="1" class="disabled">&lt;&lt;</li>
	<li value="1" class="disabled">&lt;</li>
	';}else{;echo '	<li value="1">&lt;&lt;</li>
	<li value="';echo $prePage;echo '">&lt;</li>
	';}
for($page=$startPage;$page<=$startPage+$listPageSize;$page++){
if($page>$pageCount) break;
;echo '	
	<li value="';echo $page;echo '"';echo ($page==$this->page?' class="current"':'');echo '>';echo $page;echo '</li>

	
	';
}
if($page>$pageCount) $page=$pageCount;
if($this->page==$pageCount){
;echo '	<li class="disabled" value="';echo $nextPage;echo '">&gt;</li>
	<li class="disabled" value="';echo $pageCount;echo '">&gt;&gt;</li>
	';}else{;echo '	<li value="';echo $nextPage;echo '">&gt;</li>
	<li value="';echo $pageCount;echo '">&gt;&gt;</li>
	';};echo '</ul>';
?>