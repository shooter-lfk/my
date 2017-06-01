<?php
class Member extends AdminBase{
	public $pageSize=15;
	public final function add(){
		$this->display('member/add.php');
	}
	
	public final function index(){
		$this->display('member/list.php');
	}
	
	
	public final function bank(){
		$this->display('member/bank.php');
	}
	
	public final function loginLog(){
		include 'ip.function.php';
		$this->display('member/login-list.php');
	}
	
	public final function level(){
		$this->display('member/level-list.php');
	}
	
	public final function userCountSetting(){
		$this->display('member/count-setting.php');
	}
	
	public final function edit($uid){
		$this->display('member/edit.php');
	}
	
	public final function added($passwordEncrypt=false){
		$para=$_POST;
		if(!$para['username']) throw new Exception('用户名不能为空');
		$para['username']=strtolower($para['username']);
		$para['fanDian']=floatval($para['fanDian']);
		
		if($this->getValue("select uid from {$this->prename}members where username=?", $para['username']))
		throw new Exception("用户名已经存在。");
		
		if(isset($para['password']) && !$passwordEncrypt) $para['password']=md5($para['password']);
		if(!isset($para['nickname']) || !$para['nickname']) $para['nickname']=$para['username'];
		if(!isset($para['name']) || !$para['name']) $para['name']=$para['username'];
		
		$para['regIP']=$this->ip(true);
		$para['regTime']=$this->time;
		//$para['parentId']=$this->user['uid'];
		//$para['parents']=$this->user['parents'];
		
		if($this->insertRow($this->prename .'members', $para)){
			$uid=$this->lastInsertId();
			$this->addLog(4,$this->adminLogType[4].'['.$para['username'].']',$uid, $para['username']);
			$this->updateRows($this->prename .'members', array('parents'=>$uid), 'uid='.$uid);
			$para['message']='添加用户成功';
			return $para;
		}else{
			throw new Exception('未知错误');
		}
	}
	
	public final function delete($uid){
		$this->display('member/userDel-modal.php', 0, $uid);
	}
	public final function deleteed(){
		$para=$_POST;
		$uid=$para['uid'];
		$teamCoin=$para['teamCoin'];
		$teamFcoin=$para['teamFcoin'];
		//检查是否有下级，并且有帐变
		$son=$this->getRow("select count(*) teamNum, sum(coin) teamCoin, sum(fcoin) teamFcoin from {$this->prename}members where concat(',', parents, ',') like '%,$uid,%'");
		if($son['teamNum']-1>0) throw new Exception('团队还有成员'.$son['teamNum'].'人，团队资金'.$son['teamCoin'].'元,团队冻结'.$son['teamFcoin'].'元');
		if(floatval($teamCoin) != floatval($son['teamCoin'])) throw new Exception('团队资金刚有变动'.(floatval($son['teamFcoin'])-floatval($teamFcoin)).'元，请确认后再删除');
		if(floatval($teamFcoin) != floatval($son['teamFcoin'])) throw new Exception('团队冻结资金刚有变动'.(floatval($son['teamFcoin'])-floatval($teamFcoin)).'元，请确认后再删除');
		//检查用户是否有已经充值还未到账的情况
		//if() throw new Exception('有用户充值'.(floatval($son['teamFcoin'])-floatval($teamFcoin)).'元，正在到账中……');
		
		$userName=$this->getValue("select username from {$this->prename}members where uid=?", $uid);
		$sql="call delUser($uid)";
		if($this->update($sql)){
			//$this->updateRows($this->prename .'members', array('isDelete'=>1), 'uid='.$uid)
			$this->addLog(6,$this->adminLogType[6].'['.$userName.']',$uid,$userName);
			return '删除成功';
		}else{
			throw new Exception('删除失败');
		}
	}
	
	public final function setLevel(){
		$para=$_POST;
		$table=$this->prename .'member_level';

		foreach($para['data'] as $id=>$level){
			//print_r($para);exit;
			$this->updateRows($table, $level, "id=$id");
		}
		$this->addLog(14,$this->adminLogType[14]);
		return true;
	}

	public final function setUserCount(){
		$para=$_POST;
		$table=$this->prename .'params_fandianset';

		foreach($para['data'] as $id=>$level){
			//print_r($para);exit;
			$this->updateRows($table, $level, "id=$id");
		}
		//$this->addLog(14,$this->adminLogType[14]);
		return true;
	}

	/*用户*///myq
	public final function listUser($sortType="userId"){
		//throw new Exception($sortType);
		$this->sortType=$sortType;
		$this->display('member/list-user.php');
	}
	/*编辑用户*/
	public final function userUpdate($id){
		$this->display('member/update-modal.php', 0, $id);
	}
	public final function userUpdateed(){
		$para=$_POST;
		$uid=$para['uid'];
		if(!$para['password']){
			unset($para['password']);
		}else{
			$para['password']=md5($para['password']);
		}
		if(!$para['coinPassword']){
			unset($para['coinPassword']);
		}else{
			$para['coinPassword']=md5($para['coinPassword']);
		}
		if(!$para['fanDian']) unset($para['fanDian']);
		if(!$para['fanDianBdw']) unset($para['fanDianBdw']);
		
		// 重置银行信息
		if($para['resetBank']==1){
			$sql="update {$this->prename}member_bank set editEnable=1,account='' where `uid`={$para['uid']}";
			$this->update($sql);
		}
		unset($para['resetBank']);
		
		//print_r($para);
		if($this->updateRows($this->prename .'members', $para, "uid=$uid")){
			$this->addLog(5,$this->adminLogType[5].'['.$para['username'].']',$para['uid'],$para['username']);
			echo '修改成功';
		}else{
			throw new Exception('未知出错');
		}
		
	}
	
	public final function userAmount($id){
		$this->display('member/user-amount.php', 0, $id);
	}

}