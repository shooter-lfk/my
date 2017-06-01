<?php
echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
';
$this->getTypes();
$this->getPlayeds();
$sql="select 3 ftype, z.betId id, z.type, z.playedId, z.qz_uid uid, z.qz_username username, z.actionNo, z.qz_time actionTime, z.info, z.liqType, z.fcoin from ssc_fcoin_znz z where z.qz_uid={$this->user['uid']}
union
select 2 ftype, c.rid id, '' `type`, '' playedId, c.uid, '' username, '' actionNo, c.actionTime, c.info, c.liqType, c.fcoin from ssc_fcoin_cash c where c.uid={$this->user['uid']}";
$list=$this->getPage($sql,$this->page,$this->pageSize);
$liqTypeName=array(
1=>'充值',
2=>'返点',
3=>'返点',
4=>'抽水金额',
5=>'停止追号',
6=>'中奖金额',
7=>'撤单',
8=>'提现冻结',
9=>'管理员充值',
10=>'解除抢庄冻结金额',
11=>'收单金额',
100=>'抢庄冻结金额',
101=>'投注',
102=>'追号投注',
103=>'抢庄返点金额',
104=>'抢庄抽水金额',
105=>'抢庄赔付金额',
106=>'提现冻结'
);
;echo '<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_1">
	<thead>
		<tr>
			<th>帐变类型</th>
			<th>冻结资金</th>
			<th>时间</th>
			<th>备注</th>
		</tr>
	</thead>
		';if($list['data']) foreach($list['data'] as $var){;echo '		<tr>
			<td>';echo $liqTypeName[$var['liqType']];echo '</td>
			<td>';echo $var['fcoin'];echo '</td>
			<td>';echo date('Y-m H:i',$var['actionTime']);echo '</td>
			<td>
				';if(in_array($var['liqType'],array(100,101,102))){;echo '					<a target="modal" button="关闭:defaultModalCloase" width="510" title="投注信息" href="/index.php/record/betInfo/';echo $var['id'];echo '">';echo $var['id'];echo '</a>
				';}elseif($var['id'] &&in_array($var['id'],array(1,8,9,106))){;echo '--';}else{;echo '--';};echo ' ';echo $this->types[$var['type']]['shortName'];echo '';echo $this->playeds[$var['playedId']]['name'];echo ' ';echo $var['actionNo'];echo '			</td>
		</tr>
		';};echo '</table>
';
$this->display('inc_page.php',0,$list['total'],$this->pageSize,"/index.php/{$this->controller}/{$this->action}-{page}/{$this->type}?$params");

?>