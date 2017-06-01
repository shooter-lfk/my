<?php
/**
 * 笛卡尔乘积算法
 *
 * @params 一个可变参数，原则上每个都是数组，但如果数组只有一个值是直接用这个值
 *
 * useage:
 * console.log(DescartesAlgorithm(2, [4,5], [6,0],[7,8,9]));
 */
function DescartesAlgorithm(){
	$args=func_get_args();
	foreach($args as $i=>$v){
		if(!is_array($v)) $args[$i]=$v;
	}
	if(count($args)==1) return $args[0];
	if(count($args)==2){
	
	}
	
}