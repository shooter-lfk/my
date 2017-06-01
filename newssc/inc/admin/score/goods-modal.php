<?php
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="/skin/admin/layout.css" media="all" />
<link type="text/css" rel="stylesheet" href="/skin/js/jqueryui/skin/smoothness/jquery-ui-1.8.21.custom.css" />
<script src="/skin/js/jquery-1.7.2.min.js"></script>
<script src="/skin/js/jqueryui/jquery.ui.core.js"></script>
<script src="/skin/js/jqueryui/jquery.ui.datepicker.js"></script>
<script src="/skin/js/jqueryui/i18n/jquery.ui.datepicker-zh-CN.js"></script>
<script>
$(function(){
	$(\':input[type=date]\').datepicker();
});
</script>
</head>
<body>
<form name="score_addGoods" action="/admin.php/Score/updateGoods" enctype="multipart/form-data" method="POST">
';
if($args[0]){
$goodsId=intval($args[0]);
$goods=$this->getRow("select * from {$this->prename}score_goods where id=$goodsId");
echo '<input type="hidden" name="id" value="',$goods['id'],'"/>';
}
;echo '    <table class="tablesorter left" cellspacing="0" width="100%">
    <thead> 
        <tr> 
            <td>项目</td> 
            <td>值</td> 
        </tr> 
    </thead>
    <tbody>
        <tr> 
            <td>商品名称</td> 
            <td><input type="text" name="title" value="';echo $goods['title'];echo '"/></td>
        </tr>
        <tr> 
            <td>简单介绍</td> 
            <td><textarea rows="3" name="content">';echo $goods['content'];echo '</textarea></td>
        </tr>
        <tr> 
            <td>积分</td> 
            <td><input type="text" name="score"  value="';echo $goods['score'];echo '"/></td>
        </tr>
        <tr> 
            <td>件数</td> 
            <td><input type="text" name="sum"  value="';echo $goods['sum'];echo '"/></td>
        </tr>
        <tr> 
            <td>时间</td> 
            <td>从 <input type="date"  name="startTime" style="width:75px;" value="';echo date('Y-m-d H:i',$goods['startTime']);echo '"/> 到  <input type="date" name="stopTime" style="width:75px;" value="';if($goods['stopTime']){echo date('Y-m-d H:i',$goods['stopTime']);}else{echo '0';};echo '"/><span class="spn6">0为不过期</span></td>
        </tr>
        <tr> 
            <td>缩略图</td> 
            <td><input type="file" name="picmin"/><img src="/';echo $goods['picmin'];echo '" width="80" height="50" border="0"/></td>
        </tr>
        <tr> 
            <td>大图</td> 
            <td><input type="file" name="picmax"/><img src="/';echo $goods['picmax'];echo '" width="120" height="50" border="0"/</td>
        </tr>
        <tr> 
            <td>状态</td> 
            <td>
                <label><input type="radio" value="1" name="enable" ';if($goods["enable"]==1){;echo ' checked=\'checked\'';};echo '/>开启</label>
                <label><input type="radio" value="0" name="enable" ';if($goods["enable"]==0){;echo ' checked=\'checked\'';};echo '/>关闭</label>
            </td> 
        <tr> 
    </tbody> 
    </table>
</form>
</body>
</html>';
?>