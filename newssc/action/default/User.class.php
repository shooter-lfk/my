<?php
@session_start();
class User extends WebBase{
	public $title='协信SSCG-时时彩游戏娱乐中心';
	private $vcodeSessionName='ssc_vcode_session_name';
	
	/**
	 * 用户登录页面
	 */
	public final function login(){
		$this->display('user/login.php');
	}
	
	/**
	 * 用户登出操作
	 */
	public final function logout(){
		$_SESSION=array();
		if($this->user['uid']){
			$this->update("update {$this->prename}member_session set isOnLine=0 where uid={$this->user['uid']}");
		}
		header('location: /index.php/user/login');
	}
	
	public final function bulletin(){
		$this->display('user/bulletin.php');
	}
	
	private function getBrowser(){
		$flag=$_SERVER['HTTP_USER_AGENT'];
		$para=array();
		
		// 检查操作系统
		if(preg_match('/Windows[\d\. \w]*/',$flag, $match)) $para['os']=$match[0];
		
		if(preg_match('/Chrome\/[\d\.\w]*/',$flag, $match)){
			// 检查Chrome
			$para['browser']=$match[0];
		}elseif(preg_match('/Safari\/[\d\.\w]*/',$flag, $match)){
			// 检查Safari
			$para['browser']=$match[0];
		}elseif(preg_match('/MSIE [\d\.\w]*/',$flag, $match)){
			// IE
			$para['browser']=$match[0];
		}elseif(preg_match('/Opera\/[\d\.\w]*/',$flag, $match)){
			// opera
			$para['browser']=$match[0];
		}elseif(preg_match('/Firefox\/[\d\.\w]*/',$flag, $match)){
			// Firefox
			$para['browser']=$match[0];
		}else{
			$para['browser']='unkown';
		}
		//print_r($para);exit;
		return $para;
	}
	
	/**
	 * 用户登录检查
	 */
	public final function logined($username, $password, $vcode){
		//echo printf('username:%s, password:%s, vcode:%s', $username, $password, $vcode);exit;
		if(strtolower($vcode)!=$_SESSION[$this->vcodeSessionName]){
			throw new Exception('验证码不正确。');
		}
		
		if(!$username){
			throw new Exception('用户名不正确');
		}
		
		if(!$password){
			throw new Exception('不允许空密码登录');
		}
		
		$sql="select * from {$this->prename}members where isDelete=0 and username=?";
		if(!$user=$this->getRow($sql, $username)){
			throw new Exception('用户名或密码不正确');
		}
		
		if(md5($password)!=$user['password']){
			throw new Exception('用户名或密码不正确');
		}
		//print_r($user);
		//var_dump($user['e
		if(!$user['enable']){
			throw new Exception('您的帐号被冻结，请联系管理员。');
		}

		$session=array(
			'uid'=>$user['uid'],
			'username'=>$user['username'],
			'session_key'=>session_id(),
			'loginTime'=>$this->time,
			'accessTime'=>$this->time,
			'loginIP'=>self::ip(true),
			
		);
		
		$session=array_merge($session, $this->getBrowser());
		
		if($this->insertRow($this->prename.'member_session', $session)){
			$user['sessionId']=$this->lastInsertId();
		}
		$_SESSION[$this->memberSessionName]=serialize($user);
		
		// 把别人踢下线
		//if($user->user['']) 
		//throw new Exception("update {$this->prename}member_session set isOnLine=0 where uid={$user['uid']} and id > {$user['sessionId']}");
		$this->update("update {$this->prename}member_session set isOnLine=0 where uid={$user['uid']} and id < {$user['sessionId']}");
		
		return $user;
	}

	/**
	 * 验证码产生器
	 */
	public final function vcode($rmt=null){
		$lib_path=$_SERVER['DOCUMENT_ROOT'].'/lib/';
		include_once $lib_path .'classes/CImage.class';
		$width=72;
		$height=24;
		$img=new CImage($width, $height);
		$img->sessionName=$this->vcodeSessionName;
		$img->printimg('png');
	}
	
	/**
	 * 推广注册
	 */
	public final function register($userxxx){
		if(!$userxxx){
			//throw new Exception('链接错误！');
			$this->display('team/register.php');
		}else{
			include_once $_SERVER['DOCUMENT_ROOT'].'/lib/classes/Xxtea.class';
			$userxxx=str_replace(array('-','*',''), array('+','/','='), $userxxx);
			$userxxx=base64_decode($userxxx);
			$uid=Xxtea::decrypt($userxxx, $this->urlPasswordKey);
			
			if(!$this->getRow("select uid from {$this->prename}members where uid=?",$uid)){
				//throw new Exception('链接失效！');
				$this->display('team/register.php');
			}else{
				$this->display('team/register.php',0,$uid);
			}
		}
	}
	public final function registered(){
		if(strtolower($_POST['vcode'])!=$_SESSION[$this->vcodeSessionName]){
			throw new Exception('验证码不正确。');
		}
		if(!$_POST['parentId']) throw new Exception('链接错误');
		$para=array(
			'username'=>$_POST['username'],
			'password'=>md5($_POST['password']),
			'parentId'=>$_POST['parentId'],
			'parents'=>$this->getValue("select parents from {$this->prename}members where uid=?",$_POST['parentId']),
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
			if($this->getValue($sql, $para['username'])) throw new Exception('用户“'.$para['username'].'”已经存在');
			if($this->insertRow($this->prename .'members', $para)){
				$id=$this->lastInsertId();
				$sql="update {$this->prename}members set parents=concat(parents, ',', $id) where `uid`=$id";
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
