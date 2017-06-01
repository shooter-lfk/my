<?php
echo '<!doctype html>
<html>
<head>
<meta content="IE=EmulateIE8" http-equiv="X-UA-Compatible" />
<meta charset="utf-8"/>
<title>内容管理系统</title>
<link rel="stylesheet" href="/skin/admin/layout.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="/skin/js/jqueryui/skin/smoothness/jquery-ui-1.8.23.custom.css" />
<!--[if IE]>
	<link rel="stylesheet" href="/skin/admin/ie.css" type="text/css" />
	<script src="/skin/js/html5.js"></script>
<![endif]-->
<script src="/skin/js/jquery-1.8.0.min.js"></script>
<script src="/skin/admin/onload.js"></script>
<script src="/skin/admin/function.js"></script>
<script src="/skin/admin/config.js"></script>
<script src="/skin/js/Array.ext.js"></script>
<script src="/skin/js/jqueryui/jquery-ui-1.8.23.custom.min.js"></script>
<script src="/skin/js/jqueryui/i18n/jquery.ui.datepicker-zh-CN.js"></script>
<script src="/skin/js/jquery.cookie.js"></script>

<script type="text/javascript">
$(function(){
	$(\'.quick_search input[name=username]\')
	.focus(function(){
		if(this.value==\'查找会员\') this.value=\'\';
	})
	.blur(function(){
		if(this.value==\'\') this.value=\'查找会员\';
	})
	.keypress(function(e){
		if(e.keyCode==13) $(this).closest(\'form\').submit();
	});
	
});

function searchUserSubmit(err,data){
	if(err){
		error(err);
	}else{
		$(\'#main\').html(data);
	}
}
var TIP=true;
</script>
</head>
<body class="body">

	<header id="header">
		<hgroup>
			<h1 class="site_title">内容管理系统</h1>
			<h2 class="section_title">
            	<a class="tjgk bq load" href="countData/index">统计概况</a><a class="txcl bq load" href="business/cashLog">提现处理</a>
            </h2>
            <div class="btn_view_site"><a href="/admin.php/user/logout">安全退出</a></div>
		</hgroup>
	</header>
	
	<section id="secondary_bar">
		<div class="user">
			<p>欢迎：';echo $this->user['name'];echo '<a href="/" target="_new">前台首页</a></p>
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs"><a>当前位置：<strong>首页</strong></a> <div class="breadcrumb_divider"></div> <span id="position"><a class="current">统计概况</a></span></article>
		</div>
	</section><!-- end of secondary bar -->
	
	<aside id="sidebar" class="column">
		<form action="/admin.php/member/listUser" class="quick_search" call="searchUserSubmit" dataType="html" target="ajax">
		  <input name="username" type="search" placeholder="查找会员" value="查找会员"/>
	    </form>
		<h3>业务流水<a>＋</a></h3>
		<ul class="toggle" style="display:none;">
			<!--<li><a class="bq yw_b_1" href="business/test1">SERVER</a></li>-->
			<li><a class="bq yw_b_1" href="business/cash">提现请求</a></li>
			<li><a class="bq yw_b_2" href="business/cashLog">提现记录</a></li>
			<li><a class="bq yw_b_3" href="business/rechargeLog">充值记录</a></li>
			<li><a class="bq yw_b_4" href="business/betLog">普通投注</a></li>
			<li><a class="bq yw_b_5" href="business/znzLog">庄内庄抢庄</a></li>
			<li><a class="bq yw_b_7" href="business/coinLog">帐变明细</a></li>
		</ul>
		<h3>开奖数据<a>＋</a></h3>
		<ul class="toggle" style="display:none;">
		';foreach($this->getRows("select id,title from {$this->prename}type where enable=1 and isDelete=0 order by sort") as $type){;echo '			<li><a href="data/index/';echo $type['id'];echo '" class="k_b_1 bq">';echo $type['title'];echo '</a></li>
		';};echo '		</ul>
		<h3>数据统计<a>－</a></h3>
		<ul class="toggle">
			<li><a href="countData/index" class="s_b_1 bq current">统计概况</a></li>
			<li><a href="countData/betDate" class="s_b_2 bq">综合统计</a></li>
		</ul>
		<h3>用户管理<a>＋</a></h3>
		<ul class="toggle" style="display:none;">
			<li><a href="member/add" class="yh_b_1 bq">增加会员</a></li>
			<li><a href="member/index" class="yh_b_2 bq">用户列表</a></li>
            <li><a href="member/bank" class="yh_b_4 bq">银行信息</a></li>
            <li><a href="member/loginLog" class="yh_b_5 bq">登录日志</a></li>
            <li><a href="member/userCountSetting" class="yh_b_5 bq">用户限额设置</a></li>
            
		</ul>
		<h3>管理人员<a>＋</a></h3>
		<ul class="toggle" style="display:none;">
			<li><a href="manage/index" class="g_b_1 bq">管理员列表</a></li>
            <!--<li><a href="#" class="g_b_2 bq">增加管理员</a></li>-->
            <li><a href="manage/controlLog" class="g_b_3 bq">操作日志</a></li>
            <li><a href="manage/loginLog" class="g_b_4 bq">登录日志</a></li>
		</ul>
		<h3>系统设置<a>＋</a></h3>
		<ul class="toggle" style="display:none;">
			<li><a href="system/settings" class="bq t_b_4">系统设置</a></li>
			<li><a href="system/notice" class="bq t_b_3">系统公告</a></li>
			<li><a href="system/bank" class="bq t_b_5">银行设置</a></li>
			<li><a href="system/type" class="bq t_b_8">彩种设置</a></li>
			<li><a href="system/played" class="bq t_b_9">玩法设置</a></li>
			<li><a href="member/level" class="yh_b_6 bq">等级设置</a></li>
			<!--<li><a href="System/service" class="bq yw_b_1">客服中心</a></li>-->
		</ul>


		
		<ul class="toggle" style="display:none;"></ul>

		<footer>
			<hr />
			<p><strong>Copyright &copy; 内容管理系统</strong></p>
		</footer>
	</aside><!-- end of sidebar -->

	<section id="message-tip"></section>
	<section id="main" class="column">';$this->display('count/index.php');;echo '</section>
</body>
</html>
';
?>