var http=require('http'),
url=require('url'),
chat=require('./chat.js'),
wsio = require('websocket.io'),
fs=require('fs');


var server=http.createServer(function(request, response){
	var ret=[];
	response.writeHead(200, {"Content-Type": "text/json"});
	try{
		get=url.parse(request.url, true);
		
		//console.log(get);
		
		var action=get.pathname.substr(1);
		var jsonpcallback=get.query.jsonpcallback;
		
		if(action && chat[action] && (typeof chat[action]=='function')){
			delete get.query.jsonpcallback;
			delete get.query._;
			//console.log(get.query);
			ret=chat[action](get.query);
			//console.log(ret);
		}
		//console.log(jsonpcallback);
		response.write(jsonpcallback+'('+JSON.stringify(ret)+')');
	}catch(err){
		console.log(err);
	}
	response.end();
	
});

global.wsclients=[];
var wslen=0;
ws=wsio.attach(server);
ws.on('connection', function(client){
	//console.log(client);
	client.clientLength=++wslen;
	global.wsclients.push(client);
	console.log('有新的用户连接，总连接数：%d', global.wsclients.length);
	
	client.on('close', function(){
		for(var i=0; i<global.wsclients.length; i++){
			console.log('当前：%d，后者：%d', client.clientLength, global.wsclients[i].clientLength);
			if(global.wsclients[i]==client){
				global.wsclients.splice(i,1);
				console.log(i);
				console.log('有用户断开连接，总连接数：%d', global.wsclients.length);
				return;
			}
		}
	});
});



server.listen(8080);

