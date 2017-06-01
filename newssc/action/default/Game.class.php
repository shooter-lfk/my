<?php
include_once 'Bet.class.php';
class Game extends WebLoginBase{

	//{{{ 投注
	public final function postCode(){

		$codes=$_POST['code'];
		$amount=0;
		//print_r($_POST);
		//if(!$this->getValue("select enable from {$this->prename}played_group where id=?",$codes[0]['playedGroup'])) throw new Exception('游戏玩法组已停,请刷新再投');
		if(!$this->getValue("select enable from {$this->prename}played where id=?",$codes[0]['playedId'])) throw new Exception('游戏玩法已停,请刷新再投');
		if(count($codes)==0) throw new Exception('请先选择号码再提交投注');
		
		//$actionNo=$this->getGameNo($code['type']);
		
		// 查检每注的赔率是否正常
		$this->getPlayeds();
		foreach($codes as $code){
			$played=$this->playeds[$code['playedId']];
			if(!$played['enable']) throw new Exception('游戏玩法组已停,请刷新再投');
			if($code['bonusProp']>$played['bonusProp']) throw new Exception('提交数据出错，请重新投注');
			if($code['bonusProp']<$played['bonusPropBase']) throw new Exception('提交数据出错，请重新投注');
			//print_r($played);
			//throw new Exception($played['betCountFun']);
			// 检查注数
			if($betCountFun=$played['betCountFun']){
				if($code['actionNum']!=Bet::$betCountFun($code['actionData'])) throw new Exception('提交数据出错，请重新投注');
			}
		}
		
		
		$code=current($codes);
		
		$para=$_POST['para'];
		if(!isset($_POST['para']['qzEnable'])) $_POST['para']['qzEnable']=0;
		
		$para=array_merge($_POST['para'], array(
			'actionTime'=>$this->time,
			//'actionNo'=>$actionNo['actionNo'],
			//'kjTime'=>strtotime($actionNo['actionTime']),
			'actionIP'=>$this->ip(true),
			'uid'=>$this->user['uid'],
			'username'=>$this->user['username'],
			'serializeId'=>uniqid()
		));
		//print_r($para);exit;
		
		$code=array_merge($code, $para);
		
		//include_once 'Cai.class.php';

		if($zhuihao=$_POST['zhuiHao']){
			$liqType=102;
			$codes=array();
			$info='追号投注';
			
			unset($para['kjTime']);
			
			foreach(explode(';', $zhuihao) as $var){
				list($code['actionNo'], $code['beiShu'], $code['kjTime'])=explode('|', $var);
				//var_dump($code['kjTime']);exit;
				$code['kjTime']=strtotime($code['kjTime']);
				
				if($code['kjTime']<$this->time) throw new Exception('投注失败：你追投注第'.$code['actionNo'].'已经过购买时间');
				
				$codes[]=$code;
				$amount+=$code['actionNum']*$code['mode']*$code['beiShu'];
			}
		}else{
			$liqType=101;
			$info='投注';
			if($para['kjTime']<$this->time)  throw new Exception('投注失败：你投注第'.$para['actionNo'].'已经过购买时间');
			foreach($codes as $i=>$code){
				$codes[$i]=array_merge($code, $para);
				$amount+=$code['actionNum']*$code['mode']*$code['beiShu'];
			}
		}

		// 开始事物处理
		$this->beginTransaction();
		try{
			// 查询用户可用资金
			$userAmount=$this->getValue("select coin from {$this->prename}members where uid={$this->user['uid']}");
			if($userAmount < $amount) throw new Exception('您的可用资金不足，是否充值？');
			
			foreach($codes as $code){
				// 插入投注表
				$amount=$code['actionNum']*$code['mode']*$code['beiShu'];
				$this->insertRow($this->prename .'bets', $code);
	
				// 添加用户资金流动日志
				$this->addCoin(array(
					'uid'=>$this->user['uid'],
					'type'=>$code['type'],
					//'playedId'=>$para['playedId'],
					'liqType'=>$liqType,
					'info'=>$info,
					'extfield0'=>$this->lastInsertId(),
					'extfield1'=>$para['serializeId'],
					//'extfield2'=>$data['orderId'],
					'coin'=>-$amount,
					//'fcoin'=>$amount
				));
			}
			// 返点与积分等开奖时结算

			$this->commit();
			return '投注成功';
		}catch(Exception $e){
			$this->rollBack();
			throw $e;
		}
	}
	//}}}

	public final function getNo($type){
		$actionNo=$this->getGameNo($type);
		
		if($type==1 && $actionNo['actionTime']=='00:00'){
			$actionNo['actionTime']=strtotime($actionNo['actionTime'])+24*3600;
		}else{
			$actionNo['actionTime']=strtotime($actionNo['actionTime']);
		}

		echo json_encode($actionNo);
	}
	
