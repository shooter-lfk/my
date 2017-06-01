<?php

$para=$_GET;
if($para['username'] &&$para['username']!="用户名"){
$userWhere="and u.username like '%{$para['username']}%'";
}
if($para['fromTime'] &&$para['toTime']){
$fromTime=strtotime($para['fromTime']);
$toTime=strtotime($para['toTime'])+24*3600;
$timeWhere="and c.actionTime between $fromTime and $toTime";
}elseif($para['fromTime']){
$fromTime=strtotime($para['fromTime']);
$timeWhere="and c.actionTime>=$fromTime";
}elseif($para['toTime']){
$toTime=strtotime($para['toTime'])+24*3600;
$timeWhere="and c.actionTime<$fromTime";
}else{
$timeWhere=' and c.actionTime>'.strtotime('00:00');
}
$sql="select b.name bankName, c.*, u.username userAccount from {$this->prename}bank_list b, {$this->prename}member_cash c, {$this->prename}members u where c.bankId=b.id and c.uid=u.uid and c.state<5 and b.isDelete=0 and c.isDelete=0  $timeWhere $userWhere order by c.id desc";
$data=$this->getPage($sql,$this->page,$this->pageSize);
$stateName=array('已到帐','申请中','已取消','已支付','已失败','已删除');
;echo '<table class="tablesorter" cellspacing="0">
<thead>
    <tr>
        <th>UserID</th>
        <th>用户名</th>
        <th>提现金额</th>
        <th>银行类型</th>
        <th>开户姓名</th>
        <th>银行账号</th>
        <th>时间</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
</thead>
<tbody>
';if($data['data']) foreach($data['data'] as $var){;echo '    <tr>
        <td>';echo $var['uid'];echo '</td>
        <td>';echo $var['userAccount'];echo '</td>
        <td>';echo $var['amount'];echo '</td>
        <td>';echo $var['bankName'];echo '</td>
        <td>';echo $var['username'];echo '</td>
        <td>';echo $var['account'];echo '</td>
        <td>';echo date('Y-m-d H:i',$var['actionTime']);echo '</td>
        <td>
        ';
if($var['state']==3){
echo '<div class="sure" id="',$var['id'],'"></div>';
}else if($var['state']==4){
echo '<span title="'.$var['info'].'" style="cursor:pointer; color:#f00;">'.$stateName[$var['state']].'</span>';
}else{
echo $stateName[$var['state']];
}
;echo '        </td>
        <td align="center">
        ';if($var['state']==0 ||$var['state']==2 ||$var['state']==4){;echo '            <a href="/admin.php/business/cashLogDelete/';echo $var['id'];echo '" target="ajax" call="cashLogDelete" dataType="json">删除</a>
        ';}elseif($var['state']==1){;echo '            <a href="/admin.php/business/cashActionModal/';echo $var['id'];echo '" target="modal"  width="420" title="提款处理" modal="true" button="确定:dataAddCode|取消:defaultCloseModal">处理</a>
        ';}elseif($var['state']>=3){;echo '            --
        ';};echo '        </td>
    </tr>
';}else{;echo '    <tr>
        <td colspan="8" align="center">暂时没有提现记录。</td>
    </tr>
';};echo '</tbody>
</table>
<footer>
';
$rel=get_class($this).'/cashLog-{page}?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$data['total'],$rel,'defaultReplacePageAction');
;echo '</footer>';
?>