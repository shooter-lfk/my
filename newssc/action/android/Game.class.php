<?php

include_once 'Bet.class.php';
class Game extends WebLoginBase{
public final function getGameNo($type){
$ret=parent::getGameNo($type);
return $ret;
}
public final function getGameBetNo($type){
$ret=$this->getGameNo($type);
if($ret){
$ret['kjTime']=strtotime($ret['actionTime']);
unset($ret['actionTime']);
return $ret;
}
}
public final function json(){
$sql="select id, name, type, groupId from ssc_played";
$ret = $this->getObject($sql,'id');
return $ret;
}
public final function getBonus($playedId){
$sql="select bonusProp, bonusPropBase, betCountFun from {$this->prename}played where id=?";
$bonus=$this->getRow($sql,$playedId);
if($bonus['betCountFun']!='dwd') $bonus['bonusPropBase']=round(((($bonus['bonusProp']-$bonus['bonusPropBase'])/$this->settings['fanDianMax'])*$this->user['fanDian'])+$bonus['bonusPropBase'],2);
return $bonus;
}
public final function postCode(){
$codes=$_POST['code'];
$amount=0;
if(!$this->getValue("select enable from {$this->prename}played_group where id=?",$codes[0]['playedGroup'])){
throw new Exception('游戏玩法组已停,请刷新再投');
echo "<script>location.reload([bForceGet]);</script>";
}
if(!$this->getValue("select enable from {$this->prename}played where id=?",$codes[0]['playedId'])) throw new Exception('游戏玩法已停,请刷新再投');
if(count($codes)==0) throw new Exception('请先选择号码再提交投注');
$code=current($codes);
$this->getPlayeds();
foreach($codes as $code){
$played=$this->playeds[$code['playedId']];
if(!$played['enable']) throw new Exception('游戏玩法组已停,请刷新再投');
if($code['bonusProp']>$played['bonusProp']) throw new Exception('提交数据出错，请重新投注');
if($code['bonusProp']<$played['bonusPropBase']) throw new Exception('提交数据出错，请重新投注');
if($betCountFun=$played['betCountFun']){
if($code['actionNum']!=Bet::$betCountFun($code['actionData'])) throw new Exception('提交数据出错，请重新投注');
}
}
$para=$_POST['para'];
if(!isset($_POST['para']['qzEnable'])) $_POST['para']['qzEnable']=0;
$para=array_merge($_POST['para'],array(
'actionTime'=>$this->time,
'actionIP'=>$this->ip(true),
'uid'=>$this->user['uid'],
'username'=>$this->user['username'],
'serializeId'=>uniqid()
));
$code=array_merge($code,$para);
if($zhuihao=$_POST['zhuiHao']){
$liqType=102;
$codes=array();
$info='追号投注';
unset($para['kjTime']);
$nos=$this->getGameNos($code['type'],$zhuihao+1);
foreach($nos as $var){
$code['kjTime']=$var['actionTime'];
$code['actionNo']=$var['actionNo'];
$codes[]=$code;
$amount+=$code['actionNum']*$code['mode']*$code['beiShu'];
}
}else{
$liqType=101;
$info='投注';
if($para['kjTime']<$this->time)  throw new Exception('投注失败：你投注第'.$para['actionNo'].'已经过购买时间');
foreach($codes as $i=>$code){
$codes[$i]=array_merge($code,$para);
$amount+=$code['actionNum']*$code['mode']*$code['beiShu'];
}
}
$this->beginTransaction();
try{
$userAmount=$this->getValue("select coin from {$this->prename}members where uid={$this->user['uid']}");
if($userAmount <$amount) throw new Exception('您的可用资金不足，是否充值？');
foreach($codes as $code){
$amount=$code['actionNum']*$code['mode']*$code['beiShu'];
$code['betType']=1;
$this->insertRow($this->prename .'bets',$code);
$this->addCoin(array(
'uid'=>$this->user['uid'],
'type'=>$code['type'],
'liqType'=>$liqType,
'info'=>$info,
'extfield0'=>$this->lastInsertId(),
'extfield1'=>$para['serializeId'],
'coin'=>-$amount,
));
}
$this->commit();
return '投注成功';
}catch(Exception $e){
$this->rollBack();
throw $e;
}
}
public final function record($id=null){
$sql="select id, type, playedId, left(actionData, 32) actionData, actionNo, actionNum, mode, beiShu, weiShu, bonusProp, lotteryNo, fanDian, bonus, kjTime from {$this->prename}bets where uid={$this->user['uid']} and isDelete=0";
if($id) $sql.=" and id<$id";
$sql.=" order by id desc limit 10";
return $this->getRows($sql);
}
public final function deleteBet($id){
$this->beginTransaction();
try{
$sql="select * from {$this->prename}bets where id=?";
if(!$data=$this->getRow($sql,$id)) throw new Exception('找不到定单。');
if($data['isDelete']) throw new Exception('这单子已经撤单过了。');
if($data['uid']!=$this->user['uid']) throw new Exception('这单子不是您的，您不能撤单。');
if($data['kjTime']<$this->time) throw new Exception('已经开奖，不能撤单');
if($data['qz_uid']) throw new Exception('单子已经被人抢庄，不能撤单');
$this->getTypes();
if($data['kjTime']-$this->types[$data['type']]['data_ftime']<$this->time) throw new Exception('这期已经结冻，不能撤单');
$amount=$data['beiShu'] * $data['mode'] * $data['actionNum'];
$this->addCoin(array(
'uid'=>$data['uid'],
'type'=>$data['type'],
'playedId'=>$data['playedId'],
'liqType'=>7,
'info'=>"撤单",
'extfield0'=>$id,
'coin'=>$amount,
));
$sql="update {$this->prename}bets set isDelete=1 where id=?";
$this->update($sql,$id);
$this->commit();
}catch(Exception $e){
$this->rollBack();
throw $e;
}
}
}

?>