<div class="header"><div class="top">
	<div class="logo"></div>
	<div class="webtime" id="bgclock"></div>
<script language="javascript">  
function clockon()  
{  
    var now = new Date();  
    var year = now.getFullYear(); //getFullYear getYear  
    var month = now.getMonth();  
    var date = now.getDate();  
    var day = now.getDay();  
    var hour = now.getHours();  
    var minu = now.getMinutes();  
    var sec = now.getSeconds();  
    var week;  
     month = month+1;  
    if(month<10)month="0"+month;  
    if(date<10)date="0"+date;  
    if(hour<10)hour="0"+hour;  
    if(minu<10)minu="0"+minu;  
    if(sec<10)sec="0"+sec;  
    var arr_week = new Array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");  
     week = arr_week[day];  
    var time = "";  
     time = year+"-"+month+"-"+date+" "+hour+":"+minu+":"+sec+" "+week+"";  
   
    document.getElementById("bgclock").innerHTML=""+time+"";  
    var timer = setTimeout("clockon()",200);              
}  
clockon();  
</script> 
  <div class="topInfo">
	<ul>
		<li class="logout"><a href="/index.php/user/logout"></a></li>
		<li class="ask">
			<a onClick="art.dialog.open('http://api.pop800.com/chat/111756', {id: 'testID4',lock: true,title: '在线客服系统',width:976, height:620});"></a></li>
		
		<li class="sjdl qdyj"><a class="sjdl-link qdyj-link"  target="ajax" call="indexSign" datatype="json" href="/index.php/display/sign">签到有奖</a></li>
	</ul>
</div>
</div>
<div class="indexbg"><div class="w968">
<div class="pleft">
	<div class="leftbox">
