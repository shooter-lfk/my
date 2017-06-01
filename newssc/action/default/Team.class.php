<?php

class Team extends WebLoginBase{
	public $pageSize=20;
	
	public function getMyUserCount1(){
		$this->getSystemSettings();
		$minFanDian=$this->user['fanDian'] - 10 * $this->settings['fanDianDiff'];
		$sql="select count(*) registerUserCount, fanDian from {$this->prename}members where parentId={$this->user['uid']} and fanDian>=$minFanDian and fanDian<{$this->user['fanDian']} group by fanDian order by fanDian desc";
		$data=$this->getRows($sql);
		
		$ret=array();
		$fanDian=$this->user['fanDian'];
		$i=0;
		$set=explode(',', $this->settings['fanDianUserCount']);
		
		while(($fanDian-=$this->settings['fanDianDiff']) && ($fanDian>=$minFanDian)){
			$arr=array();
			if($data[0]['fanDian']==$fanDian){
				$arr=array_shift($data);
			}else{
				$arr['fanDian']=$fanDian;
				$arr['registerUserCount']=0;
			}
			
			$arr['setting']=$set[$i];
			//var_dump($fanDian);
			$ret["$fanDian"]=$arr;
			
			$i++;
		}
		
		return ($ret);
	}
	
	public function getMyUserCount(){
		if(!$set=$this->settings['fanDianUserCount']) return array();
		$set=explode(',', $set);
		
		foreach($set as $key=>$var){
			$set[$key]=explode('|', $var);
		}
		
		foreach($set as $var){
			if($this->user['fanDian']>=$var[1]) break;
			array_shift($set);
		}
		
	}
	
	public final function coin(){
		$this->freshSession();
		$this->display('team/coin.php');
	}
	
	public final function addMember(){
		//print_r($this->getMyUserCount());
		$this->display('team/add-member.php');
	}
	
	public final function memberList(){
		$this->display('team/member-list.php');
	}
	
	public final function cashRecord(){
		$this->display('team/cash-record.php');
	}
	
	public final function searchCashRecord(){
		$this->display('team/cash-record-list.php');
	}
	
	public final function advLink(){
		$this->display('team/adv-link.php', 0, $this->user['uid'], $this->urlPasswordKey);
	}
	
	public final function searchMember(){
		$this->display('team/member-search-list.php');
	}
	
	
	public final function insertMember(){
		$para=$_POST;
		$para['parentId']=$this->user['uid'];
		$para['parents']=$this->user['parents'];
		$para['password']=md5($para['password']);
		
		$para['regIP']=$this->ip(true);
		$para['regTime']=$this->time;
		
		if(!$para['nickname']) $para['nickname']=$para['username'];
		if(!$para['name']) $para['name']=$para['username'];
		
		//$subCount=$this->getValue("select count(*) from {$this->prename}members where parentId=?", $this->user['uid']);
		//throw new Exception($subCount);
		//if($subCount>=$this->user['subCount']) throw new Exception('您的会员人数已经达到上限');
		
		// 查检返点设置
		if($para['fanDian']=floatval($para['fanDian'])){
			$this->getSystemSettings();
			if($para['fanDian'] % $this->settings['fanDianDiff']) throw new Exception(sprintf('返点只能是%.1f%的倍数', $this->settings['fanDianDiff']));
			
			$count=$this->getMyUserCount();
			$sql="select userCount, (select count(*) from {$this->prename}members m where m.parentId={$this->user['uid']} and m.fanDian=s.fanDian) registerCount from {$this->prename}params_fandianset s where s.fanDian={$para['fanDian']}";
			$count=$this->getRow($sql);
			//throw new Exception($sql);
			//throw new Exception(sprintf('注册人数：%d，总人数：%d', $count['registerCount'], $count['userCount']));
			
			if($count && $count['registerCount']>=$count['userCount']) throw new Exception(sprintf('对不起返点为%.1f的下级人数已经达到上限', $para['fanDian']));
		}else{
			$para['fanDian']=0;
		}
		
		$this->beginTransaction();
		try{
			$sql="select username from {$this->prename}members where username=?";
			if($this->getValue($sql, $para['username'])) throw new Exception('用户“'.$para['username'].'”已经存在');
			if($this->insertRow($this->prename .'members', $para)){
				$id=$this->lastInsertId();
				$sql="update {$this->prename}members set parents=concat(parents, ',', $id) where `uid`=$id";
				$this->update($sql);
				
				$this->commit();
				
				return '添加会员成功';
			}else{
				throw new Exception('添加会员失败');
			}
			
		}catch(Exception $e){
			$this->rollBack();
			throw $e;
		}
	}
	
}