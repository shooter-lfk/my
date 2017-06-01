<?php

@session_start();
class Safe extends WebLoginBase{
public $title='IFC-英利国际';
private $vcodeSessionName='ssc_vcode_session_name';
public final function kf(){
$this->display('kf/kfym.php');
}
}
?>