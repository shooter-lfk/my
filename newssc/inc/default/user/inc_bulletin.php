<?php
echo ' ';
$data=$this->getRows("select content from {$this->prename}content where nodeId=1 and enable=1");
;echo '<div class="pright">
    <!--滚动公告展示-->
    <div class="gonggao mb10"><div class="gonggaotitle">滚动公告：</div>
    <div class="gonggaolist"><marquee id="gundong" onmouseover="gundong.stop()" onmouseout="gundong.start()" scrollamount="3">
     <!--公告-->
				
			';if($data) foreach($data as $var){;echo '				';echo $var['content'];echo '			';};echo '		<!--公告 end--> </marquee>
    </div>
    </div>
'
?>