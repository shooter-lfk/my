<?php
echo '<script>
var arr=location.href.split("?");
arr.push("");
</script>
<script>
  document.write("<frameset rows=\\"*\\" cols=\\"*\\" frameborder=\\"no\\" border=\\"0\\" framespacing=\\"0\\" style=\\"margin:-97px 0 0 -8px;width:496px;height:455px;padding:0;overflow:hidden;\\">");
  document.write("<frame src=\\"http://home.yimikf.com/company.php?ym_a=ifcg&style=1&"+arr[1]+"\\" title=\\"mainFrame\\" />");
  //document.write("<frameset rows=\\"*\\" cols=\\"*\\" frameborder=\\"no\\" border=\\"0\\" framespacing=\\"0\\" style=\\"margin-top:-37px;width:436px;height:546px;padding:0;overflow:hidden;\\">");
  //document.write("<frame src=\\"http://59022.fy.kf.qycn.com/vclient/chat/?clienturl=http%3A//www.ifcn.in&websiteid=59022&"+arr[1]+"\\" title=\\"mainFrame\\" />");
  document.write("</frameset>");
</script>
';
?>