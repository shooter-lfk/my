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
		source:'310win',
		name:'cqssc',
		enable:false,
		timer:'cqssc3',

		option:{
			host:"www.310win.com",
			timeout:30000,
			path: '/ssc/kaijiang_gp_120.html',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/21.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				var data=JSON.parse(str).Table[0];
				return {
					type:1,
					time:data.AwardTime,
					number:data.IssueNum.replace(/^(\d{8})(\d{3})$/, "$1-$2"),
					data:data.Result.split(' ').join(',')
				};
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
			host:"kjh.cailele.com",
			timeout:30000,
			path: '/history_cqssc.aspx',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/22.0.1271.64 Safari/537.11"
			}
		},
		parse:function(str){
			try{
				return getFromCaileleWeb(str,1);
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
		timer:'sd11x53',

		option:{
			host:"www.cailele.com",
			timeout:30000,
			path: '/lottery/11yun/',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			return getFromCalilecWeb(str,7);
		}
	},
	//}}}
	
	//{{{
	{
		title:'CQ115',
		source:'cailele',
		name:'cq11x5',
		enable:true,
		timer:'cq11x53',

		option:{
			host:"kjh.cailele.com",
			timeout:30000,
			path: '/history_cq11x5.aspx',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				return getFromCaileWeb(str,15);
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
		timer:'gd11x53',

		option:{
			host:"kjh.cailele.com",
			timeout:30000,
			path: '/history_gd115.aspx',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				return getFromCaileWeb(str,6);
			}catch(err){
				throw('广东11选5解析数据不正确');
			}
		}
	},
	//}}}
	
	//{{{
	{
		title:'SH115',
		source:'lecai',
		name:'sh11x5',
		enable:true,
		timer:'sh11x53',

		option:{
			host:"www.lecai.com",
			timeout:30000,
			path: '/lottery/sh11x5/',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			return getFromLecaiaWeb(str,16);
		}
	},
	//}}}
	
	//{{{
	{
		title:'LN115',
		source:'cailele',
		name:'ln11x5',
		enable:true,
		timer:'ln11x53',

		option:{
			host:"www.cailele.com",
			timeout:30000,
			path: '/lottery/ln11x5/',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			return getFromCalilebWeb(str,17);
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
		source:'ssc',
		name:'jxssc',
		enable:false,
		timer:'jxssc',

		option:{
			host:"data.shishicai.cn",
			timeout:30000,
			path: '/jxssc/haoma/',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/27.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				return getFromShishicaiWeb(str,3);
			}catch(err){
				throw('江西时时彩解析数据不正确');
			}
		}
	},
	
	{
		title:'JXC',
		source:'cailele',
		name:'jxssc',
		enable:true,
		timer:'jxssc1',

		option:{
			host:"kjh.cailele.com",
			timeout:30000,
			path: '/history_jxssc.aspx',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/28.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				return getFromCaileleWeb(str,3);
			}catch(err){
				throw('江西时时彩解析数据不正确');
			}
		}
	},
	//}}}
	
	//{{{
	{
		title:'PK10',
		source:'BLC',
		name:'pk10',
		enable:true,
		timer:'pk103',

		option:{
			host:"www.lecai.com",
			timeout:30000,
			path: '/lottery/pk10/',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			return getFromLecaibWeb(str,19);
		}
	},
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
		source:'cailele',
		name:'shssl',
		enable:true,
		timer:'shssl5',

		option:{
			host:"www.cailele.com",
			timeout:30000,
			path: '/static/ssl/newlyopenlist.xml',
			headers:{
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/29.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				//<row expect="2013071923" opencode="2,0,5" opentime="2013-07-19 21:33:30"/>
				var m;
	
				if(m=str.match(reg)){
					return {
						type:11,
						time:m[3],
						number:m[1].replace(/^(\d{8})(\d{2})$/, '$1-$2'),
						data:m[2]
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
			timeout:30000,
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
				preMinu=dat.getMinutes().toString().substr(0,1);  
				date=preYear+'-'+preMonth+'-'+preDate+' '+preHour+':'+preMinu+'0:00';
	
				if(m=str.match(reg)){
					return {
						type:20,
						time:date,
						number:m[1],
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
				"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/24.0.1271.64 Safari/537.11"
			}
		},
		
		parse:function(str){
			try{
				str=str.substr(0,200);
				var reg=/<row expect="(\d+?)" opencode="([\d\,]+?)" opentime="([\d\:\- ]+?)"/; 
				//<row expect="20130718049" opencode="1,6,4,7,1" opentime="2013-07-18 17:17:31"/>
				var m;
	
				if(m=str.match(reg)){
					return {
						type:21,
						time:m[3],
						number:m[1],
						data:m[2]
					};
				}
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
	host:'localhost',
	user:'root',
	password:'jVqDFP2H2JaGZxvS',
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
