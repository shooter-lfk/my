<?php

class Cash extends WebLoginBase{
	public $pageSize=20;

	public final function toCash(){
		$this->display('cash/to-cash.php');
	}
	
	public final function toCashLog(){
		$this->display('cash/to-cash-log.php');
	}
	
	public final function recharge(){
		$this->display('cash/recharge.php');
	}
	
	public final function rechargeLog(){
		$this->display('cash/recharge-log.php');
	}
	
	/**
	 * 提现申请
	 */
	public final function ajaxToCash(){
		if(!$para=$_POST) throw new Exception('参数出错');
		$bank=$this->getRow("select * from {$this->prename}member_bank where uid=? limit 1",$this->user['uid']);
		$para['username']=$bank['username'];
		$para['account']=$bank['account'];
		$para['bankId']=$bank['bankId'];
		
		//提示时间检查
		$fromTime=strtotime(date('Y-m-d ',$this->time).$this->settings['cashFromTime'].':00');
		$toTime=strtotime(date('Y-m-d ',$this->time).$this->settings['cashToTime'].':00');
		if($this->time < $fromTime ||$this->time > $toTime ) throw new Exception("提现时间：从".$this->settings['cashFromTime']."到".$this->settings['cashToTime']);

		$this->beginTransaction();
		
		try{
		
			$this->freshSession();
			if($this->user['coinPassword']!=md5($para['coinpwd'])) throw new Exception('资金密码不正确');
			unset($para['coinpwd']);
			
			if($this->user['coin']<$para['amount']) throw new Exception('你帐户资金不足');
		
			// 查询最大提现次数与已经提现次数
			$time=strtotime(date('Y-m-d', $this->time));
			if($times=$this->getValue("select count(*) from {$this->prename}member_cash where actionTime>=$time and uid=?", $this->user['uid'])){
				$cashTimes=$this->getValue("select maxToCashCount from {$this->prename}member_level where level=?", $this->user['grade']);
				if($times>=$cashTimes) throw new Exception('对不起，今天你提现次数已达到最大限额，请明天再来');
			}
			
			// 插入提现请求表
			$para['actionTime']=$this->time;
			$para['uid']=$this->user['uid'];
			if(!$this->insertRow($this->prename .'member_cash', $para)) throw new Exception('提交提现请求出错');
			$id=$this->lastInsertId();
			
			// 流动资金
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
			//return 9999;
			throw $e;
		}
	}
	
	/**
	 * 确认提现到帐
	 */
	public final function toCashSure($id){
		if(!$id=intval($id)) throw new Exception('参数出错');
		
		$this->beginTransaction();
		try{
			
			// 查找提现请求信息
			if(!$cash=$this->getRow("select * from {$this->prename}member_cash where id=$id"))
			throw new Exception('参数出错');
			
			if($cash['uid']!=$this->user['uid']) throw new Exception('您不能代别人确认');
			switch($cash['state']){
				case 0:
					throw new Exception('提现已经确认过了');
				break;
				case 1:
					throw new Exception("提现请求正在处理中...");
				break;
				case 2:
					throw new Exception("该提现请求已经取消，冻结资金已经解除冻结\r\n如需要提现请重新申请");
				break;
				case 3:
					
				break;
				case 4:
					throw new Exception("该提现请求已经失败，冻结资金已经解除冻结\r\n如需要提现请重新申请");
				break;
				default:
					throw new Exception('系统出错');
				break;
			}
			
			
			if($this->update("update {$this->prename}member_cash set state=0 where id=$id"))
			$this->addCoin(array(
				'liqType'=>12,
				'uid'=>$this->user['uid'],
				'info'=>"提现[$id]资金确认",
				'extfield0'=>$id
			));
			
		}catch(Exception $e){
			$this->rollBack();
			throw $e;
		}
	}
	
	
	/* 进入充值，生产充值订单 */
	public final function inRecharge(){
		/*$sql="insert into {$this->prename}params(name, `value`) values";
		$i=0;
		if(!$para=$_POST) throw new Exception('参数出错');
		
		foreach($para as $key=>$var){
			if($var==$this->settings[$key]) continue;
			$i++;
			$sql.="('$key', '$var'),";
		}
		
		if(!$i) throw new Exception('数据没有改变');
		$sql=rtrim($sql,',');
		$sql.=' on duplicate key update `value`=values(`value`)';
		
		if($this->insert($sql)){
			return $this->getSystemSettings(0);
		}else{
			throw new Exception('未知错误');
		}*/
		$bankco = @$_POST['bankco'];
		unset($_POST['bankco']);
		if(!$para=$_POST) {
			if ($bankco!=''){
				echo '参数出错'; exit;
			}else{
				throw new Exception('参数出错');
			}
		}

		if($this->user['coinPassword']!=md5($para['coinpwd'])){
			if ($bankco!=''){
				echo '资金密码不正确'; exit;
			}else{
				throw new Exception('资金密码不正确');
			}
		}else{
			// 插入提现请求表
			unset($para['coinpwd']);
			$para['rechargeId']=$this->getRechId();
			$para['actionTime']=$this->time;
			$para['uid']=$this->user['uid'];
			$para['username']=$this->user['username'];
			$para['actionIP']=$this->ip(true);
			$mBankId=$para['mBankId'];
			$para['info']='用户充值';
			
			if($this->insertRow($this->prename .'member_recharge', $para)){
				$para['bankco'] = $bankco;
				
				$this->display('cash/recharge-copy.php',0,$para);
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
	
	//充值提现详细信息弹出
	public final function rechargeModal($id){
		$this->getTypes();
		$this->getPlayeds();
		$this->display('cash/recharge-modal.php', 0 , $id);
	}
	public final function cashModal($id){
		$this->getTypes();
		$this->getPlayeds();
		$this->display('cash/cash-modal.php', 0 , $id);
	}
}