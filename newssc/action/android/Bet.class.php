<?php

class Bet{
public static function fs($bet){
$bets=explode(',',$bet);
$ret=1;
foreach($bets as $b){
$codes=str_split($b);
$ret*=count($codes);
}
return $ret;
}
public static function ds($bet){
return count(explode('|',$bet));
}
public static function z3($bet){
if(strpos($bet,',')===false &&!preg_match('/(\d).*\1/',$bet)){
return self::A(count(str_split($bet)),2);
}else{
return count(explode(',',$bet));
}
}
public static function z6($bet){
if(strpos($bet,',')===false &&!preg_match('/(\d).*\1/',$bet)){
return self::C(count(str_split($bet)),3);
}else{
return count(explode(',',$bet));
}
}
public static function z2($bet){
return self::C(count(str_split($bet)),2);
}
public static function dwd($bet){
return strlen(str_replace(array(',','-'),'',$bet));
}
public static function dxds($bet){
$bet=str_replace(array('大','小','单','双'),array(1,2,3,4),$bet);
return self::fs($bet);
}
public static function r1($bet){
return count(explode(' ',$bet));
}
public static function r2($bet){
return self::rx($bet,2);
}
public static function r3($bet){
return self::rx($bet,3);
}
public static function r4($bet){
return self::rx($bet,4);
}
public static function r5($bet){
return self::rx($bet,5);
}
public static function r6($bet){
return self::rx($bet,6);
}
public static function r7($bet){
return self::rx($bet,7);
}
public static function r8($bet){
return self::rx($bet,8);
}
public static function zx11($bet){
$bets=explode(',',$bet);
$ret=1;
foreach($bets as $b){
$codes=explode(' ',$b);
$ret*=count($codes);
}
return $ret;
}
public static function A($n,$m){
if($n<$m) return false;
$num=1;
for($i=0;$i<$m;$i++) $num*=$n-$i;
return $num;
}
public static function C($n,$m){
if($n<$m) return false;
return self::A($n,$m)/self::A($m,$m);
}
public static function rx($bet,$num){
if($pos=strpos($bet,')')){
$dm=substr($bet,1,$pos-1);
$tm=substr($bet,$pos+1);
$len = count(explode(' ',$tm));
$num-=count(explode(' ',$dm));
}else{
$len = count(explode(' ',$bet));
}
return self::C($len,$num);
}
}

?>