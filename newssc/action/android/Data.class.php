<?php

class Data extends WebLoginBase{
public final function getData($typeList){
$types=explode(',',$typeList);
$data=array();
$sql='select number, data from ssc_data where type=? order by id desc limit 10';
foreach($types as $type){
$data[$type]=$this->getRows($sql,$type);
}
return $data;
}
}

?>