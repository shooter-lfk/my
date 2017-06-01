<?php

class Member extends WebLoginBase{
public final function setPwd(){
$para=$_POST;
unset($para['cpassword']);
$sql="select password from {$this->prename}members where uid={$this->user['uid']}";
$para['oldpassword']=md5($para['oldpassword']);
if($para['oldpassword']!=$this->getValue($sql)) throw new Exception('原密码不正确');
$para['password']=md5($para['password']);
unset($para['oldpassword']);
$this->updateRows($this->prename .'members',$para,"uid={$this->user['uid']}");
return '修改用户登录密码成功。';
}
public final function setCoinPwd(){
$para=$_POST;
unset($para['cpassword']);
$sql="select coinPassword from {$this->prename}members where uid={$this->user['uid']}";
$passwd=$this->getValue($sql);
if($passwd){
$para['oldpassword']=md5($para['oldpassword']);
if($para['oldpassword']!=$passwd) throw new Exception('原密码不正确');
}
$para['coinPassword']=md5($para['password']);
unset($para['oldpassword']);
unset($para['password']);
$this->updateRows($this->prename .'members',$para,"uid={$this->user['uid']}");
return '修改资金密码成功。';
}
public final function loadCoin(){
$sql="select coin, fcoin from {$this->prename}members where uid={$this->user['uid']}";
return $this->getRow($sql);
}
public final function loadBank(){
$sql="select b.name, b.home, l.username, l.account, l.editEnable, l.bankId from {$this->prename}bank_list b, {$this->prename}member_bank l where b.id=l.bankId and enable=1 and l.uid={$this->user['uid']} limit 1";
return $this->getRow($sql);
}
public final function loadBanks(){
$sql="select b.name, b.home, m.username, m.account, m.id from {$this->prename}bank_list b, {$this->prename}member_bank m where m.admin=1 and m.enable=1 and b.isDelete=0 and b.id=m.bankId";
return $this->getRows($sql);
}
public final function recharge(){
if(!$para=$_POST) throw new Exception('参数出错');
if($this->user['coinPassword']!=md5($para['coinpwd'])){
throw new Exception('资金密码不正确');
}else{
unset($para['coinpwd']);
$para['rechargeId']=$this->getRechId();
$para['actionTime']=$this->time;
$para['uid']=$this->user['uid'];
$para['username']=$this->user['username'];
$para['actionIP']=$this->ip(true);
$para['info']='用户充值';
if($this->insertRow($this->prename .'member_recharge',$para)){
$sql="select b.name, b.home, l.username, l.account from {$this->prename}bank_list b, {$this->prename}member_bank l where b.id=l.bankId and l.id={$para['mBankId']}";
$para['bank']=$this->getRow($sql);
return $para;
}else{
throw new Exception('充值订单生产请求出错');
}
}
}
public final function getRechId(){
$rechargeId=mt_rand(100000,999999);
if($this->getRow("select id from {$this->prename}member_recharge where rechargeId=$rechargeId")){
getRechId();
}else{
return $rechargeId;
}
}
public final function cash(){
if(!$para=$_POST) throw new Exception('参数出错');
$bank=$this->getRow("select * from {$this->prename}member_bank where uid=? limit 1",$this->user['uid']);
$para['username']=$bank['username'];
$para['account']=$bank['account'];
$para['bankId']=$bank['bankId'];
$fromTime=strtotime(date('Y-m-d ',$this->time).$this->settings['cashFromTime'].':00');
$toTime=strtotime(date('Y-m-d ',$this->time).$this->settings['cashToTime'].':00');
if($this->time <$fromTime ||$this->time >$toTime ) throw new Exception("提现时间：从".$this->settings['cashFromTime']."到".$this->settings['cashToTime']);
$this->beginTransaction();
try{
$this->freshSession();
if($this->user['coinPassword']!=md5($para['coinpwd'])) throw new Exception('资金密码不正确');
unset($para['coinpwd']);
if($this->user['coin']<$para['amount']) throw new Exception('你帐户资金不足');
$time=strtotime(date('Y-m-d',$this->time));
if($times=$this->getValue("select count(*) from {$this->prename}member_cash where actionTime>=$time and uid=?",$this->user['uid'])){
$cashTimes=$this->getValue("select maxToCashCount from {$this->prename}member_level where level=?",$this->user['grade']);
if($times>=$cashTimes) throw new Exception('对不起，今天你提现次数已达到最大限额，请明天再来');
}
$para['actionTime']=$this->time;
$para['uid']=$this->user['uid'];
if(!$this->insertRow($this->prename .'member_cash',$para)) throw new Exception('提交提现请求出错');
$id=$this->lastInsertId();
$this->addCoin(array(
'coin'=>0-$para['amount'],
'fcoin'=>$para['amount'],
'uid'=>$para['uid'],
'liqType'=>106,
'info'=>"提现[$id]资金冻结",
'extfield0'=>$id
));
$this->commit();
return '申请提现成功，提现将在15分钟内到帐，如未到账请联系在线客服。';
}catch(Exception $e){
$this->rollBack();
throw $e;
}
}
public final function setBank(){
if(!$para=$_POST) throw new Exception('参数出错');
$this->freshSession();
if(md5($para['coinPassword'])!=$this->user['coinPassword']) throw new Exception('资金密码不正确');
unset($para['coinPassword']);
$para['uid']=$this->user['uid'];
$para['editEnable']=0;
if($bank=$this->getRow("select id,editEnable from {$this->prename}member_bank where uid=?",$this->user['uid'])){
if($bank['editEnable']!=1) throw new Exception('银行信息绑定后不能随便更改，如需更改，请联系在线客服');
if($account=$this->getValue("select account FROM {$this->prename}member_bank where account=? LIMIT 1",$para['account'])) throw new Exception('该'.$account.'银行账号已经使用');
if($this->updateRows($this->prename .'member_bank',$para,'uid='.$this->user['uid'])){
return '更改银行信息成功';
}else{
throw new Exception( '更改银行信息出错');
}
}else{
if($this->insertRow($this->prename .'member_bank',$para)){
if($para['bankId']==1){
$this->getSystemSettings();
if($coin=floatval($this->settings['huoDongRegister'])){
$liqType=51;
$info='首次绑定工行卡赠送';
$ip=$this->ip(true);
$bankAccount=$para['account'];
$sql="select id from {$this->prename}coin_log where liqType=$liqType and (`uid`={$this->user['uid']} or extfield0=$ip or extfield1='$bankAccount') limit 1";
if(!$this->getValue($sql)){
$this->addCoin(array(
'coin'=>$coin,
'liqType'=>$liqType,
'info'=>$info,
'extfield0'=>$ip,
'extfield1'=>$bankAccount
));
return sprintf('更改银行信息成功，由于你第一次绑定工行卡，系统赠送%.2f元',$coin);
}
}
}
return '更改银行信息成功';
}else{
throw new Exception( '更改银行信息出错');
}
}
}
}
?>