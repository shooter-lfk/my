<?php
class Report extends WebLoginBase{
	public $type;
	public $pageSize=20;
	
	// 帐变列表
	public final function coin($type=0){
		$this->type=$type;
		$this->action='coinlog';
		$this->display('report/coin.php');
	}
	
	public final function coinlog($type=0){
		$this->type=$type;
		$this->display('report/coin-log.php');
	}
	
	public final function fcoinModal(){
		$this->display('report/fcoin-log.php');
	}
	
	// 返点总额
	public final function fanDian(){
		$this->display('report/fan-dian.php');
	}
	
	// 庄内庄报表查询
	public final function znz(){
		$this->display('report/znz.php');
	}
	
	// 系统报表查询
	public final function sys(){
		$this->display('report/sys.php');
	}
	
	// 总结算查询
	public final function count(){
		$this->display('report/count.php');
	}
	
	public final function countSearch(){
		$this->display('report/count-list.php');
	}
}
