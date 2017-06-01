<?php

$sql="select * from {$this->prename}coin_log where `uid`={$this->user['uid']} and liqType in (2,3,6) order by id desc limit 10";
$data=$this->getRows($sql);
if($data) foreach($data as $var){
echo '<p>';
switch($var['liqType']){
case 2:
echo '订单[<a href="/index.php/record/betInfo/',$var['extfield0'],'" width="510" title="投注信息" button="关闭:defaultModalCloase" target="modal">',$var['extfield0'],'</a>]得到返点：',$var['coin'],'元';
break;
case 3:
echo '下家',$var['extfield2'],'购买的单子[<a href="/index.php/record/betInfo2/',$var['extfield0'],'" width="510" title="投注信息" button="关闭:defaultModalCloase" target="modal">',$var['extfield0'],'</a>]得到返点：',$var['coin'],'元';
break;
case 6:
echo '订单[<a href="/index.php/record/betInfo/',$var['extfield0'],'" width="510" title="投注信息" button="关闭:defaultModalCloase" target="modal">',$var['extfield0'],'</a>]中奖：',$var['coin'],'元';
break;
}
}
?>