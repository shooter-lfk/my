<?php

$sql="select m.*, b.name bankName, b.logo bankLogo, b.home bankHost from {$this->prename}member_bank m, {$this->prename}bank_list b where b.id=m.bankId and b.isDelete=0 and m.admin=1";
$data=$this->getPage($sql,$this->page,$this->pageSize);
;echo '<article class="module width_full">
	<header>
		<h3 class="tabs_involved">银行设置
			<div class="submit_link wz"><input type="submit" value="添加银行" onclick="sysEditBank()" class="alt_btn"></div>
		</h3>
	</header>
	<table class="tablesorter" cellspacing="0" width="100%">
		<thead>
			<tr>
				<td>银行</td>
				<td>标识</td>
				<td>账号</td>
				<td>持卡人</td>
				<td>状态(开/关)</td>
				<td>操作</td>
			</tr>
		</thead>
		<tbody>
		';if($data['data']) foreach($data['data'] as $var){;echo '			<tr>
				<td>';echo $var['bankName'];echo '</td>
				<td><img onclick="window.open(\'';echo $var['bankHost'];echo '\')" class="pointer" src="/';echo $var['bankLogo'];echo '" width="139" height="38" border="0"/></td>
				<td>';echo $var['account'];echo '</td>
				<td>';echo $var['username'];echo '</td>
				<td>';echo $this->iff($var['enable'],'开','关');echo '</td>
				<td><a href="/admin.php/system/switchBankStatus/';echo $var['id'];echo '" target="ajax" call="sysReloadBank">';echo $this->iff($var['enable'],'关闭','开启');echo '</a> | <a href="#" onclick="sysEditBank(';echo $var['id'];echo ')">修改</a> | <a href="/admin.php/system/deleteBank/';echo $var['id'];echo '" target="ajax" call="sysReloadBank">删除</a></td>
			</tr>
		';}else{;echo '			<tr>
				<td colspan="5">暂时没有银行信息，请点右上角按钮添加银行</td>
			</tr>
		';};echo '		</tbody>
	</table>
	<footer>
	';
$rel=get_class($this).'/notice-{page}?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$data['total'],$rel,'betLogSearchPageAction');
;echo '	</footer>
</article>';
?>