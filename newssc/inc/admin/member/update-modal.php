<?php
 
$sql="select * from {$this->prename}members where uid=?";
$userData=$this->getRow($sql,$args[0]);
if($userData['parentId']){
$parentData=$this->getRow("select fanDian, fanDianBdw from {$this->prename}members where uid=?",$userData['parentId']);
}else{
$this->getSystemSettings();
$parentData['fanDian']=$this->settings['fanDianMax'];
$parentData['fanDianBdw']=$this->settings['fanDianBdwMax'];
}
$sonFanDianMax=$this->getRow("select max(fanDian) sonFanDian, max(fanDianBdw) sonFanDianBdw from {$this->prename}members where isDelete=0 and parentId=?",$args[0]);
;echo '<div>
<form action="/admin.php/member/userUpdateed" target="ajax" method="post" call="userDataSubmitCode" onajax="userDataBeforeSubmitCode" dataType="html">
	<input type="hidden" name="type" value="';echo $userData['type'];echo '"/>
	<input type="hidden" name="uid" value="';echo $args[0];echo '"/>
      <!--uid  isDelete  enable  parentId 会员从属关系 parents 上级系列 admin  username  coinPassword  type 是否代理：0会员，1代理 subCount 人数配额 sex  nickname  name 用户真实姓名 regIP  regTime  updateTime  province  city  address  password  qq  msn  mobile  email  idCard 身份证号码 grade 等级 score 积分 coin 个人财产 fcoin 冻结资产 fanDian 用户设置的返点数 fanDianBdw 不定位返点 safepwd 交易密码，请区别于登录密码 safeEmail 密保邮箱，与邮箱分开 -->
	<table cellpadding="2" cellspacing="2" class="popupModal">
		<tr>
			<td class="title" width="180">上级关系：</td>
			<td>';echo implode('> ',$this->getCol("select username from {$this->prename}members where uid in ({$userData['parents']})"));echo '</td>
		</tr>
		<tr>
			<td class="title" width="180">用户名：</td>
			<td><input type="text" name="username" readonly="readonly" value="';echo $userData['username'];echo '"/></td>
		</tr>
		<tr>
			<td class="title">密码：</td>
			<td><input type="text" name="password" value=""/>&nbsp;<span class="spn9">置空为不修改</span></td>
		</tr>
		<tr>
			<td class="title">资金密码：</td>
			<td><input type="text" name="coinPassword" value=""/>&nbsp;<span class="spn9">置空为不修改</span></td>
		</tr>
		<tr>
			<td class="title">返点：</td>
			<td><input type="text" name="fanDian" value="';echo $userData['fanDian'];echo '" max="';echo $parentData['fanDian'];echo '" min="';echo $sonFanDianMax['sonFanDian'];echo '" fanDianDiff=';echo $this->settings['fanDianDiff'];echo ' >%&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999">';echo $this->ifs($sonFanDianMax['sonFanDian'],'0');echo '—';echo $parentData['fanDian'];echo '%</span></td>
		</tr>
		<tr>
			<td class="title">不定返点：</td>
			<td><input type="text" name="fanDianBdw" value="';echo $userData['fanDianBdw'];echo '" max="';echo $parentData['fanDianBdw'];echo '" min="';echo $sonFanDianMax['sonFanDianBdw'];echo '"/>%&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999">';echo $this->ifs($sonFanDianMax['sonFanDianBdw'],'0');echo '—';echo $parentData['fanDianBdw'];echo '%</span></td>
		</tr>
		<tr>
			<td class="title">重置银行：</td>
			<td><label><input type="radio" name="resetBank" value="1"/>重置</label> <label><input type="radio" name="resetBank" value="" checked />不重置</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="spn9">会员自己修改</span></td>
		</tr>
        <tr>
        	<td class="title">启用状态：</td>
            <td><label><input type="radio" value="1" name="enable" ';if($userData['enable']) echo 'checked="checked"';echo '/>开启</label>&nbsp;&nbsp;<label><input type="radio" value="0" name="enable" ';if(!$userData['enable']) echo 'checked="checked"';echo '/>关闭</label></td>
        </tr>
        <tr>
        	<td class="title">加入时间：</td>
			<td>';echo date("Y-m-d H:i:s",$userData['regTime']);echo '</td>
        </tr>
        ';if($userData['qq']){;echo '        <tr>
        	<td class="title">Q Q：</td>
			<td>';echo $userData['qq'];echo '</td>
        </tr>
        ';};echo '	</table>
</form>
</div>';
?>