// 彩票开奖配置
exports.cp=[
	//{{{
		{
		title:'CQC',
		source:'500wan',
		name:'cqssc',
		enable:true,
		timer:'cqssc',

		option:{
			host:"www.8088.com",
			timeout:30000,
			path: '/static/public/ssc/xml/newlyopenlist.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/24.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				str=str.substr(0,300);
				var m;
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" abbdate="(\d+?)" endtime="([\d\:\- ]+?)" order="(\d+?)" opentime="([\d\:\- ]+?)" \/>/;              
				if(m=str.match(reg)){
					return {
						type:1,
						time:m[6],
						number:20+m[1].replace(/^(\d{6})(\d{3})$/, '$1-$2'),
						data:m[2]
					};
				}
			}catch(err){
				throw('重庆时时彩解析数据不正确');
			}
		}
	},
	
	{
		title:'CQC',
		source:'cailele',
		name:'cqssc',
		enable:true,
		timer:'cqssc2',

		option:{
			host:"www.cailele.com",
			timeout:30000,
			path: '/static/ssc/newlyopenlist.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/22.0.1271.64 Safari/537.11"
			}
		},
		parse:function(str){
			try{
				//return getFromCaileleWeb(str,1);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				//<row expect="20130720017" opencode="4,9,1,2,9" opentime="2013-07-20 01:25:30"/>
				var m;
	
				if(m=str.match(reg)){
					return {
						type:1,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{3})$/, '$1-$2'),
						data:m[2]
					};
				}					
				
			}catch(err){
				throw('重庆时时彩解析数据不正确');
			}
		}
	},
	//}}}
	
	//{{{
	{
		title:'SD115',
		source:'cailele',
		name:'sd11x5',
		enable:true,
		timer:'sd11x5',

		option:{
			host:"www.cailele.com",
			timeout:30000,
			path: '/static/11yun/newlyopenlist.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilecWeb(str,7);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				//<row expect="13072178" opencode="06,03,05,08,01" opentime="2013-07-21 21:55:30" />
				var m;
	
				if(m=str.match(reg)){
					return {
						type:7,
						time:m[3],
						number:20+m[1].replace(/^(\d{6})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('山东115解析数据不正确');
			}
		}
	},
	//}}}
	
	//{{{
	{
		title:'CQ115',
		source:'cailele',
		name:'cq11x5',
		enable:true,
		timer:'cq11x5',

		option:{
			host:"www.cailele.com",
			timeout:30000,
			path: '/static/cq11x5/newlyopenlist.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromCaileWeb(str,15);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				//<row expect="2013071985" opencode="09,08,06,04,05" opentime="2013-07-19 23:00:20"/>
				var m;
	
				if(m=str.match(reg)){
					return {
						type:15,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('重庆11选5解析数据不正确');
			}
		}
	},
	//}}}
	
	//{{{
	{
		title:'GD115',
		source:'cailele',
		name:'gd11x5',
		enable:true,
		timer:'gd11x5',

		option:{
			host:"www.cailele.com",
			timeout:30000,
			path: '/static/gd11x5/newlyopenlist.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromCaileWeb(str,6);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				//<row expect="2013071984" opencode="04,11,05,03,07" opentime="2013-07-19 23:00:15"/>
				var m;
	
				if(m=str.match(reg)){
					return {
						type:6,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('广东11选5解析数据不正确');
			}
		}
	},
	//}}}
	
	//{{{
	{
		title:'SH115',
		source:'Goal',
		name:'sh11x5',
		enable:true,
		timer:'sh11x5',

		option:{
			host:"caipiao.gooooal.com",
			timeout:30000,
			path: '/bonussh115!query.action',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			return getFromGoalWeb(str,16);
		}
	},
	//{
	//	title:'SH115',
	//	source:'lecai',
	//	name:'sh11x5',
	//	enable:true,
	//	timer:'sh11x5',

	//	option:{
	//		host:"www.lecai.com",
	//		timeout:30000,
	//		path: '/lottery/sh11x5/',
	//		headers:{
	//			"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11"
	//		}
	//	},
		
	//	parse:function(str){
	//		return getFromLecaiaWeb(str,16);
	//	}
	//},
	//}}}
	
	//{{{
	{
		title:'LN115',
		source:'cailele',
		name:'ln11x5',
		enable:true,
		timer:'ln11x5',

		option:{
			host:"www.cailele.com",
			timeout:30000,
			path: '/static/ln11x5/newlyopenlist.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			//return getFromCalilebWeb(str,17);
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				//<row expect="2013071983" opencode="03,08,09,04,06" opentime="2013-07-19 22:30:00"/>
				var m;
	
				if(m=str.match(reg)){
					return {
						type:17,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}	
			}catch(err){
				throw('辽宁115解析数据不正确');
			}
		}
	},
	//}}}
	
	//{{{
	{
		title:'3D',
		source:'500wan',
		name:'fc3d',
		enable:true,
		timer:'fc3d',

		option:{
			host:"www.500wan.com",
			timeout:30000,
			path: '/static/info/kaijiang/xml/sd/list10.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/24.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				str=str.substr(0,300);
				var m;
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)" trycode="[\d\,]*?" tryinfo="" \/>/;                                      
				if(m=str.match(reg)){
					return {
						type:9,
						time:m[3],
						number:m[1],
						data:m[2]
					};
				}
			}catch(err){
				throw('3D解析数据不正确');
			}
		}
	},
	//}}}
	
	//{{{
	{
		title:'P3',
		source:'500wan',
		name:'pai3',
		enable:true,
		timer:'pai3',

		option:{
			host:"www.500wan.com",
			timeout:30000,
			path: '/static/info/kaijiang/xml/pls/list10.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/25.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				str=str.substr(0,300);
				var m;	 
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/;
				if(m=str.match(reg)){
					return {
						type:10,
						time:m[3],
						number:20+m[1],
						data:m[2]
					};
				}
			}catch(err){
				throw('P3解析数据不正确');
			}
		}
	},
	//}}}
	
	//{{{
	{
		title:'XJC',
		source:'xjflcp',
		name:'xjssc',
		enable:true,
		timer:'xjssc',

		option:{
			host:"www.xjflcp.com",
			timeout:30000,
			path: '/ssc/',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/26.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				return getFromXJFLCPWeb(str,12);
			}catch(err){
				throw('新疆时时彩解析数据不正确');
			}
		}
	},
	//}}}


	//{{{
	{
		title:'JXC',
		source:'cailele',
		name:'jxssc',
		enable:true,
		timer:'jxssc',

		option:{
			host:"www.cailele.com",
			timeout:30000,
			path: '/static/jxssc/newlyopenlist.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromShishicaiWeb(str,3);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				//<row expect="20130719084" opencode="3,0,6,3,6" opentime="2013-07-19 23:12:25"/>
				var m;
	
				if(m=str.match(reg)){
					return {
						type:3,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{3})$/, '$1-$2'),
						data:m[2]
					};
				}	
			}catch(err){
				throw('江西时时彩解析数据不正确');
			}
		}
	},
	//}}}
	
	//{{{
	{
		title:'PK10',
		source:'BWLC',
		name:'pk10',
		enable:true,
		timer:'pk101',

		option:{
			host:"www.bwlc.gov.cn",
			timeout:30000,
			path: '/bulletin/index.jsp?id=2',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			return getFromBwlcWeb(str,19);
		}
	},
	//{
	//	title:'PK10',
	//	source:'LC',
	//	name:'pk102',
	//	enable:true,
	//	timer:'pk10',

	//	option:{
	//		host:"www.lecai.com",
	//		timeout:30000,
	//		path: '/lottery/pk10/',
	//		headers:{
	//			"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11"
	//		}
	//	},
		
	//	parse:function(str){
	//		return getFromLecaibWeb(str,19);
	//	}
	//},
	//}}}

	//{{{
		{
		title:'XYSC',
		source:'500wan',
		name:'xysc',
		enable:true,
		timer:'xysc',

		option:{
			host:"www.500.com",
			timeout:30000,
			path: '/static/public/xysc/xml/newlyopenlist.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/24.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				str=str.substr(0,300);
				var m;
				var reg=/<row firstwin="(\d+?)" firstthree="(\d+?)" opentime="([\d\:\- ]+?)" opencode="([\d\,]+?)" firsttwo="(\d+?)" place="([\d\|]+?)" expect="(\d+?)" abbdate="(\d+?)" endtime="([\d\:\- ]+?)" order="(\d+?)"  \/>/;  
				if(m=str.match(reg)){
					return {
						type:18,
						time:m[3],
						number:20+m[7].replace(/^(\d{6})(\d{2})$/, '$1-0$2'),
						data:m[4]
					};
				}
			}catch(err){
				throw('幸运赛车解析数据不正确');
			}
		}
	},
		//}}}

		//{{{
	{
		title:'SSL',
		source:'500',
		name:'shssl',
		enable:true,
		timer:'shssl',

		option:{
			host:"kaijiang.500.com",
			timeout:30000,
			path: '/static/public/ssl/xml/opencode.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/29.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				str=str.substr(0,100);
				var reg=/<row opentime="([\d\:\- ]+?)" opencode="([\d\,]+?)" expect="([\d\-]+?)"/; 
				//<row opentime="2013-07-25 21:30:32" opencode="960" expect="20130725-23">
				var m;
	
				if(m=str.match(reg)){
					return {
						type:11,
						time:m[1],
						number:m[3],
						data:m[2].replace(/^(\d{1})(\d{1})(\d{1})$/, '$1,$2,$3')
					};
				}	
			}catch(err){
				throw('上海时时乐解析数据不正确');
			}
		}
	},
	//}}}
	
	//{{{
	{
		title:'YTDJ',
		source:'500wan',
		name:'ytdj',
		enable:true,
		timer:'ytdj',

		option:{
			host:"kaijiang.500.com",
			timeout:1000,
			path: '/static/info/kaijiang/xml/ytdj/newlyopen.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/24.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d+\-]+?)"/; 
				var m;
				dat=new Date();
				preYear=dat.getFullYear();
				preMonth=dat.getMonth()+1;
				preDate=dat.getDate();
				preHour=dat.getHours();  
				preMinu=dat.getMinutes();  
				date=preYear+'-'+preMonth+'-'+preDate+' '+preHour+':'+preMinu;
	
				if(m=str.match(reg)){
					return {
						type:20,
						time:date,
						number:20+m[1].replace(/^(\d{6})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}
			}catch(err){
				throw('泳坛夺金解析数据不正确');
			}
		}
	},
	//}}}
		
	//{{{
	{
		title:'KLSF',
		source:'caile',
		name:'klsf',
		enable:true,
		timer:'klsf',

		option:{
			host:"www.cailele.com",
			timeout:30000,
			path: '/static/cqklsf/newlyopenlist.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				//return getFromCaileWeb(str,21);
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				//<row expect="2013072213" opencode="07,16,03,17,01,05,13,12" opentime="2013-07-22 02:03:20" />
				var m;
	
				if(m=str.match(reg)){
					return {
						type:21,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-0$2'),
						data:m[2]
					};
				}					
			}catch(err){
				throw('快乐十分解析数据不正确');
			}
		}
	},
	{
		title:'KLSF',
		source:'caile',
		name:'klsf',
		enable:true,
		timer:'klsf2',

		option:{
			host:"kjh.cailele.com",
			timeout:30000,
			path: '/history_cqklsf.aspx',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/22.0.1271.64 Safari/537.11"
			}
		},
		parse:function(str){
			try{
				return getFromCailesWeb(str,21);
			}catch(err){
				throw('快乐十分解析数据不正确');
			}
		}
	},
