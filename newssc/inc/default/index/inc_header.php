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
				<li class="current">选择彩种</li>
				<li>账户管理</li>
				<li>团队管理</li>
			</ul>
		</div>
            
		<div class="content">
		<ul>
			<li>
				<div class="info">
					<dl class="dhleft lotclas">
						';
$sql="select id,type,title,shortName,defaultViewGroup from {$this->prename}type where isDelete=0 and enable=1 order by sort";
if($types=$this->getRows($sql))
foreach($types as $key=>$var){
if(!$this->type) $this->type=$var['id'];
if($var['id']!=14){
;echo '						<dd';echo ($var['id']==$this->type)?' class="current"':'';echo '><a href="/index.php/index/main/';echo $var['id'];echo '/';echo $var['defaultViewGroup'];echo '" class="act';echo $var['id'];echo '">';echo $var['title'];echo '</a></dd>
						';}else{;echo '						<dd';echo ($var['id']==$this->type)?' class="current img01"':'';echo '><a onClick="art.dialog.open(\'/index.php/TempMyq/typeTemp/';echo $var['id'];echo '\', {id: \'testID3\',lock: true,title: \'提示\'});" class="act';echo $var['id'];echo '">';echo $var['title'];echo '</a></dd>
						';}};echo '					</dl>						
				</div>
			</li>
			<li style="display:none;">
				<div class="info">
					<dl class="dhleft">
							<dd ';echo $this->iff($this->action=='info','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/safe/info\', {id: \'testID3\',lock: true,title: \'个人资料管理\',width:542, height:360});" class="u_uzl">基本资料</a></dd>
							<dd ';echo $this->iff($this->action=='passwd','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/safe/passwd\', {id: \'testID3\',lock: true,title: \'密码管理\',width:542, height:428});" class="u_dps">密码管理</a></dd>
							<dd ';echo $this->iff($this->controller=='Score','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/score/goods/current\', {id: \'testID3\',lock: true,title: \'积分兑换\',width:720, height:458});" class="u_mjs">积分兑换</a></dd>
							<dd ';echo $this->iff($this->action=='recharge','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/cash/recharge\', {id: \'testID3\',lock: true,title: \'自动到账充值系统\',width:542, height:428});" class="u_itm">充值</a></dd>
							<dd ';echo $this->iff($this->action=='rechargeLog','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/cash/rechargeLog\', {id: \'testID3\',lock: true,title: \'充值记录\',width:720, height:475});" class="u_itm">充值记录</a></dd>
							<dd ';echo $this->iff($this->action=='toCash','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/cash/toCash\', {id: \'testID3\',lock: true,title: \'提现\',width:542, height:318});" class="u_otm">提现</a></dd>
							<dd ';echo $this->iff($this->action=='toCashLog','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/cash/toCashLog\', {id: \'testID3\',lock: true,title: \'提现记录\',width:720, height:475});" class="u_otm">提现记录</a></dd>
							<dd ';echo $this->iff($this->userType=='me','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/record/search/me\', {id: \'testID3\',lock: true,title: \'游戏记录\',width:720, height:475});" class="u_gjl">游戏记录</a></dd>
							<!--dd ';echo $this->iff($this->userType=='zhuih','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/record/search/zhuih\', {id: \'testID3\',lock: true,title: \'追号记录\',width:720, height:475});" class="u_gjl">追号记录</a></dd-->
					</dl>
				</div>
			</li>
			<li style="display:none;">
				<div class="info">
					<dl class="dhleft">
							<dd ';echo $this->iff($this->action=='addMember','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/team/addMember\', {id: \'testID3\',lock: true,title: \'新增会员\',width:500, height:320});" class="d_adu">新增成员</a></dd>
							<dd ';echo $this->iff($this->action=='memberList','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/team/memberList\', {id: \'testID3\',lock: true,title: \'会员列表\',width:720, height:475});" class="d_uls">成员列表</a></dd>
							<dd ';echo $this->iff($this->action=='advLink','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/team/advLink\', {id: \'testID3\',lock: true,title: \'推广链接\',width:502, height:180});" class="d_onl">推广链接</a></dd>
							<dd ';echo $this->iff($this->userType=='team','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/record/search/team\', {id: \'testID3\',lock: true,title: \'团队游戏记录\',width:720, height:475});" class="u_gjl">团队游戏记录</a></dd>
							<dd ';echo $this->iff($this->action=='coinlog','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/report/coin\', {id: \'testID3\',lock: true,title: \'帐变报表\',width:720, height:475});" class="u_yjl">帐变报表</a></dd>
							<dd ';echo $this->iff($this->action=='count','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/report/count\', {id: \'testID3\',lock: true,title: \'结算报表\',width:720, height:535});" class="d_gre">结算报表</a></dd>
							<dd ';echo $this->iff($this->action=='coin','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/team/coin\', {id: \'testID3\',lock: true,title: \'团队金额\',width:380, height:230});" class="d_gba">团队金额</a></dd>
							<dd ';echo $this->iff($this->action=='cashRecord','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/team/cashRecord\', {id: \'testID3\',lock: true,title: \'提现报表\',width:720, height:475});" class="u_otm">提现报表</a></dd>
							<!--dd ';echo $this->iff($this->action=='sys','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/report/sys\', {id: \'testID3\',lock: true,title: \'系统报表查询\',width:720});" class="cai">系统报表查询</a></dd>
							<dd ';echo $this->iff($this->action=='znz','class="current img01"');echo '><a onClick="art.dialog.open(\'/index.php/report/znz\', {id: \'testID3\',lock: true,title: \'庄内庄报表查询\',width:720});" class="cai">庄内庄报表查询</a></dd-->
					</dl>
				</div>
			</li>
		</ul>
		</div>
	</div>
';
?>