<?php

$sql="select * from {$this->prename}score_goods order by id desc";
$data=$this->getPage($sql,$this->page,$this->pageSize);
;echo '<article class="module width_full">
    <header>
    	<h3 class="tabs_involved">兑换商品列表
			<div class="submit_link wz"><input type="submit" value="添加商品" onclick="scoreEditGoods()" class="alt_btn"></div>
        </h3>
    </header>
    <div class="tab_content">
	<table class="tablesorter" cellspacing="0"> 
	<thead> 
		<tr> 
			<th>ID</th> 
			<th>名称</th> 
			<th>描述</th> 
			<th>总量</th> 
			<th>兑换量</th> 
			<th>剩余量</th> 
			<th>积分</th> 
			<th>价值</th> 
			<th>时间</th> 
			<th>状态</th><!--开启 关闭 超时 缺货-->
			<th>操作</th> 
		</tr> 
	</thead> 
	<tbody>
    <!--picmin 小图片	picmax 大图片	intoTime 加入时间	restriction 限制单人兑换件数	sum 商品总数	surplus 剩余件数	startTime 开始时间	stopTime 结束时间	score 积分	price 价值	enable-->
	';if($data['data']) foreach($data['data'] as $var){
$cssspan1="spn1";
$cssspan2="spn1";
$cssspan3="spn1";
if($var['enable']==0){
$state="关闭";
$statebtn="开启";
$cssspan3="spn6";
}else{
$state="开启";
$statebtn="关闭";
$cssspan3="spn5";
if($var["sum"]-$var["surplus"]<=0){
$state="关闭";
$statebtn="开启";
$cssspan1="spn4";
$cssspan3="spn6";
}
if((time()-$var["stopTime"]>0 &&$var["stopTime"]) ||time()-$var["startTime"]<0){
$state="关闭";
$statebtn="开启";
$cssspan2="spn4";
$cssspan3="spn6";
}
}
;echo '		<tr> 
			<td>';echo $var['id'];echo '</td> 
			<td>';echo $var['title'];echo '</td> 
			<td><input type="text" value="';echo $var['content'];echo '"/></td> 
			<td>';echo $var['sum'];echo '</td> 
			<td><span class="';echo $cssspan1;echo '">';echo $var['sum']-$var['surplus'];echo '</span></td> 
			<td>';echo $var['surplus'];echo '</td> 
			<td>';echo $var['score'];echo '</td> 
			<td>';echo $var['price'];echo '</td> 
			<td><span class="';echo $cssspan2;echo '"> ';echo date("Y-m-d H:i",$var['startTime']);echo ' — ';echo date("Y-m-d H:i",$var['stopTime']);echo '</span></td> 
			<td><span class="';echo $cssspan3;echo '">';echo $state;echo '</span></td> 
			<td><a href="/admin.php/Score/goodsOnoff/';echo $var['id'].'/'.$var['enable'];echo '" target="ajax" call="goodsHandle" dataType="json">';echo $statebtn;echo '</a> | <a href="#" onclick="scoreEditGoods(';echo $var['id'];echo ')">修改</a> | <a href="/admin.php/Score/goodsDel/';echo $var['id'];echo '" target="ajax" call="goodsHandle" dataType="json">删</a></td>
		</tr> 
	';}else{;echo '		<tr>
			<td colspan="9" align="center">暂时还没有商品。</td>
		</tr>
	';};echo '	</tbody> 
    </table>
	<footer>
	';
$rel=get_class($this).'/goodsList-{page}?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$data['total'],$rel,'betLogSearchPageAction');
;echo '	</footer>
    </div><!-- end of .tab_container -->
</article><!-- end of content manager article -->
';
?>