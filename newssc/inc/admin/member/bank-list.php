<?php

$para=$_GET;
if($para['username'] &&$para['username']!="用户名"){
$userWhere="and u.username like '%{$para['username']}%'";
}
if($para['huming'] &&$para['huming']!="开户姓名"){
$userWhere="and i.username like '%{$para['username']}%'";
}
if($para['account'] &&$para['account']!="银行账号"){
$userWhere="and i.account={$para['account']}";
}
$sql="select b.name bankName, i.*, u.username userAccount from {$this->prename}member_bank i, {$this->prename}bank_list b, {$this->prename}members u where b.id=i.bankId and i.uid=u.uid and b.isDelete=0 and i.enable=1 $userWhere order by uid";
$data=$this->getPage($sql,$this->page,$this->pageSize);
;echo '<article class="module width_full">
    <header>
    	<h3 class="tabs_involved">银行信息
            <form action="/admin.php/member/bank" target="ajax" dataType="html" class="submit_link wz" call="defaultSearch" >
                会员名：<input type="text" class="alt_btn"  name="username" placeholder="会员名"/>&nbsp;&nbsp;
               <input type="submit" value="查找" class="alt_btn">
            </form>
        </h3>
    </header>
	<table class="tablesorter" cellspacing="0" width="100%">
		<thead>
			<tr>
				<td>会员编号</td>
				<td>用户名</td>
				<td>银行名称</td>
				<td>开户姓名</td>
				<td>银行账号</td>
				<td>操作</td>
			</tr>
		</thead>
		<tbody>
		';if($data['data']) foreach($data['data'] as $var){;echo '			<tr>
				<td>';echo $var['uid'];echo '</td>
				<td>';echo $var['userAccount'];echo '</td>
				<td>';echo $var['bankName'];echo '</td>
				<td><a href="/admin.php/member/bank/username=';echo $var['username'];echo '">';echo $var['username'];echo '</a></td>
				<td><a href="/admin.php/member/bank/username=';echo $var['account'];echo '">';echo $var['account'];echo '</a></td>
				<td><a href="#" onclick="EditBank(';echo $var['id'];echo ')">修改</a><!-- | <a href="/admin.php/member/deleteBank/';echo $var['id'];echo '" target="ajax" call="ReloadBank">删除</a>--></td>
			</tr>
		';}else{;echo '			<tr>
				<td colspan="5">暂时没有银行信息，请点右上角按钮添加银行</td>
			</tr>
		';};echo '		</tbody>
	</table>
	<footer>
	';
$rel=get_class($this).'/bank-{page}?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$data['total'],$rel,'defaultReplacePageAction');
;echo '	</footer>
</article>';
?>