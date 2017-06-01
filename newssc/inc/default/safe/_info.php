<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'安全中心');;echo '</head>
<body>
<div class="all">
	<!--top-->
    	';$this->display('safe/inc_header.php');;echo '
	<!--top end-->
    

    <div class="game">
        <!--游戏body-->
    	<div class="game-left img-bj game-left2">
        	<div class="biao-top">
            	
                <div class="top2 img02 top3">
                	<ul class="notopline">
                	<li class="current img01">个人资料管理</li>
                	</ul>
                </div>
            </div>
            <div class="biao-cont img02 leftcont2">
                <!--个人资料-->
                <div class="tbbox1">
                	<div class="a-top"><div class="a-title spn9">基本信息</div></div>
                    <div class="aq-txt">登陆账号：</div><div class="t-a t-2"><div class="t-b">';echo $this->user['username'];echo '</div></div>
                    <div class="aq-txt">会员编号：</div><div class="t-a t-2"><div class="t-b">';echo $this->user['uid'];echo '</div></div>
                    <div class="aq-txt">等级：</div><div class="t-a t-2"><div class="t-b">';echo $this->user['grade'];echo '级</div></div>
                    <div class="aq-txt">积分：</div><div class="t-a t-2"><div class="t-b">';echo $this->user['score'];echo '</div></div>
                    <div class="aq-txt">会员类型：</div><div class="t-a t-2"><div class="t-b">';echo $this->iff($this->user['type'],'代理','会员');echo '</div></div>
                    <div class="aq-txt">上级代理：</div><div class="t-a t-2"><div class="t-b">';echo $this->getValue("select username from {$this->prename}member where uid=?",$this->user['parentId']);echo '</div></div>
                    <div class="aq-txt">返点：</div><div class="t-a t-2"><div class="t-b">';echo $this->user['fanDian'];echo '%</div></div>
                    <div class="aq-txt" style="width:80px; margin-left:2px;">不定位返点：</div><div class="t-a t-2"><div class="t-b">';echo $this->user['fanDianBdw'];echo '%</div></div>
                    <div class="aq-txt">可用资金：</div><div class="t-a t-a-w t-2"><div class="t-b t-b-w">';echo $this->user['coin'];echo '元</div></div>
                    <div class="aq-txt">冻结资金：</div><div class="t-a t-a-w t-2"><div class="t-b t-b-w">';echo $this->user['fcoin'];echo '元</div></div>
                    <div class="aq-txt">全部资金：</div><div class="t-a t-a-w t-2"><div class="t-b t-b-w">';echo $this->user['coin']+$this->user['fcoin'];echo '元</div></div>
                </div>

                <div class="tbbox1">
				<a name="bank-info"></a>
                	<div class="a-top"><div class="a-title spn9">银行信息</div></div>
                    <form action="/index.php/safe/setCBAccount" method="post" target="ajax" onajax="safeBeforSetCBA" call="safeSetCBA">
                    ';
if($this->user['coinPassword']){
;echo '                    <div class="aq-txt">银行类型：</div><div class="t-a t-2">
					';
$myBank=$this->getRow("select * from {$this->prename}member_bank where uid=?",$this->user['uid']);
$banks=$this->getRows("select b.name, b.home, m.username, m.account, m.id from {$this->prename}bank_list b, {$this->prename}member_bank m where m.admin=1 and m.enable=1 and b.isDelete=0 and b.id=m.bankId order by b.sort");
$flag=($myBank['editEnable']!=1)&&($myBank);
;echo '                    <select class="t-c" name="bankId" style="height:22px; width:210px;" ';echo $this->iff($flag,'disabled');echo '>
					';foreach($banks as $bank){;echo '                        <option value="';echo $bank['id'];echo '" ';echo $this->iff($myBank['bankId']==$bank['id'],'selected');echo '>';echo $bank['name'];echo '</option>
					';};echo '                    </select>
					</div>
                    <div class="aq-txt">银行账号：</div><div class="t-a t-2"><input name="account" class="t-c" value="';echo $myBank['account'];echo '" ';echo $this->iff($flag,'readonly');echo '/></div>
                    <div class="aq-txt">账户名：</div><div class="t-a t-2"><input name="username" class="t-c" value="';echo $myBank['username'];echo '" ';echo $this->iff($flag,'readonly');echo '/></div>
                    <!--<div class="aq-txt">密保邮箱：</div><div class="t-a t-2"><input name="safeEmail" class="t-c" value="';echo $this->user['safeEmail'];echo '"/></div>-->
                    <div class="aq-txt">资金密码：</div><div class="t-a t-a-w t-2"><input name="coinPassword" type="password" class="t-c t-c-w" ';echo $this->iff($flag,'readonly');echo '/></div>
                    <input type="submit" ';echo $this->iff($flag,'disabled');echo ' class="btn-a img01 xiugai" value="设置银行" />

                    ';}else{;echo '                    <div style="width:250px; float:left; height:24px; margin:6px;"></div>
                    <div class="tishi">设置银行信息要用资金密码，您尚未设置资金密码！&nbsp;&nbsp;<a href="/index.php/safe/passwd" style="text-decoration:none; color:#f00">设置资金密码>></a></div>
                    ';};echo '					
					';echo $this->iff(!$flag,'<div style="color:#f00; width:500px; margin-left:30px; float:left;">银行账号一旦设置，将不可修改，请认真设置！</div>') ;echo '
				</form>
                </div>
                <!--个人资料 end-->
            </div>
            
        </div>
        <!--游戏body  end-->
        <div class="game-right">
        	';
$this->display('user/inc_user_right.php');
$this->display('user/inc_score.php');
$this->display('user/inc_bulletin.php');
;echo '        </div>
    </div>
</div>
</body>
</html>
';
?>