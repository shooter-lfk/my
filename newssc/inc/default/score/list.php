<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';
$this->display('inc_skin.php',0 ,'积分兑换');
if($this->limittype=='current'){
;echo '<script type="text/javascript">
$(function(){
	$(\'.state-on\').hover(function(){
		$(this).removeClass(\'state-on\').addClass(\'state-complete\').text(\'[确认收货]\');
	},function(){
		$(this).removeClass(\'state-complete\').addClass(\'state-on\').text(\'正在发货\');
	});
	$(\'.state-wait\').hover(function(){
		$(this).removeClass(\'state-wait\').addClass(\'state-off\').text(\'[取消兑换]\');
	},function(){
		$(this).removeClass(\'state-off\').addClass(\'state-wait\').text(\'等待发货\');
	});
});

function scoreSetState(err, data){
	if(err){
		alert(err);
	}else{
		location.reload();
	}
}

function scoreBeforeSetState(){
	var state=$(this).attr(\'state\');
	if(state==1){
		return confirm(\'取消兑换礼品只能返还';echo $this->payout * 100;echo '%积分，你确认要取消兑换嘛？\');
	}else if(state==2){
		return confirm(\'你要确认收货嘛？\');
	}
}
</script>
';};echo '</head>
<body>       
<div class="pright" style="width:720px;min-height:442px;padding:0;margin-bottom:0;overflow:hidden;">
<div class="main_topx">
	<span ';echo $this->iff($this->scoretype=='current','class="current img01"');echo '><a class="cai" href="/index.php/score/goods/current/all">正在活动</a></span>
	<span ';echo $this->iff($this->scoretype=='old','class="current img01"');echo '><a class="cai" href="/index.php/score/goods/old/all">往期活动</a></span>
	<span ';echo $this->iff($this->scoretype=='me','class="current img01"');echo '><a class="cai"  href="/index.php/score/goods/me/current">我参与的活动</a></span>
</div>
		<div class="game-left" style="width:720px;padding:0;">
			<div class="biao-top">
				<div class="top2 top3">
					<ul class="notopline">
					';if($this->scoretype=='me'){;echo '						<li ';echo $this->iff($this->limittype=='current','class="current"');echo '><a href="/index.php/score/goods/me/current">正在进行活动</a></li>
						<li ';echo $this->iff($this->limittype=='history','class="current"');echo '><a href="/index.php/score/goods/me/history">已完成活动</a></li>
					';}else{;echo '						<li ';echo $this->iff($this->limittype=='all','class="current"');echo '><a href="/index.php/score/goods/';echo $this->scoretype;echo '/all">全部活动</a></li>
						<li ';echo $this->iff($this->limittype=='time','class="current"');echo '><a href="/index.php/score/goods/';echo $this->scoretype;echo '/time">限时活动</a></li>
						<li ';echo $this->iff($this->limittype=='number','class="current"');echo '><a href="/index.php/score/goods/';echo $this->scoretype;echo '/number">限量活动</a></li>
						<li ';echo $this->iff($this->limittype=='both','class="current"');echo '><a href="/index.php/score/goods/';echo $this->scoretype;echo '/both">限时限量</a></li>
						';if($this->scoretype=='current'){;echo '						<li ';echo $this->iff($this->limittype=='none','class="current"');echo '><a href="/index.php/score/goods/';echo $this->scoretype;echo '/none">无限活动</a></li>
					';}};echo '					</ul>
				</div>
			</div>
			<div class="biao-cont">
				<!--左边栏body-->
				';
$colors=array('#f00','#224D3C','#384161','#125222','#3A352F','#AE3C15','#1b1b1b');
if($args[0]) foreach($args[0]['data'] as $var){
;echo '				<div class="swap">
					<div class="sp-left img02">
						<div class="goodsimg">
							<div class="zhezhao img02"></div>
							<div class="sp-xian img02"></div>
							<img src="/';echo $var['picmax'];echo '" border="0" width="390" height="145"/>
						</div>
						<div class="goods-right">
							<div class="gs-intro"><span class="spn22">';echo Object::CsubStr($var['content'],0,39);echo '</span></div>
							<div class="gs-title spn2" style="background:';echo $colors[mt_rand(0,count($colors))];echo ';">';echo $var['title'];echo '</div>
							<div class="gs-price spn9">
								<table width="100%">
									<tr>
										<td width="35%" class="spn23">价值</td><td width="40%" class="spn23">积分</td><td width="25%" class="spn23">剩余</td>
									</tr>
									<tr>
										<td class="spn23">￥';echo $var['price'];echo '</td><td class="spn23">';echo $var['score'];echo '</td><td class="spn23">';echo $this->iff($var['sum']=='0','不限',$var['surplus']);echo '</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<div class="sp-right">
						<a class="sp-join img02" ';echo $this->iff($this->formatGoodTime($var['startTime'],$var['stopTime'])!='已结束','title="点击参与" href="/index.php/score/swap/'.$var['id'].'"','');echo ' style="display:block;">
							<div class="number spn15"> ';echo $this->iff($this->formatGoodTime($var['startTime'],$var['stopTime'])!='已结束','进行中','已结束');echo '</div>
						</a>
						';
if($var['state']){
$state=array('1'=>'state-wait','2'=>'state-on');
;echo '						<a href="/index.php/score/setSwapState/';echo $var['swapId'];echo '" state="';echo $var['state'];echo '" target="ajax" onajax="scoreBeforeSetState" call="scoreSetState" class="sp-state img02 ';echo $state[$var['state']];echo '" style="display:block;">';echo $this->iff($var['state']==1,'等待发货','正在发货');echo '</a>
						';};echo '					</div>
				</div>
				';}$this->display('inc_page.php',0,$args[0]['total'],$this->pageSize,"/index.php/score/goods-{page}/{$this->scoretype}/{$this->limittype}",1);;echo '				<!--左边栏body end-->
			</div>
			
		</div>
</div>
</body>
</html>
'
?>