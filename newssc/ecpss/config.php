<?php
include '../config.php';
$userid="20023";
$userkey="^WvpeaQz";
$reqURL_onLine = "http://fjstys.com/ecpss-post.php";
function writeLog($str){
	$fp = fopen("log.txt","a");
	flock($fp, LOCK_EX);
	fwrite($fp,$str ." Time: ".date("Y-m-d h:i:s")."\r\n==============================\r\n");
	flock($fp, LOCK_UN); 
	fclose($fp);	
}
?>