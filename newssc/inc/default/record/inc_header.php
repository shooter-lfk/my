<?php
echo '<script>
$(function(){
	$(".info dl").each(function(){
		var txt = $(this).parent().siblings().attr("src");
		$(this).html(txt);
	})
			
	$(".menu li").click(function(){
		var index = $(this).index();
		$(this).addClass("current").siblings().removeClass("current");
		$(".content li").eq(index).show().siblings().hide();
	})
		    
})
</script>
	<div class="container">
		<div class="menu">
			<ul>
				<li class="current">团队管理</li>
				<li>购彩大厅</li>
				<li>账户管理</li>
			</ul>
		</div>
            
		<div class="content">
		<ul>
			<li>
				<div class="info">
					<dl class="dhleft">
							<dd ';echo $this->iff($this->action=='addMember','class="current img01"');echo '><a href="/index.php/team/addMember" class="d_adu">新增成员</a></dd>
							<dd ';echo $this->iff($this->action=='memberList','class="current img01"');echo '><a href="/index.php/team/memberList" class="d_uls">成员列表</a></dd>
							<dd ';echo $this->iff($this->action=='advLink','class="current img01"');echo '><a href="/index.php/team/advLink" class="d_onl">推广链接</a></dd>
							<!--dd ';echo $this->iff($this->action=='fanDian','class="current img01"');echo '><a href="/index.php/report/fanDian" class="u_dps">返点总额</a></dd-->
							<dd ';echo $this->iff($this->userType=='me','class="current img01"');echo '><a href="/index.php/record/search/me" class="u_gjl">游戏记录</a></dd>
							<dd ';echo $this->iff($this->userType=='team','class="current img01"');echo '><a href="/index.php/record/search/team" class="d_gba">团队游戏记录</a></dd>
							<dd ';echo $this->iff($this->action=='coinlog','class="current img01"');echo '><a href="/index.php/report/coin" class="u_yjl">帐变列表</a></dd>
							<dd ';echo $this->iff($this->action=='count','class="current img01"');echo '><a href="/index.php/report/count" class="d_gre">结算报表</a></dd>
							<dd ';echo $this->iff($this->action=='cashRecord','class="current img01"');echo '><a href="/index.php/team/cashRecord" class="u_otm">提现报表</a></dd>
							<dd ';echo $this->iff($this->userType=='zhuih','class="current img01"');echo '><a href="/index.php/record/search/zhuih" class="u_gjl">追号记录</a></dd>
							<!--dd ';echo $this->iff($this->action=='coin','class="current img01"');echo '><a href="/index.php/team/coin" class="d_gba">团队金额</a></dd>
							<dd ';echo $this->iff($this->action=='sys','class="current img01"');echo '><a href="/index.php/report/sys" class="cai">系统报表查询</a></dd>
							<dd ';echo $this->iff($this->action=='znz','class="current img01"');echo '><a href="/index.php/report/znz" class="cai">庄内庄报表查询</a></dd-->
					</dl>
				</div>
			</li>
			<li>
				<div class="info">
					<dl class="dhleft">
							';
$sql="select id,type,title,shortName,defaultViewGroup from {$this->prename}type where isDelete=0 and enable=1 order by sort";
if($types=$this->getRows($sql))
foreach($types as $key=>$var){
if(!$this->type) $this->type=$var['id'];
if($var['id']!=14){
;echo '							<dd ';echo ($var['id']==$this->type)?' class="current"':'';echo '><a href="/index.php/index/main/';echo $var['id'];echo '/';echo $var['defaultViewGroup'];echo '" class="act';echo $var['id'];echo '">';echo $var['title'];echo '</a></dd>
							';}else{;echo '							<dd ';echo ($var['id']==$this->type)?' class="current img01"':'';echo '><a href="/index.php/TempMyq/typeTemp/';echo $var['id'];echo '" target="modal" width="445" height="100" button="确定:defaultModalCloase" class="act';echo $var['id'];echo '">';echo $var['title'];echo '</a></dd>
							';}};echo '					</dl>						
				</div>
			</li>
			<li>
				<div class="info">
					<dl class="dhleft">
							<dd ';echo $this->iff($this->action=='info','class="current img01"');echo '><a href="/index.php/safe/info" class="u_uzl">基本资料</a></dd>
							<dd ';echo $this->iff($this->action=='passwd','class="current img01"');echo '><a href="/index.php/safe/passwd" class="u_dps">密码管理</a></dd>
							<dd ';echo $this->iff($this->controller=='Score','class="current img01"');echo '><a href="/index.php/score/goods/current" class="u_mjs">积分兑换</a></dd>
							<dd ';echo $this->iff($this->action=='recharge','class="current img01"');echo '><a href="/index.php/cash/recharge" class="u_itm">充值</a></dd>
							<dd ';echo $this->iff($this->action=='rechargeLog','class="current img01"');echo '><a href="/index.php/cash/rechargeLog" class="u_itm">充值记录</a></dd>
							<dd ';echo $this->iff($this->action=='toCash','class="current img01"');echo '><a href="/index.php/cash/toCash" class="u_otm">提现</a></dd>
							<dd ';echo $this->iff($this->action=='toCashLog','class="current img01"');echo '><a href="/index.php/cash/toCashLog" class="u_otm">提现记录</a></dd>
					</dl>
				</div>
			</li>
		</ul>
		</div>
	</div>
';
?>