<?php

$para=$_GET;
if(isset($para['date'])){
$date=strtotime($para['date']);
}else{
$date=strtotime('00:00');
}
$sql="select * from {$this->prename}type where id=?";
$typeInfo=$this->getRow($sql,$this->type);
$sql="select * from {$this->prename}data_time where type={$this->type} order by actionNo";
$times=$this->getPage($sql,$this->page,$this->pageSize);
$dateString=date('Y-m-d ');
$sql="select * from {$this->prename}data where type={$this->type} and ";
$sqlAmount="select sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount, sum(b.fanDianAmount) fanDianAmount from ssc_bets b where type={$this->type} and b.isDelete=0";
$all=$this->getRow($sqlAmount);
;echo '<article class="module width_full">
	<header>
		<h3 class="tabs_involved">';echo $typeInfo['title'];echo '开奖数据
		<form class="submit_link wz" action="/admin.php/data/index/';echo $this->type;echo '" target="ajax" call="defaultSearch" dataType="html">
			期数：<input name="actionNo" type="text"  />
			<label style="margin-left:30px;"><a class="item" href="data/index/';echo $this->type;echo '';echo $args[0]['id'];echo '?date=';echo date('Y-m-d',$date-24*3600);echo '">前一天</a></label>
			<label><a class="item" href="data/index/';echo $this->type;echo '';echo $args[0]['id'];echo '?date=';echo date('Y-m-d',$this->time);echo '">今天</a></label>
			<label><a class="item" href="data/index/';echo $this->type;echo '';echo $args[0]['id'];echo '?date=';echo date('Y-m-d',$date+24*3600);echo '">后一天</a></label>
			<label>日期：<input name="date" type="date" /></label>
			<input type="submit" value="查找" class="alt_btn">
			<input type="reset" value="重置条件">
		</form>
		</h3>
	</header>

	<table class="tablesorter" cellspacing="0">
		<thead>
			<tr>
				<th>彩种</th>
				<th>场次</th>
				<th>期数</th>
				<th>日期</th>
				<th>开奖数据</th>
				<th>状态</th>
				<th>开奖时间</th>
				<th>投注金额</th>
				<th>中奖金额</th>
				<th>返点金额</th>
				<th>手动开奖</th>
			</tr>
		</thead>
		<tbody>
			';
$count=array();
if($para['actionNo']) $times=array('data'=>array('id'=>'--'));
$dateString=date('Y-m-d ',$date);
foreach($times['data'] as $var){
if($para['actionNo']){
$data=$this->getRow("select * from {$this->prename}data where type={$this->type} and  number='{$para['actionNo']}'");
$date=$data['time'];
$var=array('actionNo'=>'--','actionTime'=>date('Y-m-d H:i:s',$date));
$dateString='';
}else{
if($this->type==3||$this->type==6||$this->type==7||$this->type==15||$this->type==16||$this->type==17||$this->type==18||$this->type==20||$this->type==21){
$number=1000+$var['actionNo'];
$number=date('Ymd-',$date).substr($number,1);
$sql="select * from {$this->prename}data where type={$this->type} and number='$number'";
$data=$this->getRow($sql);
}else if($this->type==11){
$number=100+$var['actionNo'];
$number=date('Ymd-',$date).substr($number,1);
$sql="select * from {$this->prename}data where type={$this->type} and number='$number'";
$data=$this->getRow($sql);
}else if($this->type==19){
$number=substr(date('Yz',$date),4,6)*179+$var['actionNo']+337580;
$sql="select * from {$this->prename}data where type={$this->type} and number='$number'";
$data=$this->getRow($sql);
}else{
$data=$this->getRow($sql .'time='.strtotime($dateString .$var['actionTime']));
}
}
if($data['data']){
$amountData=$this->getRow($sqlAmount." and actionNo=?",$data['number']);
}else{
$amountData=array();
}
$count['betAmount']+=$amountData['betAmount'];
$count['zjAmount']+=$amountData['zjAmount'];
$count['fanDianAmount']+=$amountData['fanDianAmount'];
;echo '			<tr>
				<td>';echo $typeInfo['title'];echo '</td>
				<td>';echo $var['actionNo'];echo '</td>
				<td>';echo $this->ifs($data['number'],'--');echo '</td>
				<td>';echo date('Y-m-d',$date);echo '</td>
				<td>';echo $this->ifs($data['data'],'--');echo '</td>
				<td>';echo $this->iff($data['data'],'已开奖','未开奖');echo '</td>
				<td>';echo $dateString.$var['actionTime'];echo '</td>
				<td>';echo $this->ifs($amountData['betAmount'],'--');echo '</td>
				<td>';echo $this->ifs($amountData['zjAmount'],'--');echo '</td>
				<td>';echo $this->ifs($amountData['fanDianAmount'],'--');echo '</td>
				<td>
					<a href="/admin.php/data/add/';echo $this->type;echo '/';echo $var['actionNo'];echo '/';echo $dateString.$var['actionTime'];echo '" target="modal" width="340" title="添加开奖号码" modal="true" button="确定:dataAddCode|取消:defaultCloseModal">添加</a>
					';if($data['data']){;echo '					<a href="/admin.php/data/kj" target="ajax" data-type="';echo $typeInfo['id'];echo '" data-number="';echo $data['number'];echo '" data-time="';echo $dateString.$var['actionTime'];echo '" data-data="';echo $data['data'];echo '" onajax="setKjData" call="setKj" title="重新对没有开奖的投注开奖">开奖</a>
					';};echo '				</td>
			</tr>
			';};echo '            <tr>
                <td><span class="spn9">本页总结</span></td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td>';echo $this->ifs($count['betAmount'],'--');echo '</td>
                <td>';echo $this->ifs($count['zjAmount'],'--');echo '</td>
                <td>';echo $this->ifs($count['fanDianAmount'],'--');echo '</td>
                <td>--</td>
            </tr>
            <tr>
                <td><span class="spn9">全部总结</span></td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td>';echo $this->ifs($all['betAmount'],'--');echo '</td>
                <td>';echo $this->ifs($all['zjAmount'],'--');echo '</td>
                <td>';echo $this->ifs($all['fanDianAmount'],'--');echo '</td>
                <td>--</td>
            </tr>

		</tbody>
	</table>
	<footer>
	';
if($para){
$rel.='?'.http_build_query($para,'','&');
}
$rel=$this->controller.'/'.$this->action .'-{page}/'.$this->type.'?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$times['total'],$rel,'dataPageAction');
;echo '	</footer>
</article>';
?>