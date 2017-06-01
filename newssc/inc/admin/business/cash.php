<?php
echo '<script language="javascript">
function cashFalse(){
	$(\'.cashFalseSM\').css(\'display\',\'block\');
}
function cashTrue(){
	$(\'.cashFalseSM\').css(\'display\',\'none\');
	$(\'.cashFalseSM\').val()=false;
}
</script>
';
$sql="select b.name bankName, c.*, u.username userAccount from {$this->prename}bank_list b, {$this->prename}member_cash c, {$this->prename}members u where c.bankId=b.id and c.uid=u.uid and c.state=1";
$data=$this->getPage($sql,$this->page,$this->pageSize);
;echo '<article class="module width_full">
	<header><h3 class="tabs_involved">提现请求</h3></header>
	
	<table class="tablesorter" cellspacing="0">
	<thead>
		<tr>
			<th>UserID</th>
			<th>用户名</th>
			<th>提现金额</th>
			<th>银行类型</th>
			<th>开户姓名</th>
			<th>银行账号</th>
			<th>时间</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
	';if($data['data']) foreach($data['data'] as $var){;echo '		<tr>
			<td>';echo $var['uid'];echo '</td>
			<td>';echo $var['userAccount'];echo '</td>
			<td>';echo $var['amount'];echo '</td>
			<td>';echo $var['bankName'];echo '</td>
			<td>';echo $var['username'];echo '</td>
			<td>';echo $var['account'];echo '</td>
			<td>';echo date('Y-m-d H:i',$var['actionTime']);echo '</td>
			<td align="center">
			';if($var['state']==0 ||$var['state']==2 ||$var['state']==4){;echo '				<a href="/admin.php/business/cashLogDelete/';echo $var['id'];echo '">删除</a>
			';}elseif($var['state']==1){;echo '                <a href="/admin.php/business/cashActionModal/';echo $var['id'];echo '" target="modal"  width="420" title="提款处理" modal="true" button="确定:dataAddCode|取消:defaultCloseModal">处理</a>
			';}elseif($var['state']>=3){;echo '				--
			';};echo '			</td>
		</tr>
	';}else{;echo '		<tr>
			<td colspan="8" align="center">暂时没有人申请提现。</td>
		</tr>
	';};echo '	</tbody>
	</table>
	<footer>
	';
$rel=get_class($this).'/cash';
$this->display('inc/page.php',0,$data['total'],$rel);
;echo '	</footer>
</article>';
?>