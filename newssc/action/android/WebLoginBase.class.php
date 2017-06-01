<?php

class WebLoginBase extends WebBase{
public $type;
public $groupId;
public $played;
public $NO;
public $gameFanDian;
function __construct($dsn,$user='',$password=''){
session_start();
if(!$_SESSION[$this->memberSessionName]){
header('x-location: login.html');
exit('您没有登录');
}
try{
parent::__construct($dsn,$user,$password);
$this->gameFanDian=$this->getValue("select fanDian from {$this->prename}members where uid=?",$GLOBALS['SUPER-ADMIN-UID']);
if(!$this->getValue("select isOnLine from ssc_member_session where uid={$this->user['uid']} and session_key=? order by id desc limit 1",session_id())){
header('x-location: login.html');
exit('您已经退出登录，请重新登录');
}
}catch(Exception $e){
}
}
public function freshSession(){
if(!$this->user) return false;
$sessionId=$this->user['sessionId'];
$sql="select * from {$this->prename}members where uid=?";
$user=$this->getRow($sql,$this->user['uid']);
$user['sessionId']=$sessionId;
$user['_gameFanDian']=$this->getGameFanDian();
$_SESSION[$this->memberSessionName]=serialize($user);
$this->user=$user;
return true;
}
public function getGameFanDian(){
if($this->gameFanDian) return $this->gameFanDian;
$this->getSystemSettings();
return $this->gameFanDian=$this->settings['fanDianMax'];
}
public function getSystemSettings($expire=null){
if($expire===null) $expire=$this->expire;
$file=$this->cacheDir .'systemSettings';
if($expire &&is_file($file) &&filemtime($file)+$expire>$this->time){
return $this->settings=unserialize(file_get_contents($file));
}
$sql="select * from {$this->prename}params";
$this->settings=array();
if($data=$this->getRows($sql)){
foreach($data as $var){
$this->settings[$var['name']]=$var['value'];
}
}
file_put_contents($file,serialize($this->settings));
return $this->settings;
}
public function addCoin($log){
if(!isset($log['uid'])) $log['uid']=$this->user['uid'];
if(!isset($log['info'])) $log['info']='';
if(!isset($log['coin'])) $log['coin']=0;
if(!isset($log['type'])) $log['type']=0;
if(!isset($log['fcoin'])) $log['fcoin']=0;
if(!isset($log['extfield0'])) $log['extfield0']=0;
if(!isset($log['extfield1'])) $log['extfield1']='';
if(!isset($log['extfield2'])) $log['extfield2']='';
$sql="call setCoin({$log['coin']}, {$log['fcoin']}, {$log['uid']}, {$log['liqType']}, {$log['type']}, '{$log['info']}', {$log['extfield0']}, '{$log['extfield1']}', '{$log['extfield2']}')";
$this->insert($sql);
}
public function getFanDian($uid=null){
if($uid===null){
if(!$uid=$this->user['parentId']){
return $this->params['basePl'];
}
}
return $this->getValue("select fanDian from {$this->prename}members where parentId=?",$uid);
}
}
?>