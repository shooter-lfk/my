var http=require('http'),
url=require('url'),
chat=require('./chat.js'),
fs=require('fs');


http.createServer(function(request, response){
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
	
}).listen(8080);

