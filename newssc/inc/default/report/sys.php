<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';$this->display('inc_skin.php',0 ,'系统报表查询');;echo '</head>
<body>
<div class="all">
	<!--top-->
    ';$this->display('report/inc_header.php');;echo '	<!--top end-->
    <div class="game">
        <!--游戏body-->
		<div class="game-left img-bj game-left2">
			<div class="biao-top">
				<div class="top1">
					<span class="spn-z">从</span>
					<div class="fqr"><input class="fqr-in" height="20" name="fromTime" type="date"/></div>
					<span class="spn-z">至</span>
					<div class="fqr"><input class="fqr-in" height="20" name="fromTime" type="date"/></div>
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
				<table width="100%">
					<thead class="tr-top">
					<tr>
						<td>用户名</td>
						<td>投注金额</td>
						<td>奖金</td>
						<td>返点</td>
						<td>亏反</td>
						<td>佣金</td>
						<td>个人盈亏</td>
						<td>查看下级</td>
					</tr>
					</thead>
					<tbody class="tr-cont">
					<tr>
						<td>zhangsan</td>
						<td>1000254</td>
						<td>1750</td>
						<td>3.5%</td>
						<td>？？</td>
						<td>？？</td>
						<td>-1200</td>
						<td><span class="qzbtn">查看下级</span></td>
					</tr>
					<tr>
						<td>zhangsan</td>
						<td>1000254</td>
						<td>1750</td>
						<td>3.5%</td>
						<td>？？</td>
						<td>？？</td>
						<td>-1200</td>
						<td><span class="qzbtn">查看下级</span></td>
					</tr>
					<tr>
						<td>zhangsan</td>
						<td>1000254</td>
						<td>1750</td>
						<td>3.5%</td>
						<td>？？</td>
						<td>？？</td>
						<td>-1200</td>
						<td><span class="qzbtn">查看下级</span></td>
					</tr>
					<tr>
						<td>zhangsan</td>
						<td>1000254</td>
						<td>1750</td>
						<td>3.5%</td>
						<td>？？</td>
						<td>？？</td>
						<td>-1200</td>
						<td><span class="qzbtn">查看下级</span></td>
					</tr>
					<tr>
						<td><span class="spn9">本页总结</span></td>
						<td>1000254</td>
						<td>1750</td>
						<td>3.5%</td>
						<td>？？</td>
						<td>？？</td>
						<td>-1200</td>
						<td><span class="qzbtn">查看下级</span></td>
					</tr>
					<tr>
						<td><span class="spn9">全部总结</span></td>
						<td>1000254</td>
						<td>1750</td>
						<td>3.5%</td>
						<td>？？</td>
						<td>？？</td>
						<td>-1200</td>
						<td><span class="qzbtn">查看下级</span></td>
					</tr>
					</tbody>
				</table>
				<!--下注列表 end -->
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
';
?>