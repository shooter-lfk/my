<?php
echo '<style type="text/css"> 
	.no {background:url(/lot_loading.gif) no-repeat center top;height: 70px;margin: 4px 0;}
	.hao-bx	.no {background:url(/lot_loading.gif) no-repeat center center;height:60px;margin:0;}
	.pk10	.no {background:url(/lot_loading.gif) no-repeat center center;height:52px;margin:0;}
	.kaijiang:hover li.no{background-image:none;}
</style>
<div class="pright"><div class="kjfousin">
<div class="kaijiang" id="kaijiang" type="';echo $this->type;echo '">
';
$lastNo=$this->getGameLastNo($this->type);
$kjHao=$this->getValue("select data from {$this->prename}data where type={$this->type} and number='{$lastNo['actionNo']}'");
if($kjHao) $kjHao=explode(',',$kjHao);
$actionNo=$this->getGameNo($this->type);
$types=$this->getTypes();
$kjdTime=$types[$this->type]['data_ftime'];
$diffTime=strtotime($actionNo['actionTime'])-$this->time-$kjdTime;
;echo '<div class="kj-title"><div class="lotqh">第<span>';echo $lastNo['actionNo'];echo '</span>期</div><b>';echo $types[$this->type]['title'];echo '</b><img id=\'voice\' onclick="voiceKJ()" class="voice-on"></div>
<script type="text/javascript"> 
	loadKjData();
</script>
';if($types[$this->type]['type']==1||$types[$this->type]['type']==2) {;echo '<ul class="kj-hao">
    <li class="hao"><img src="/skin/main/images/number/';echo $kjHao[0];echo '.gif" /></li>
    <li class="hao"><img src="/skin/main/images/number/';echo $kjHao[1];echo '.gif" /></li>
    <li class="hao"><img src="/skin/main/images/number/';echo $kjHao[2];echo '.gif" /></li>
    <li class="hao"><img src="/skin/main/images/number/';echo $kjHao[3];echo '.gif" /></li>
    <li class="hao lastr"><img src="/skin/main/images/number/';echo $kjHao[4];echo '.gif" /></li>
		<div class="haon"><em class="act';echo $types[$this->type]['id'];echo '"></em>';echo $types[$this->type]['info'];echo '</div>
</ul>
';}else if($types[$this->type]['type']==3){;echo '<ul class="kj-hao hao-wid">
    <li class="hao"><img src="/skin/main/images/number/';echo $kjHao[0];echo '.gif" /></li>
    <li class="hao"><img src="/skin/main/images/number/';echo $kjHao[1];echo '.gif" /></li>
    <li class="hao lastr"><img src="/skin/main/images/number/';echo $kjHao[2];echo '.gif" /></li>
		<div class="haon"><em class="act';echo $types[$this->type]['id'];echo '"></em>';echo $types[$this->type]['info'];echo '</div>
</ul>
';}else if($types[$this->type]['type']==4){;echo '<ul class="kj-hao hao-qx" style="margin-left:7px;padding-top:20px;width:330px;">
    <li><img src="/skin/main/images/number/';echo $kjHao[0];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/';echo $kjHao[1];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/';echo $kjHao[2];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/';echo $kjHao[3];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/';echo $kjHao[4];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/';echo $kjHao[5];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/';echo $kjHao[6];echo '.gif" /></li>
		<div class="haon"><em class="act';echo $types[$this->type]['id'];echo '"></em>';echo $types[$this->type]['info'];echo '</div>
</ul>
';}else if($types[$this->type]['type']==5){;echo '<ul class="kj-hao hao-wid">
    <li class="hao"><img src="/skin/main/images/number/c';echo $kjHao[0];echo '.gif" /></li>
    <li class="hao"><img src="/skin/main/images/number/c';echo $kjHao[1];echo '.gif" /></li>
    <li class="hao lastr"><img src="/skin/main/images/number/c';echo $kjHao[2];echo '.gif" /></li>
		<div class="haon"><em class="act';echo $types[$this->type]['id'];echo '"></em>';echo $types[$this->type]['info'];echo '</div>
</ul>
';}else if($types[$this->type]['type']==6){;echo '<ul class="kj-hao pk10" style="margin-left:6px;padding-top:15px;width:330px;">
    <li><img src="/skin/main/images/number/c';echo $kjHao[0];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/c';echo $kjHao[1];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/c';echo $kjHao[2];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/c';echo $kjHao[3];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/c';echo $kjHao[4];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/c';echo $kjHao[5];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/c';echo $kjHao[6];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/c';echo $kjHao[7];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/c';echo $kjHao[8];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/c';echo $kjHao[9];echo '.gif" /></li>
		<div class="haon"><em class="act';echo $types[$this->type]['id'];echo '"></em>';echo $types[$this->type]['info'];echo '</div>
</ul>
';}else if($types[$this->type]['type']==8){;echo '<ul class="kj-hao hao-bx" style="margin-left:8px;padding-top:20px;width:330px;">
    <li><img src="/skin/main/images/number/';echo $kjHao[0];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/';echo $kjHao[1];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/';echo $kjHao[2];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/';echo $kjHao[3];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/';echo $kjHao[4];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/';echo $kjHao[5];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/';echo $kjHao[6];echo '.gif" /></li>
    <li><img src="/skin/main/images/number/';echo $kjHao[7];echo '.gif" /></li>
		<div class="haon"><em class="act';echo $types[$this->type]['id'];echo '"></em>';echo $types[$this->type]['info'];echo '</div>
</ul>
';}else if($types[$this->type]['type']==7){;echo '<ul class="kj-hao hao-sx">
    <li class="hao"><img src="/skin/main/images/number/';echo $kjHao[0];echo '.gif" /></li>
    <li class="hao"><img src="/skin/main/images/number/';echo $kjHao[1];echo '.gif" /></li>
    <li class="hao"><img src="/skin/main/images/number/';echo $kjHao[2];echo '.gif" /></li>
    <li class="hao lastr"><img src="/skin/main/images/number/';echo $kjHao[3];echo '.gif" /></li>
		<div class="haon"><em class="act';echo $types[$this->type]['id'];echo '"></em>';echo $types[$this->type]['info'];echo '</div>
</ul>
';};echo '
<div class="kj-bottom" id="kjbot">
	<div class="time spn5" action="/index.php/display/freshKanJiang/';echo $this->type;echo '" id="pre-kanjiang" >00:00</div>
	<div style="float:left;"><div class="qihao spn4">第<span>';echo $actionNo['actionNo'];echo '</span>期</div><div class="sytime">投注剩余时间</div></div>
	<div style="clear:both;"></div>
</div>
<script type="text/javascript">
$(function(){
	window.S=';echo json_encode($diffTime>0);echo ';
	window.kjTime=parseInt(';echo json_encode($kjdTime);echo ');
	
	if($.browser.msie){
		//window.diffTime=';echo $diffTime;echo ';
		setTimeout(function(){
			gameKanJiangDataC(';echo $diffTime;echo ');
		}, 1000);
	}else{
		setTimeout(gameKanJiangDataC, 1000, ';echo $diffTime;echo ');
	}
	
	//';if(!$kjHao){;echo ' 
	loadKjData();
	//';};echo ' 
});
</script>
</div>
';
?>