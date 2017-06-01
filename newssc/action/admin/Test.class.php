<?php
class Test extends AdminBase{
	public final function show($a, $b){
		//throw new Exception('出错啊');
		return array('A'=>$a, 'B'=>$b);
	}
}