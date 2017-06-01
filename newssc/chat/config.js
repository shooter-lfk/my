/**
 * 监听设置，一般设置监听端口和域名，要与前台一致
 */
exports.listen={
	port:8080
	//host:'localhost'
};

// 信息保存时间，过时的信息将清除，单位为秒
exports.expire=60;

// 发言长度
exports.chatLen=50;

// 禁言时间，以分钟为单位
exports.gagTime=24*60;

// 屏蔽关键词，用竖线分隔多个关键词
disword='法轮功|输|亏|1|2|3|4|5|6|7|8|9|0|黑|淫|垃圾|小|加|Q|W|E|R|T|Y|U|I|O|P|A|S|D|F|G|H|J|K|L|Z|X|C|V|B|N|M|q|w|e|r|t|y|u|i|o|p|a|s|d|f|g|h|j|k|l|z|x|c|v|b|n|m';

exports.disword=disword.split('|');

// 转换，一个对象，键为被转换的字符串，值为转换成的字符串
// 可把表情放在些处处理
exports.swapword={
	
	// 过滤HTML标签
	'<':'&lt;', 
	'>':'&gt;',
	
	// 表情
	'/:喂':'<img src="/skin/main/images/face/01.gif" width="32" height="32"/>',
	'/:羞':'<img src="/skin/main/images/face/02.gif" width="32" height="32"/>',
	'/:哈':'<img src="/skin/main/images/face/03.gif" width="32" height="32"/>',
	'/:冻':'<img src="/skin/main/images/face/04.gif" width="32" height="32"/>',
	'/:委曲':'<img src="/skin/main/images/face/05.gif" width="32" height="32"/>',
	'/:坏笑':'<img src="/skin/main/images/face/06.gif" width="32" height="32"/>',
	'/:闭嘴':'<img src="/skin/main/images/face/07.gif" width="32" height="32"/>',
	'/:嘿':'<img src="/skin/main/images/face/08.gif" width="32" height="32"/>',
	'/:色':'<img src="/skin/main/images/face/09.gif" width="32" height="32"/>',
	'/:问':'<img src="/skin/main/images/face/10.gif" width="32" height="32"/>',
	'/:哭':'<img src="/skin/main/images/face/11.gif" width="32" height="32"/>',
	'/:丫':'<img src="/skin/main/images/face/12.gif" width="32" height="32"/>',
	'/:睡':'<img src="/skin/main/images/face/13.gif" width="32" height="32"/>',
	'/:得意':'<img src="/skin/main/images/face/14.gif" width="32" height="32"/>',
	'/:荡':'<img src="/skin/main/images/face/15.gif" width="32" height="32"/>',
	'/:汗':'<img src="/skin/main/images/face/16.gif" width="32" height="32"/>',
	
}