	//{{{ 庄内庄投注
	public final function znzPost($id){
		//throw new Exception('还未开放');
		
		if(!$id=intval($id)) throw new Exception('参数错误1');
		if(!$para=$_POST) throw new Exception('参数错误2');
		if($para['fanDianAmount']<0) throw new Exception('参数错误3');
		if($para['qz_chouShui']<0) throw new Exception('参数错误4');
		
		//$para['qz_fcoin']=$pa
		
		$this->beginTransaction();
		try{
			$data=$this->getRow("select * from {$this->prename}bets where id=$id");
			$amount=$data['mode']/2 * $data['beiShu'] * $data['bonusProp'] + $para['fanDianAmount'] + $para['qz_chouShui'];
			if(!$data) throw new Exception('参数错误5');
			if($para['qz_fcoin']<$amount) throw new Exception('参数错误6');
			if($data['isDelete']) throw new Exception('投注已经撤单');
			if($data['qz_uid']) throw new Exception('已经被别人抢庄了');
			if($data['uid']==$this->user['uid']) throw new Exception('不能抢自己的庄');
			if($amount>$this->user['coin']) throw new Exception('你的资金余额不足');
			
			// 冻结时间后不能抢庄
			$this->getTypes();
			if($data['kjTime']-$this->types[$data['type']]['data_ftime']<$this->time) throw new Exception('这期已经结冻，不能抢庄');
			
			$para['qz_uid']=$this->user['uid'];
			$para['qz_username']=$this->user['username'];
			$para['qz_time']=$this->time;
			
			if($this->updateRows($this->prename .'bets', $para, 'id='.$id)){
				$this->addCoin(array(
					'uid'=>$this->user['uid'],
					'type'=>$data['type'],
					'liqType'=>100,
					'info'=>'抢庄投注',
					'extfield0'=>$data['id'],
					'fcoin'=>$para['qz_fcoin'],
					'coin'=>-$para['qz_fcoin']
				));
			}
			
			$this->commit();
			return '抢庄成功';
		}catch(Exception $e){
			$this->rollBack();
			throw $e;
		}
	}
	//}}}
	
	public function calcCount($codeList, $codeLen=1){
		if(!$codeList) return 0;
		$len=0;
		
		foreach(explode('|', $codeList) as $codes){
			$len+=$this->_calcCount($codes, $codeLen);
		}
		
		return $len;
	}
	
	private function _calcCount($codeList, $codeLen=1){
		if(!$codeList) return 0;
		$len=1;
		foreach(explode(',', $codeList) as $code){
			$len*=strlen($code)/$codeLen;
		}
		return $len;
	}
	
	/**
	 * ajax取定单列表
	 */
	public final function getOrdered($type=null){
		if(!$this->type) $this->type=$type;
		$this->display('index/inc_game_order_history.php');
	}
	
	/**
	 * {{{ ajax撤单
	 */
	public final function deleteCode($id){
		
		$this->beginTransaction();
		try{
			$sql="select * from {$this->prename}bets where id=?";
			if(!$data=$this->getRow($sql, $id)) throw new Exception('找不到定单。');
			if($data['isDelete']) throw new Exception('这单子已经撤单过了。');
			if($data['uid']!=$this->user['uid']) throw new Exception('这单子不是您的，您不能撤单。');		// 可考虑管理员能给用户撤单情况
			if($data['kjTime']<$this->time) throw new Exception('已经开奖，不能撤单');
			if($data['qz_uid']) throw new Exception('单子已经被人抢庄，不能撤单');


			// 冻结时间后不能撤单
			$this->getTypes();
			if($data['kjTime']-$this->types[$data['type']]['data_ftime']<$this->time) throw new Exception('这期已经结冻，不能撤单');

			$amount=$data['beiShu'] * $data['mode'] * $data['actionNum'];

			// 添加用户资金变更日志
			$this->addCoin(array(
				'uid'=>$data['uid'],
				'type'=>$data['type'],
				'playedId'=>$data['playedId'],
				'liqType'=>7,
				'info'=>"撤单",
				'extfield0'=>$id,
				'coin'=>$amount,
				//'fcoin'=>-$amount
			));

			// 更改定单为已经删除状态
			$sql="update {$this->prename}bets set isDelete=1 where id=?";
			$this->update($sql, $id);
			//throw new Exception('b');
			$this->commit();
		}catch(Exception $e){
			$this->rollBack();
			throw $e;
		}
	}
	//}}}
}
