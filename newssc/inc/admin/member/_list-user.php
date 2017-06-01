<?php

$sql="select u.* from {$this->prename}members u where u.isDelete=0";
unset($_GET['username']);
switch($_GET['type']){
case 1:
$sql.=" and u.uid={$this->user['uid']}";
break;
case 2:
if(!$_GET['uid']) $_GET['uid']=$this->user['uid'];
$sql.=" and u.parentId={$_GET['uid']}";
break;
case 3:
$sql.="concat(',',u.parents,',') like '%,{$this->user['uid']},%' and u.uid!={$this->user['uid']}";
break;
default:
break;
}
if($_GET['uid']=$this->user['uid']) unset($_GET['uid']);
$data=$this->getPage($sql,$this->page,$this->pageSize);
;echo '<script>
</script>
<table class="tablesorter" cellspacing="0"> 
<thead> 
    <tr> 
        <th>用户名</th> 
        <th>UserID</th> 
        <th>类型</th> 
        <th>可用|冻结</th> 
        <th>积分|累计积分|等级</th> 
        <th>返点|分红</th> 
        <th>投注|中奖</th> 
        <th>返点|不定点</th> 
        <th>状态</th> 
        <th>最后登录</th> 
        <th>操作</th> 
    </tr> 
</thead> 
<tbody> 

';if($data['data']) foreach($data['data'] as $var){;echo '    <tr> 
        <td>';echo $var['username'];echo '</td> 
        <td>';echo $var['uid'];echo '</td> 
        <td>';if($var['type']){echo'会员';}else{echo '代理';};echo '</td> 
        <td>';echo $var['coin'];echo ' | ';echo $var['fcoin'];echo '</td> 
        <td>';echo $var['score'];echo ' | ';echo $var['score'];echo ' | ';echo $var['grade'];echo '</td> 
        <td>-- | --</td> 
        <td>-- | --</td> 
        <td>';echo $var['fanDian'];echo '% | ';echo $var['fanDianBdw'];echo '%</td> 
        <td>离线</td> 
        <td>';echo $var['updateTime'];echo '</td> 
        <td><a href="#">帐变</a> | <a href="/admin.php/Member/userUpdate/';echo $var['uid'];echo '" target="modal"  width="420" title="编辑用户" modal="true" button="确定:dataAddCode|取消:defaultCloseModal">编辑</a> | <a href="Member/index?type=2&uid=';echo $var['uid'];echo '" call="">下级</a> | <a href="Member/delete/';echo $var['uid'];echo '" target="ajax" dataType="json"  call="defaultAjaxLink">删</a></td> 
    </tr> 
	';};echo '</tbody> 
</table>
<footer>
	';
$rel=get_class($this).'/index-{page}?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$data['total'],$rel,'defaultReplacePageAction');
;echo '</footer>';
?>