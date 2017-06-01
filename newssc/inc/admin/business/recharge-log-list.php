<?php

$para=$_GET;
if($para['username'] &&$para['username']!="用户名"){
$userWhere="and u.username like '%{$para['username']}%'";
}
if($para['rechargeId'] &&$para['rechargeId']!="充值编号"){
$rechargeIdWhere="and c.rechargeId={$para['rechargeId']}";
}
if($para['type']){
if($para['type']==99){
$typeWhere="and c.state=0";
}else{
$typeWhere="and c.state={$para['type']}";
}
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
$sql="select c.*, u.username from {$this->prename}member_recharge c, {$this->prename}members u where c.uid=u.uid and c.isDelete=0  $rechargeIdWhere $timeWhere $userWhere $typeWhere order by c.id desc";
$data=$this->getPage($sql,$this->page,$this->pageSize);
$sql="select b.home, b.name, u.id, u.account, u.username from {$this->prename}member_bank u, {$this->prename}bank_list b where u.bankId=b.id and b.isDelete=0 and u.admin=1";
$bank=$this->getObject($sql,'id');
;echo '<table class="tablesorter" cellspacing="0">
<thead>
    <tr>
        <th>UserID</th>
        <th>用户名</th>
        <th>充值金额</th>
        <th>实际到账</th>
        <th>充值前资金</th>
        <th>充值编号</th>
        <th>充值银行</th>
        <th>状态</th>
        <th>备注</th>
        <th>时间</th>
        <th>操作</th>
    </tr>
</thead>
<tbody>
';if($data['data']) foreach($data['data'] as $var){;echo '    <tr>
        <td>';echo $var['uid'];echo '</td>
        <td>';echo $var['username'];echo '</td>
        <td>';echo $var['amount'];echo '</td>
        <td>';echo $this->iff($var['rechargeAmount']!=0,$var['rechargeAmount'],'--');echo '</td>
        <td>';echo $this->iff($var['state'],$var['coin'],'--');echo '</td>
        <td>';echo $var['rechargeId'];echo '</td>
        <td>';echo $var['BankId'];echo '</td>
        <td>';echo $this->iff($var['state'],'充值成功','正在充值');echo '</td>
        <td>';echo $var['info'];echo '</td>
        <td>';echo date('Y-m-d H:i',$var['actionTime']);echo '</td>
        <td>';if(!$var['state']){;echo '            <a href="/admin.php/business/rechargeActionModal/';echo $var['id'];echo '" target="modal"  width="420" title="到帐处理" modal="true" button="确定:dataAddCode|取消:defaultCloseModal">到帐处理</a>
            ';};echo '            <a href="/admin.php/business/rechargeDelete/';echo $var['id'];echo '" target="ajax" dataType="json" call="defaultAjaxLink">删除</a>
        </td>
    </tr>
';}else{;echo '    <tr>
        <td colspan="11" align="center">暂时没有充值记录。</td>
    </tr>
';};echo '</tbody>
</table>
<footer>
    ';
$rel=get_class($this).'/rechargeLog-{page}?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$data['total'],$rel,'defaultReplacePageAction');
;echo '</footer>';
?>