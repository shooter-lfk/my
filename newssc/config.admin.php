<?php

$conf['debug']['level']=5;
$conf['db']['dsn']='mysql:host=rm-wz9e37hjn83a09501o.mysql.rds.aliyuncs.com;dbname=ssc';
$conf['db']['user']='root';
$conf['db']['password']='Show19467';
$conf['db']['charset']='utf8';
$conf['db']['prename']='ssc_';
$conf['cache']['expire']=0;
$conf['cache']['dir']='_cache/';
$conf['url_modal']=2;
$conf['action']['template']='inc/admin/';
$conf['action']['modals']='action/admin/';
$conf['member']['sessionTime']=15*60;
$conf['node']['access']='http://localhost:8800';
error_reporting(E_ERROR &~E_NOTICE);
ini_set('date.timezone','asia/shanghai');

?>