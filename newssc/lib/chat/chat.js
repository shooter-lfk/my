/**
 * 全局变量msg用于保存用户聊天记录
 * 每条记录为数组的一个元素，也就是一个对象，对象原型如下：
 * {
 *		user:'jcode',
 *		time:(new Date()).getTime(),
 *		chat:'发言内容'
 * }
 *
 * 数组的长度不限，只是按时清除之前不要的数据
 */
var msg=[];

/**
 * 禁言列表
 * 一个对象，键为用户名，值为禁言过期时间
 * {
 *		'jcode':new Date()
 *		
 * }
 *
 */
var gag={};

var config=require('./config.js');

/**
 * 定时清掉不要的发言
 */
setInterval(function(){
	var i,l=msg.length,time=(new Date()).getTime()-config.expire*1000;
	//console.log(msg);
	for(i=0; i<l; i++){
		if(msg[i].time>time){
			if(i) msg.splice(0,i);
			return;
		}
	}
	
}, 10000);

/**
 * 获取聊天信息
 */

exports.get=function(data){
	var i,l=msg.length;
	//console.log(msg);
	//console.log(data);
	if(!data.time){
		data.time=(new Date()).getTime();
	}
	//console.log(data);
	for(i=0; i<l; i++){
		if(data.time<msg[i].time){
			data.chats=msg.slice(i);
		}
	}
	
	data.time=(new Date()).getTime();
	return data;
}

/**
 * 发言
 *
 */
exports.say=function(data){
	// 检查用户是否被禁言
	var time=new Date(),
	para={
		user:data.user,
		time:data.time
	};
	
	if(gag[data.user]){
		if(gag[data.user]>time){
			return {error:'你已经被管理员禁言，还有'+Math.floor((gag[data.user]-time)/1000)+'秒钟才能发言', code:1};
		}else{
			delete gag[data.user];
		}
	}
	
	// 超长文本直接截断
	if(data.chat.length>config.chatLen){
		data.chat=data.chat.substr(0,config.chatLen);
	}
	
	// 转换文本处理
	var txt;
	for(txt in config.swapword){
		data.chat=data.chat.replace(txt, config.swapword[txt]);
	}
	
	// 屏蔽关键词处理
	//if(!Array.isArray(config.disword)) config.disword=config.disword.split('|');
	//console.log(config.disword);
	config.disword.forEach(function(word){
		data.chat=data.chat.replace(word, '***');
	});
	
	
	data.time=time.getTime();
	//data.user=data.user.replace(/^(\w)\w*(\w{3})$/, "$1***$2");

	// 把发言添加到发言列表
	msg.push(data);
	return '';
	
	// 返回最近发言
	//return exports.get(para);
}

/**
 * 禁言（管理员操作）
 */
function setGad(data){
	gag[data.user]=new Date();
	gag[data.user].setTime(gag[data.user]+config.gagTime*60*1000);
	
	msg.push({
		user:'管理员',
		time:(new Date()).getTime(),
		chat:data.user.replace(/^(\w)\w*(\w{3})$/, "$1***$2")+'被管理员禁言'+config.gagTime+'分钟'
	});
	
	return {};
}