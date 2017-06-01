<?php
echo ' ';
$data=$this->getRows("select content from {$this->prename}content where nodeId=1 and enable=1");
;echo '	<div class="demo"><div class="titl">系统公告</div>
		<div class="demoinfo"><div id="demo">
		<ul id="demo1">  
    	';if($data) foreach($data as $var){;echo '				<li>';echo $var['content'];echo '</li>
			';};echo '		</ul> 
		<div id="demo2"></div>
	</div></div></div>
<script> 
var speed=60 
var demo=document.getElementById("demo"); 
var demo2=document.getElementById("demo2"); 
var demo1=document.getElementById("demo1"); 
demo2.innerHTML=demo1.innerHTML 
function Marquee(){ 
if(demo2.offsetTop-demo.scrollTop<=0) 
  demo.scrollTop-=demo1.offsetHeight 
else{ 
  demo.scrollTop++ 
} 
} 
var MyMar=setInterval(Marquee,speed) 
demo.onmouseover=function() {clearInterval(MyMar)} 
demo.onmouseout=function() {MyMar=setInterval(Marquee,speed)} 
</script> ';
?>