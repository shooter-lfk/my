<?php

/**
 * 注数计算函数
 */
//$fun='ds';
//echo Bet::$fun('0,0,-,-,3|0,0,-,-,5|0,0,-,-,6');

//echo Bet::A(3,2);

class Bet{

	//{{{ 计算函数集
	
	// 直选复式
	// 大小单双
	public static function fs($bet){
		$bets=explode(',', $bet);
		$ret=1;
		
		foreach($bets as $b){
			$codes=str_split($b);
			$ret*=count($codes);
		}
		
		return $ret;
	}

	// 直选单式
	// 二星直选组选单式
	public static function ds($bet){
		return count(explode('|', $bet));
	}
	
	// 组三
	public static function z3($bet){
		if(strpos($bet, ',')===false && !preg_match('/(\d).*\1/', $bet)){
			return self::A(count(str_split($bet)), 2);
		}else{
			// 来自混合组选
			return count(explode(',', $bet));
		}
	}
	
	// 组六
	public static function z6($bet){
		if(strpos($bet, ',')===false && !preg_match('/(\d).*\1/', $bet)){
			return self::C(count(str_split($bet)), 3);
		}else{
			return count(explode(',', $bet));
		}
	}
	
	// 组二
	public static function z2($bet){
		return self::C(count(str_split($bet)), 2);
	}
	
	// 五星定位胆
	// 三星定位胆
	// 不定胆
	public static function dwd($bet){
		return strlen(str_replace(array(',','-'), '', $bet));
	}
	
	// 大小单双
	public static function dxds($bet){
		$bet=str_replace(array('大','小','单', '双'), array(1,2,3,4), $bet);
		return self::fs($bet);
	}
	
	//{{{ 十一选五
	
	// 任选一
	public static function r1($bet){
		return count(explode(' ', $bet));
	}
	
	// 任选二
	// 前二组选
	public static function r2($bet){
		return self::rx($bet, 2);
	}
	
	// 任选三
	// 前三组选
	public static function r3($bet){
		return self::rx($bet, 3);
	}
	public static function r4($bet){
		return self::rx($bet, 4);
	}
	public static function r5($bet){
		return self::rx($bet, 5);
	}
	public static function r6($bet){
		return self::rx($bet, 6);
	}
	public static function r7($bet){
		return self::rx($bet, 7);
	}
	public static function r8($bet){
		return self::rx($bet, 8);
	}
	
	// 十一选五直选
	public static function zx11($bet){
		$bets=explode(',', $bet);
		$ret=1;
		
		foreach($bets as $b){
			$codes=explode(' ', $b);
			$ret*=count($codes);
		}
		
		return $ret;
	}
	
	//}}}
	
	//}}}

	//{{{ 常用算法
	//排列
	//A(n,m)=n(n-1)(n-2)……(n-m+1)= n!/(n-m)!
	public static function A($n, $m){
		if($n<$m) return false;
		$num=1;
		for($i=0; $i<$m; $i++) $num*=$n-$i;
		return $num;
	}

	//组合
	//C(n,m)=A(n,m)/m!=n!/((n-m)!*m!)
	public static function C($n, $m){
		if($n<$m) return false;
		return self::A($n, $m)/self::A($m, $m);
	}

	// 十一选五任选
	public static function rx($bet, $num){
		if($pos=strpos($bet, ')')){
			$dm=substr($bet, 1, $pos-1);
			$tm=substr($bet, $pos+1);
			
			//printf("胆码：%s，拖码：%s", $dm, $tm);
			$len = count(explode(' ', $tm));
			$num-=count(explode(' ', $dm));
		}else{
			$len = count(explode(' ', $bet));
		}
		
		return self::C($len, $num);
	}

	//}}}
}


