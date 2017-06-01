/**
 * 监听设置，一般设置监听端口和域名，要与前台一致
 */
exports.listen={
	port:8080
	// host:'localhost'
};

// 信息保存时间，过时的信息将清除，单位为秒
exports.expire=60;

// 发言长度
exports.chatLen=320;

// 禁言时间，以分钟为单位
exports.gagTime=2;

// 屏蔽关键词，用竖线分隔多个关键词
disword='法轮功|共产党|胡锦涛';

exports.disword=disword.split('|');

// 转换，一个对象，键为被转换的字符串，值为转换成的字符串
// 可把表情放在些处处理
exports.swapword={
	
	// 过滤HTML标签
	'<':'&lt;', 
	'>':'&gt;',
	
	// 表情
	'/:01':'<img src="/skin/main/images/face/01.gif" width="32" height="32"/>',
	'/:02':'<img src="/skin/main/images/face/02.gif" width="32" height="32"/>',
	'/:03':'<img src="/skin/main/images/face/03.gif" width="32" height="32"/>',
	'/:04':'<img src="/skin/main/images/face/04.gif" width="32" height="32"/>',
	'/:05':'<img src="/skin/main/images/face/05.gif" width="32" height="32"/>',
	'/:06':'<img src="/skin/main/images/face/06.gif" width="32" height="32"/>',
	'/:07':'<img src="/skin/main/images/face/07.gif" width="32" height="32"/>',
	'/:08':'<img src="/skin/main/images/face/08.gif" width="32" height="32"/>',
	'/:09':'<img src="/skin/main/images/face/09.gif" width="32" height="32"/>',
	'/:10':'<img src="/skin/main/images/face/10.gif" width="32" height="32"/>',
	'/:11':'<img src="/skin/main/images/face/11.gif" width="32" height="32"/>',
	'/:12':'<img src="/skin/main/images/face/12.gif" width="32" height="32"/>',
	'/:13':'<img src="/skin/main/images/face/13.gif" width="32" height="32"/>',
	'/:14':'<img src="/skin/main/images/face/14.gif" width="32" height="32"/>',
	'/:15':'<img src="/skin/main/images/face/15.gif" width="32" height="32"/>',
	'/:16':'<img src="/skin/main/images/face/16.gif" width="32" height="32"/>',
	
}

