<?php

$pageSize=$args[1];
$pageurl=$args[2];
if(isset($args[0])){
if($args[0]>1){
$recordCount=$args[0];
}else{
$recordCount=1;
}
}else{
$recordCount=1;
}
$pageCount=ceil($recordCount/$pageSize);
if($args[3]==1){
if($pageCount<=1) return;
}elseif($args[3]==2){
if($recordCount<=1) return;
}
$listPageSize=5;
$startPage=$this->page-floor($listPageSize/2);
if($startPage<1) $startPage=1;
$prePage=$this->page-1;
if($prePage<1) $prePage=1;
$nextPage=$this->page+1;
if($nextPage>$pageCount) $nextPage=$pageCount;
if(!function_exists('set_page_url')){
function set_page_url($page,$urlString,$flag='{page}'){
return str_replace($flag,$page,$urlString);
}
}
;echo '<div class="bottompage">
	
	';if($this->page==1){;echo '		<a class="disabled">首页</a>&nbsp;
        <a class="disabled">上一页</a>&nbsp;
	';}else{;echo '	<a href="';echo set_page_url(1,$pageurl);echo '">首页</a>&nbsp;
    <a href="';echo set_page_url($prePage,$pageurl);echo '">上一页</a>&nbsp;
	';}
for($page=$startPage;$page<=$startPage+$listPageSize;$page++){
if($page>$pageCount) break;
;echo '	
	&nbsp;<a href="';echo set_page_url($page,$pageurl);echo '"';echo ($page==$this->page?' class="pagecurrent"':'');echo '>';echo $page;echo '</a>&nbsp;

	
	';
}
if($page>$pageCount) $page=$pageCount;
if($this->page==$pageCount){
;echo '	<a class="disabled">下一页</a>
	<a class="disabled">尾页</a>
	';}else{;echo '	<a href="';echo set_page_url($nextPage,$pageurl);echo '">下一页</a>
	<a href="';echo set_page_url($pageCount,$pageurl);echo '">尾页</a>
	';};echo '	<span class="disabled">第';echo $this->page;echo '页/共';echo $pageCount;echo '页</span>
</div>
';
?>