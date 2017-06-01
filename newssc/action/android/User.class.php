<?php

class User extends WebBase{
public final function login(){
$username=$_POST['username'];
$password=$_POST['password'];
$sql="select * from {$this->prename}members where username=?";
$user=$this->getRow($sql,$username);
if(!$user) throw new Exception('密码或用户名不正确。');
if(md5($password)!=$user['password']) throw new Exception('密码或用户名不正确。');
if(!$user['enable']) throw new Exception('您的帐户被管理员冻结，请联系在线客服');
$session=array(
'uid'=>$user['uid'],
'username'=>$user['username'],
'session_key'=>session_id(),
'loginTime'=>$this->time,
'accessTime'=>$this->time,
'loginIP'=>self::ip(true),
'browser'=>'Android APK 1.0'
);
if($this->insertRow($this->prename.'member_session',$session)){
$user['sessionId']=$this->lastInsertId();
}
$_SESSION[$this->memberSessionName]=serialize($user);
try{
$this->update("update {$this->prename}member_session set isOnLine=0 where uid={$user['uid']} and id < {$user['sessionId']}");
}catch(Exception $e){}
return $user;
}
public final function vcode($rnd=null){
$lib_path=$_SERVER['DOCUMENT_ROOT'].'/lib/';
include_once $lib_path .'classes/CImage.class';
$width=66;
$height=25;
$img=new CImage($width,$height);
$img->sessionName=$this->vcodeSessionName;
$img->printimg('png');
}
public final function getBaseData(){
$ret=array();
$sql="select id, type, groupName name from {$this->prename}played_group";
$ret['group']=$this->getObject($sql,'id');
$sql="select id, name, type, android enable, groupId from {$this->prename}played where enable=1";
$ret['played']=$this->getObject($sql,'id');
$sql="select id, title name, android, shortName, type from {$this->prename}type where enable=1 and isDelete=0";
$ret['type']=$this->getObject($sql,'id');
return $ret;
}
public final function register(){
if(strtolower($_POST['prov'])!=$_SESSION[$this->vcodeSessionName]){
throw new Exception('验证码不正确。');
}
$para=array(
'username'=>$_POST['username'],
'password'=>md5($_POST['password']),
'parents'=>'',
'fanDian'=>0,
'fanDianBdw'=>0,
'regIP'=>$this->ip(true),
'regTime'=>$this->time
);
if(!$para['nickname']) $para['nickname']=$para['username'];
if(!$para['name']) $para['name']=$para['username'];
$this->beginTransaction();
try{
$sql="select username from {$this->prename}members where username=?";
if($this->getValue($sql,$para['username'])) throw new Exception('用户“'.$para['username'].'”已经存在');
if($this->insertRow($this->prename .'members',$para)){
$id=$this->lastInsertId();
$sql="update {$this->prename}members set parents=$id where `uid`=$id";
$this->update($sql);
$this->commit();
return '注册成功';
}else{
throw new Exception('注册失败');
}
}catch(Exception $e){
$this->rollBack();
throw $e;
}
}
}

?>