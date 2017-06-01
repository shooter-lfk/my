<html>
<head>
<title>天恒时间检测</title>
</head>
<body bgcolor="black">
<script>
function reload(){
window.location.reload();
}
setTimeout("reload()",10000); 
</script>
<table frame="box" align="center" bgcolor="white"> 
<th>服务器时间</th>
<tr>
<td align="center"><?php $time = date("H点i分s秒"); echo $time;?> </td>
</tr>
<tr>
<td><iframe src="http://www.baidu.com/s?ie=utf-8&bs=%E5%9C%A8%E7%BA%BF%E6%97%B6%E9%92%9F&f=8&rsv_bp=1&rsv_spt=3&wd=%E5%8C%97%E4%BA%AC%E6%97%B6%E9%97%B4&rsv_sug3=6&rsv_sug=0&rsv_sug4=709&rsv_sug1=1&inputT=1722" width="280" height="230"></iframe>
</td>
</table>
</body>
</html>
