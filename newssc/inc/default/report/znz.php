<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'庄内庄报表查询');;echo '</head>
<body>
<div class="all">
	<!--top-->
    ';$this->display('report/inc_header.php');;echo '	<!--top end-->
    <div class="game">
        <!--游戏body-->
		<div class="game-left">
			<div class="biao-top">
				<div class="top1">
					<span class="spn-z">从</span>
					<div class="fqr"><input class="fqr-in" height="20" name="fromTime" type="date"/></div>
					<span class="spn-z">至</span>
					<div class="fqr"><input class="fqr-in" height="20" name="toTime" type="date"/></div>
					<span class="jg"></span>
					<span class="jg"></span>
					<div class="qz">
							<div class="box0"><div class="box1"><div class="box2">
							<select name=inout class="select1">
								<option value="所有人" selected>所有人</option>
								<option value="我自己">我自己</option>
								<option value="我的下线">直属下线</option>
								<option value="我的下线">所有下线</option>
							</select>
							</div></div></div>
						</div>
						<span class="jg"></span>
						<input class="fqr-in" height="20" value="用户名" onfocus="if(this.value==\'用户名\') this.value=\'\'"  onblur="if(this.value==\'\') this.value=\'用户名\'"/>
					<span class="jg"></span>
					<div class="chazhao img02">查询</div>
				</div>
			</div>
			<div class="biao-cont img02 report-znz-cont">
				<!--下注列表-->
				<table class="tb-znz" cellpadding="0" cellspacing="0">
					<thead class="tr-top znz-tl-w">
					<tr>
						<td class="td00">用户名</td>
						<td class="td00">查看下级</td>
						<td class="td00">抢庄盈亏</td>
						<td class="td01">
							<div class="znz-tb-tle1">庄内庄投注额<div>
							<div class="znz-tb-tle1"><div class="znz-tb-tle2">发单</div><div class="znz-tb-tle3">抢单</div></div>
						</td>
						<td class="td01">
							<div class="znz-tb-tle1">抢庄抽水金额<div>
							<div class="znz-tb-tle1"><div class="znz-tb-tle2">发单</div><div class="znz-tb-tle3">抢单</div></div>
						</td>

						<td class="td01">
							<div class="znz-tb-tle1">抢庄抽水回馈<div>
							<div class="znz-tb-tle1"><div class="znz-tb-tle2">发单</div><div class="znz-tb-tle3">抢单</div></div>
						</td>

						<td class="td01">
							<div class="znz-tb-tle1">抢庄返点<div>
							<div class="znz-tb-tle1"><div class="znz-tb-tle2">发单</div><div class="znz-tb-tle3">抢单</div></div>
						</td>
						<td class="td01">
							<div class="znz-tb-tle1">抢庄赔付金额<div>
							<div class="znz-tb-tle1"><div class="znz-tb-tle2">发单</div><div class="znz-tb-tle3">抢单</div></div>
						</td>
					</tr>
					</thead>
					<tbody class="tr-cont">
					<tr>
						<td>myq0</td>
						<td><span class="qzbtn">查看下级</span></td>
						<td>124.00</td>
						<td class="td01-c"><div class="td-cont1">156</div><div class="td-cont2">465</div></td>
						<td class="td01-c"><div class="td-cont1">156</div><div class="td-cont2">465</div></td>
						<td class="td01-c"><div class="td-cont1">156</div><div class="td-cont2">465</div></td>
						<td class="td01-c"><div class="td-cont1">156</div><div class="td-cont2">465</div></td>
						<td class="td01-c"><div class="td-cont1">156</div><div class="td-cont2">465</div></td>
					</tr>
					</tbody>
				</table>
				<!--下注列表 end -->
			</div>
			
		</div>
      
        </div>
    </div>
</div>
<!--底部-->
		';$this->display('foot.php');;echo '		<!--底部  end-->
</body>
</html>
';
?>