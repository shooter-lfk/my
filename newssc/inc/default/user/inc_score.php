<?php
echo '<div class="jifen img01">
	<div class="jf-top">
		<div class="jf-bq img01"></div>
	</div>
	<div class="jf-body" id="score-slide">
		';
$sql="select id, picmin, price, score from {$this->prename}score_goods where (stopTime>{$this->time} or stopTime=0) and enable=1";
if($data=$this->getRows($sql)) foreach($data as $var){
;echo '			<a href="/index.php/score/swap/';echo $var['id'];echo '" data-price="';echo $var['price'];echo '" data-score="';echo $var['score'];echo '" target="_blank"><img src="/';echo $var['picmin'];echo '"/></a>
		';};echo '	</div>
	<div class="jf-bottom">
    	<a align="center" href="/index.php/score/goods/current" class="jf-link">—*查看更多积分兑换礼品*—</a>
		<!--<div class="value spn8">价值<span class="price">';echo $var['id'];echo '</span>￥</div>
		<div class="point spn8">积分:<span class="score">';echo $var['price'];echo '</span>分</div>-->
	</div>
	<ul id="score-slide-ctroller">
	';if($data) foreach($data as $key=>$var){;echo '		<li>';echo $key+1;echo '</li>
	';};echo '	</ul>
</div>
<script type="text/javascript" src="/skin/js/jquery.tools.tab.js"></script>
<script type="text/javascript">
$(function(){
	$(\'#score-slide-ctroller\').tabs(\'#score-slide > a\', {
		effect: \'fade\',
		fadeOutSpeed: "slow",
		//autoplay:true,
		rotate: true
		//alert("123");
	}).slideshow().data(\'slideshow\').play();
});
</script>'
?>