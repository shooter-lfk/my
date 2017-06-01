<?php
class Record extends WebLoginBase{
	public $userType;
	public $type;
	public $pageSize=20;
	
	public final function search($userType='me', $type=0){
		$this->userType=$userType;
		$this->type=$type;
		$this->getTypes();
		$this->getPlayeds();
		$this->action='searchGameRecord';
		$this->display('record/search.php');
	}
	
	public final function dateModal(){
		$this->userType='me';
		$_GET['fromTime']=date('Y-m-d', $this->time);
		$this->getTypes();
		$this->getPlayeds();
		$this->display('record/search-list.php');
	}
	
	public final function searchGameRecord($userType='me', $type=0){
		if(!$_GET['userType']){
			$this->userType=$userType;
		}else{
			$this->userType=$_GET['userType'];
		}
		$this->type=$type;
		$this->getTypes();
		$this->getPlayeds();
		$this->display('record/search-list.php');
	}
	
	public final function betInfo($id){
		$this->getTypes();
		$this->getPlayeds();
		$this->display('record/bet-info.php', 0 , $id);
	}
	
	public final function betInfo2($id){
		$this->getTypes();
		$this->getPlayeds();
		$this->display('record/bet-info-2.php', 0 , $id);
	}
}