//}}}
];

// 出错时等待
exports.errorSleepTime=15;

// 重启时间间隔，以小时为单位，0为不重启
exports.restartTime=0.4;

exports.submit={
	//host:'www.ssc.com',
	host:'localhost',
	path:'/admin.php/dataSource/kj'
}

exports.dbinfo={
	host:'127.0.0.1',
	user:'root',
	password:'root',
	database:'ssc'
}

global.log=function(log){
	var date=new Date();
	console.log('['+date.toDateString() +' '+ date.toLocaleTimeString()+'] '+log)
}

function getFromShishicaiWeb(str, type, char){
	//var reg=/var\s*listIssue\s*\=\s*\[(.*?)\,{/,
	var reg=/\{\"i\"\:\"[\d\-]+\"\,\"b\"\:\"[\d\,]+\"\,\"s\"\:\d+\,\"et\"\:\"[\d\-\: ]+\"\}/,
	match=str.match(reg);
	matchData=str.split('kkListNumber.show(["')[1].split('",')[0];
	if(type!=7) matchData=matchData.split('').join(',');
	//console.log(matchData);
	char=char||'';
	if(!match) throw new Error('数据不正确');
	
	// 解析数据
	try{
		var data=JSON.parse(match[0]);

		data={
			type:type,
			time:data.et,
			number:data.i,
			data:matchData
			//data:data.b.split(char).join(',')
		}
		//console.log(data);
		return data;
		
	}catch(err){
		throw('解析数据失败：'+match[1]);
	}
}

function getFromCaileleWeb(str, type){

	//console.log(str);
	str=str.substr(str.indexOf('<tr bgcolor="#FFFAF3">'),540);
	
	//console.log(str);
	
	var reg=/<td.*?>(\d+)<\/td>[\s\S]*?<td.*?>([\d\- \:]+)<\/td>[\s\S]*?<td.*?>((?:[\s\S]*?<div class="ball_yellow">\d+<\/div>){3,5})\s*<\/td>/,
	match=str.match(reg);
	
	//console.log(match);
	
	//console.log(str);
	if(!match) throw new Error('数据不正确');
	try{
		var data={
			type:type,
			time:match[2],
			number:'20'+match[1].replace(/^(\d{6})/,'$1-')
		}
		
		reg=/<div.*>(\d+)<\/div>/g;
		data.data=match[3].match(reg).map(function(v){
			var reg=/<div.*>(\d+)<\/div>/;
			return v.match(reg)[1];
		}).join(',');
		
		//console.log(data);
		return data;
	}catch(err){
		throw('解析数据失败');
	}
	
}

function getFromCaileWeb(str, type){

	//console.log(str);
	str=str.substr(str.indexOf('<tr bgcolor="#FFFAF3">'),540);
	
	//console.log(str);
	
	var reg=/<td.*?>(\d+)<\/td>[\s\S]*?<td.*?>([\d\- \:]+)<\/td>[\s\S]*?<td.*?>((?:[\s\S]*?<div class="ball_yellow">\d+<\/div>){3,5})\s*<\/td>/,
	match=str.match(reg);
	
	//console.log(match);
	
	//console.log(str);
	if(!match) throw new Error('数据不正确');
	try{
		var data={
			type:type,
			time:match[2],
			number:match[1].replace(/^(\d{8})/,'$1-0')
		}
		
		reg=/<div.*>(\d+)<\/div>/g;
		data.data=match[3].match(reg).map(function(v){
			var reg=/<div.*>(\d+)<\/div>/;
			return v.match(reg)[1];
		}).join(',');
		
		//console.log(data);
		return data;
	}catch(err){
		throw('解析数据失败');
	}
	
}


function getFromCalilebWeb(str, type){
	//console.log(str);
	str=str.substr(str.indexOf('<tbody id="openPanel">'),100);
	var reg=/.*(\d{8}).*([\d+\:]{5}).*([\d+,]{14})<\/td><\/tr>/,
	
	match=str.match(reg);
	dat=new Date();
	preYear=dat.getFullYear();
	preMonth=dat.getMonth()+1;
	preDate=dat.getDate();
	date=preYear+'-'+preMonth+'-'+preDate;
	
	if(!match) throw new Error('数据不正确');
	try{
		var data={
			type:type,
			time:date+' '+match[2]+':00',
			number:'20' + match[1].replace(/(\d{6})(\d{2})/,'$1-0$2'),
			data:match[3]
		}
		

		return data;
	}catch(err){
		throw('解析数据失败');
	}
}


function getFromCalilecWeb(str, type){
	//console.log(str);
	str=str.substr(str.indexOf('<tbody id="openPanel">'),100);
	var reg=/.*(\d{6}).*([\d+\:]{5}).*([\d+,]{14})<\/td><\/tr>/,
	
	match=str.match(reg);
	dat=new Date();
	preYear=dat.getFullYear();
	preMonth=dat.getMonth()+1;
	preDate=dat.getDate();
	date=preYear+'-'+preMonth+'-'+preDate;
	
	if(!match) throw new Error('数据不正确');
	try{
		var data={
			type:type,
			time:date+' '+match[2]+':00',
			number:preYear + match[1].replace(/(\d{4})(\d{2})/,'$1-0$2'),
			data:match[3]
		}
		

		return data;
	}catch(err){
		throw('解析数据失败');
	}
}
function getFromCailesWeb(str, type){

	//console.log(str);
	str=str.substr(str.indexOf('<tr bgcolor="#FFFAF3">'),540);
	
	//console.log(str);
	
	var reg=/<td.*?>(\d+)<\/td>[\s\S]*?<td.*?>([\d\- \:]+)<\/td>[\s\S]*?<td.*?>((?:[\s\S]*?<div class="ball_yellow">\d+<\/div>){3,5})\s*<\/td>/,
	match=str.match(reg);
	
	//console.log(match);
	
	//console.log(str);
	if(!match) throw new Error('数据不正确');
	try{
		var data={
			type:type,
			time:match[2],
			number:'20'+match[1].replace(/^(\d{6})(\d{2})$/, '$1-0$2')
		}
		
		reg=/<div.*>(\d+)<\/div>/g;
		data.data=match[3].match(reg).map(function(v){
			var reg=/<div.*>(\d+)<\/div>/;
			return v.match(reg)[1];
		}).join(',');
		
		//console.log(data);
		return data;
	}catch(err){
		throw('解析数据失败');
	}
}


function getFromXJFLCPWeb(str, type){
	str=str.substr(str.indexOf('<td><a href="javascript:detatilssc'), 300).replace(/[\r\n]+/g,'');
         
	var reg=/(\d{10}).+(\d{2}\:\d{2}).+<p>([\d ]{9})<\/p>/,
	match=str.match(reg);
	
	if(!match) throw new Error('数据不正确');
	//console.log('期号：%s，开奖时间：%s，开奖数据：%s', match[1], match[2], match[3]);
	
	try{
		var data={
			type:type,
			time:match[1].replace(/^(\d{4})(\d{2})(\d{2})\d{2}/, '$1-$2-$3 ')+match[2],
			number:match[1].replace(/^(\d{8})(\d{2})$/, '$1-$2'),
			data:match[3].split(' ').join(',')
		};
		//console.log(data);
		return data;
	}catch(err){
		throw('解析数据失败');
	}
}

function getFromBwlcWeb(str, type){
	str=str.substr(str.indexOf('<tr class="dataBack1">'), 200).replace(/[\r\n]+/g,'');
         
	var reg=/<td>(\d{6}).+([\d+,]{29}).+([\d\- \:]{16})<\/td>/,
				 //<td>374454</td><td>04,10,01,03,05,09,06,07,02,08</td><td>2013-07-25 23:57</td>

	match=str.match(reg);
	
	if(!match) throw new Error('数据不正确');
                    
	try{
		var data={
			type:type,
			time:match[3],
			number:match[1],
			data:match[2]
		};
		//console.log(data);
		return data;
	}catch(err){
		throw('解析数据失败');
	}
}


function getFromGoalWeb(str, type){
	str=str.substr(str.indexOf('<tr bgcolor=\'\'>'), 240).replace(/[\r\n]+/g,'').replace(/<\/?script.*?>/g, '').replace(/<\/?span.*?>/g, '');
         
	var reg=/.+(\d{10}).+([\d+,]{14}).+([\d\- \:]{16}).+/,
				 //<td>2013072590</td><td>02,11,01,04,10</td><td>2013-07-25 23:49</td>
	match=str.match(reg);
	
	if(!match) throw new Error('数据不正确');
                    
	try{
		var data={
			type:type,
			time:match[3],
			number:match[1].replace(/(\d{8})(\d{2})/,'$1-0$2'),
			data:match[2]
		};
		//console.log(data);
		return data;
	}catch(err){
		throw('解析数据失败');
	}
}

function getFromLecaiWeb(str, type){
	var reg=/<tr class=\"tr_tab_1\">.*?<\/tr>/;
	str=reg.exec(str)[0].replace(/\s+/g,'').replace(/<\/?span.*?>/g, '');
	// <tr class="tr_tab_1"><td>12111751期</td><td>17:25</td><td>0111020304</td></tr>
	
	reg=/(\d{8}).*(\d{2}\:\d{2}).*(\d{10})/;
	var m=reg.exec(str);
	var time=new Date();
	var preYear=time.getFullYear().toString().substr(0,2);

	var data={};

	data.type=type,
	data.number=preYear + m[1].replace(/(\d{6})(\d{2})/,'$1-0$2');
	data.time=preYear + m[1].replace(/^(\d{2})(\d{2})(\d{2}).*/, '$1-$2-$3 ')+m[2];
	data.data=m[3].replace(/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1,$2,$3,$4,$5');

	return data;
}

function getFromLecaiaWeb(str, type){
	var reg=/<tr class=\"tr_tab_1\">.*?<\/tr>/;
	str=reg.exec(str)[0].replace(/\s+/g,'').replace(/<\/?span.*?>/g, '');
	// <tr class="tr_tab_1"><td>12111751期</td><td>17:25</td><td>0111020304</td></tr>
	
	reg=/(\d{10}).*(\d{2}\:\d{2}).*(\d{10})/;
	var m=reg.exec(str);
	var time=new Date();
	var preYear=time.getFullYear().toString().substr(0,2);

	var data={};

	data.type=type,
	data.number=m[1].replace(/(\d{8})(\d{2})/,'$1-0$2');
	data.time=m[1].replace(/^(\d{4})(\d{2})(\d{2}).*/, '$1-$2-$3 ')+m[2];
	data.data=m[3].replace(/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1,$2,$3,$4,$5');

	return data;
}


function getFromLecaibWeb(str, type){
	var reg=/width=\"100%\" id=\"kj_table_1\">.*?<\/table>/;
	str=reg.exec(str)[0].replace(/\s+/g,'').replace(/<\/?span.*?>/g, '');
			//<tr ><td>372834期</td><td>23:12</td><td>05040801071003020609</td></tr>
	
	reg=/(\d{6}).*([\d+\:]{5}).*(\d{20})/;
	var m=reg.exec(str);
	dat=new Date();
	preYear=dat.getFullYear();
	preMonth=dat.getMonth()+1;
	preDate=dat.getDate();
	date=preYear+'-'+preMonth+'-'+preDate

	var data={};

	data.type=type,
	data.number=m[1];
	data.time=dat;
	data.data=m[3].replace(/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1,$2,$3,$4,$5,$6,$7,$8,$9,$10');

	return data;
}
