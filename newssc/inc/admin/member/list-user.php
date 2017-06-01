<?php

$sql="select u.*, sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount, (select sum(c.amount) from ssc_member_cash c where c.`uid`=u.`uid` and c.state=0 ) cashAmount,(select sum(r.amount) from ssc_member_recharge r where r.`uid`=u.`uid` and r.state in(1,2,9) ) rechargeAmount from ssc_members u left join ssc_bets b on u.uid=b.uid and b.isDelete=0  where 1 ";
if($_GET['username']&&$_GET['username']!="用户名"){
$sql.=" and u.username='{$_GET['username']}' or u.qq='{$_GET['username']}'";
}else{
unset($_GET['username']);
}
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
$sql.=' group by u.uid';
switch($_GET['paixu']){
case 'uid':
$sql.=" order by u.uid asc";
break;
case 'coin':
$sql.=" order by u.coin desc";
break;
case 'betAmount':
$sql.=" order by betAmount desc";
break;
case 'zjAmount':
$sql.=" order by zjAmount desc";
break;
case 'fanDian':
$sql.=" order by u.fanDian desc";
break;
case 'score':
$sql.=" order by u.scoreTotal desc";
break;
default:
$sql.=" order by u.uid asc";
break;
}
$data=$this->getPage($sql,$this->page,$this->pageSize);
$sql="select sum(coin) from {$this->prename}coin_log where uid=? and liqType between 2 and 3";
$sql="select uid, username from {$this->prename}members where uid=? and enable=1 and isDelete=0";
$sql="select * from {$this->prename}member_session where uid=? order by id desc limit 1";
;echo '<script>
</script>
<table class="tablesorter" cellspacing="0"> 
<thead> 
    <tr> 
        <th>用户名</th> 
        <th>UserID</th> 
        <th>类型</th> 
        <th>可用/冻结</th> 
        <th>积分/累计积分/等级</th> 
        <th>中奖/返点</th> 
        <th>投注/盈亏</th>
        <th>返点/不定点</th> 
        <th>状态</th> 
        <th>最后登录</th> 
        <th>操作</th> 
    </tr> 
</thead> 
<tbody> 

';
if($data['data']) foreach($data['data'] as $var){
$var['fanDianAmount']=$this->getValue($sql,$var['uid']);
$login=$this->getRow($sql,$var['uid']);
;echo '	';
if($var['isDelete']==0){
;echo '    <tr title="';echo implode('> ',$this->getCol("select username from {$this->prename}members where uid in ({$var['parents']})"));echo '"> 
        <td>';echo $var['username'];echo '</td> 
        <td>';echo $var['uid'];echo '</td> 
        <td>';if($var['type']){echo'代理';}else{echo '会员';};echo '</td> 
        <td>';echo $var['coin'];echo '<span class=\'spn10\'>/</span>';echo $var['fcoin'];echo '</td> 
        <td>';echo $var['score'];echo '<span class=\'spn10\'>/</span>';echo $var['scoreTotal'];echo '<span class=\'spn10\'>/</span>';echo $var['grade'];echo '</td> 
        <td>';echo $this->ifs($var['zjAmount']);echo '<span class=\'spn10\'>/</span>';echo $this->ifs($var['fanDianAmount']);echo '</td> 
        <td>';echo $this->ifs($var['betAmount']);echo '<span class=\'spn10\'>/</span>';echo $this->ifs($var['zjAmount']-$var['betAmount']+$var['fanDianAmount']);echo '</td>
        <td>';echo $var['fanDian'];echo '%<span class=\'spn10\'>/</span>';echo $var['fanDianBdw'];echo '%</td> 
        <td>';echo $this->iff($login['isOnLine'] &&$login['accessTime']>$GLOBALS['conf']['member']['sessionTime'],'在线','离线');echo '</td>
        <td>';echo $var['updateTime'];echo '</td> 
        <td><!--a href="/admin.php/Member/userAmount/';echo $var['uid'];echo '" target="modal"  width="420" title="用户统计" modal="true">统计</a> / --><a href="business/coinLog?username=';echo $var['username'];echo '">帐变</a> / <a href="/admin.php/Member/userUpdate/';echo $var['uid'];echo '" target="modal"  width="420" title="编辑用户" modal="true" button="确定:dataAddCode|取消:defaultCloseModal">编辑</a> / <a href="Member/index?type=2&uid=';echo $var['uid'];echo '" call="">下级</a><!-- / <a href="/Member/userout/';echo $var['uid'];echo '" call="">强制下线</a--> / <a href="/admin.php/Member/isOnLine/';echo $var['id'];echo '" target="ajax" call="userisOnLine">';echo $this->iff($var['enable'],'关闭','开启');echo '</a> / <a href="/admin.php/Member/delete/';echo $var['uid'];echo '" target="modal"  width="320" title="删除用户" modal="true" button="确定:dataAddCode">删</a></td> 
    </tr>
   ';}else{;echo '    <tr> 
        <td class="spn9">';echo $var['username'];echo '</td> 
        <td class="spn9">';echo $var['uid'];echo '</td> 
        <td class="spn9">';if($var['type']){echo'代理';}else{echo '会员';};echo '</td> 
        <td class="spn9">';echo $var['coin'];echo '<span class=\'spn10\'>/</span>';echo $var['fcoin'];echo '</td> 
        <td class="spn9">';echo $var['score'];echo '<span class=\'spn10\'>/</span>';echo $var['scoreTotal'];echo '<span class=\'spn10\'>/</span>';echo $var['grade'];echo '</td> 
        <td class="spn9">';echo $this->ifs($var['zjAmount'],'--');echo '<span class=\'spn10\'>/</span>';echo $var['fanDianAmount'];echo '</td> 
        <td class="spn9">';echo $this->ifs($var['betAmount'],'--');echo '<span class=\'spn10\'>/</span>';echo $this->ifs($var['zjAmount']-$var['betAmount']+$var['fanDianAmount'],'--');echo '</td>
        <td class="spn9">';echo $var['fanDian'];echo '%<span class=\'spn10\'>/</span>';echo $var['fanDianBdw'];echo '%</td> 
        <td class="spn9">';echo $this->iff($login['isOnLine'] &&$login['accessTime']>$GLOBALS['conf']['member']['sessionTime'],'在线','离线');echo '</td> 
        <td class="spn9">';echo $var['updateTime'];echo '</td> 
        <td class="spn9"><!--a href="/admin.php/Member/userAmount/';echo $var['uid'];echo '" target="modal"  width="420" title="用户统计" modal="true">统计</a> / --><a href="business/coinLog?username=';echo $var['username'];echo '">帐变</a> / <a href="Member/index?type=2&uid=';echo $var['uid'];echo '" call="">下级</a></td> 
    </tr>
	';}};echo '</tbody> 
</table>
<footer>
	';
$rel=get_class($this).'/index-{page}?'.http_build_query($_GET,'','&');
$this->display('inc/page.php',0,$data['total'],$rel,'defaultReplacePageAction');
;echo '</footer>';
?>