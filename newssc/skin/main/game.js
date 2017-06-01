$(function(){

	//{{{ 游戏快速操作部分
	// 选号按钮点击事件
	$('input.code').live('click', function(){
		var $this=$(this);
		
		if($this.is('.checked')){
			$this.removeClass('checked');
		}else{
			$this.addClass('checked');
		}
		
		// 重新计算总预投注数和金额
		gameCalcAmount();
	});
	
	// IE下禁止下连接、按钮、单选框和复选框获得焦点
	if($.browser.msie){
		$('a, :button, :radio, :checkbox').live('focus', function(){
			this.blur();
		});
	}
	
	// 操作快速选号按钮点击事件
	$('input.action').live('click', function(){
		var $this=$(this),
		call=$this.attr('action'),
		pp=$this.parent();
		
		if(call && $.isFunction(call=window[call])){
			call.call(this, pp);
		}else if($this.is('.all')){
			// 全－全部选中
			$('input.code',pp).addClass('checked');
		}else if($this.is('.large')){
			// 大－选中5到9
			$('input.code.max',pp).addClass('checked');
			$('input.code.min',pp).removeClass('checked');
		}else if($this.is('.small')){
			// 小－选中0到4
			$('input.code.min',pp).addClass('checked');
			$('input.code.max',pp).removeClass('checked');
		}else if($this.is('.odd')){
			// 单－选中单数
			$('input.code.d',pp).addClass('checked');
			$('input.code.s',pp).removeClass('checked');
		}else if($this.is('.even')){
			// 双－选中双数
			$('input.code.s',pp).addClass('checked');
			$('input.code.d',pp).removeClass('checked');
		}else if($this.is('.none')){
			// 清－全不选
			$('input.code',pp).removeClass('checked');
		}
	});
	
	// 点击查看选号
	$('td.code-list').live('click', function(){
		var data=$(this).parent().data('code');
		displayCodeList(data);
	});
	
	// 选中号码快速操作
	// 在具体的模板中定义，以便响应不同的操作

	// 预投注号码移除
	$('.touzhu-cont .del').live('click', function(){
		$(this).closest('tr').remove();
		$('.touzhu-bottom :checkbox[name=zhuiHao]').removeData()[0].checked=false;
		gameCalcAmount();
	});
	
	$('#btnPostBet').unbind('click');
	$('#btnPostBet').bind('click',gamePostCode);

	// 滑动块
	$('.slider').each(function(){
		var $this=$(this),
		onslide, attr={};
		
		['value', 'min', 'max', 'step'].forEach(function(p){
			if(!isNaN(value=parseFloat($this.attr(p)))){
				attr[p]=value;
			}
		});
		
		//console.log(attr);
		
		if(onslide=$this.attr('slideCallBack')){
			if(typeof window[onslide]=='function'){
				attr.slide=function(event, ui){
					window[onslide].call(this, ui.value);
				}
			}
		}
		
		$this.slider(attr);
	});
	
	// 按增大减少按钮调整返点
	$('.fandian-box input').click(function(){
		var $slider=$('#slider'),
		min=parseFloat($slider.attr('min')),
		max=parseFloat($slider.attr('max')),
		value=$slider.slider('option', 'value');
		
		value+=parseFloat($(this).attr('step'));
		if(value<min) value=min;
		if(value>max) value=max;
		
		$slider.slider('option', 'value', value);
		gameSetFanDian.call($slider[0], value);
	});
	
	//录入式投注录入框键盘事件
	$('#textarea-code').live('keypress', function(event){
		//console.log(event);
		event.keyCode=event.keyCode||event.charCode;
		return !!(
			// 按Ctrl、Alt、Shift时有效
			event.ctrlKey
			|| event.altKey
			|| event.shiftKey
			
			// 回车键有效
			|| event.keyCode==13
			
			// 退格键有效
			|| event.keyCode==8
			
			// 逗号，空格键有效
			|| event.keyCode==32
			|| event.keyCode==186
			
			
			// 数字键有效
			|| (event.keyCode>=48
			&& event.keyCode<=57)
		);

	}).live('keyup', gameMsgAutoTip);
	
	// 点击选号按钮时提示信息
	$('.pp :button, :radio[name=danwei]').live('click', gameMsgAutoTip);
	$('#beishu').live('change', gameMsgAutoTip);
	
	// 追号
	$('.touzhu-bottom :checkbox[name=zhuiHao]')
	.click(function(){
		var bet=$('.touzhu-cont tbody tr'),
		len=bet.length
		if(len==0){
			AlertDialog('请选投注');
			return false;
		}else if(len>1){
			AlertDialog('只能针对一个方案发起追号！');
			return false;
		}
		
		//if(this.checked) 
		setGameZhuiHao(bet.data('code'));
		
		return false;
	});
	
	$('.zhui-hao-modal thead :checkbox').live('change', function(){
		$(this).closest('table').find('tbody :checkbox').prop('checked', this.checked).trigger('change');
	});
	
	$('.zhui-hao-modal tbody :checkbox').live('change', function(){
		var $this=$(this),
		$ui=$this.closest('div[rel]'),
		data=$ui.data(),
		amount=$ui.attr('rel') * $this.closest('tr').find('.beishu').val(),
		$show=$ui.closest('.zhui-hao-modal').find('.ui-dialog-title');
		
		if(!data.count){
			data.count=0;
			data.amount=0;
		}
		
		if(this.checked){
			data.count++;
			data.amount+=amount;
		}else{
			data.count--;
			data.amount-=amount;
		}
		
		$('.qs', $show).text(data.count);
		$('.amount', $show).text(Math.round(data.amount*100)/100);
		$this.closest('tr').find('.amount').text(Math.round(amount*100)/100);
		$this.data('amount', amount);
	});
	
	$('.zhui-hao-modal tbody .beishu').live('change', function(e){
		var $this=$(this);
		if(!$this.closest('tr').find(':checkbox')[0].checked) return ;

		var $ui=$this.closest('div[rel]'),
		data=$ui.data(),
		$checkbox=$this.closest('tr').find(':checkbox'),
		_amount=$checkbox.data('amount');
		amount=$ui.attr('rel') * $this.val(),
		$show=$ui.closest('.zhui-hao-modal').find('.ui-dialog-title');

		data.amount+=amount-_amount;
		$checkbox.data('amount', amount);
		
		$('.qs', $show).text(data.count);
		$('.amount', $show).text(Math.round(data.amount*100)/100);
		$this.closest('tr').find('.amount').text(Math.round(amount*100)/100);
	});
	
	//}}}
	
	// 开奖数据
	
	
	//{{{ 玩游戏页签切换
	// 主页签
	$('.game-btn a[href]').live('click', function(){
		var $this=$(this);
		
		if($this.is('.current')) return false;
		
		$('.game-btn2').load($this.attr('href'), function(){
			//alert($this.closest('.game-btn').find('.current')[0].innerHTML);
			$this.closest('.game-btn').find('.current').removeClass('current img01');
			$this.closest('div').addClass('current img01');
			$('.game-btn2 a[href]:first').trigger('click');
		});
		
		return false;
	});
	
	// 从属页签
	$('.game-btn2 a[href]').live('click', function(){
		var $this=$(this);
		
		//if($this.is('.current')) return false;
		
		$('#num-select').load($this.attr('href'), function(){
			$this.closest('.game-btn2').find('.current').removeClass('current');
			$this.addClass('current');
		});
		
		return false;
	});
	
	// 近期开奖数据
	$('.kjabtn').live('click', function(){
		var $this=$(this);
		//if($this.is('.current')) return ;
		
		$this.closest('.kaijiangall').find('ul').load($this.attr('src'), function(){
			$('.kjabtn.current').removeClass('current img01');
			$this.addClass('current img01');
		});
	});
	
	// 近期大奖与累计
	$('.jiang').live('click', function(){
		//console.log(this);
		var $this=$(this);
		if($this.is('.current')) return true;
		$('.jiang.current').removeClass('current');
		$this.addClass('current');
		return true;
	})
	.find('select').live('change', function(){
		$('.zj-cont tbody').load(this.value);
	});

	// 抢庄玩法
	$('#switch-znz-bet').toggle(function(){
		if($(this).data('status')=='0'){
			AlertDialog('庄内庄功能目前关闭中...');
			return;
		}
		
		$('#znz-game').load('/index.php/index/znz/'+game.type, function(){
			$('#bet-game').hide();
			$(this).show();
		});
	},function(){
		if($(this).data('status')=='0'){
			AlertDialog('庄内庄功能目前关闭中...');
			return;
		}

		$('#bet-game').show();
		$('#znz-game').hide();
	});
	
	$('#znz-code-list .view-code').live('click', function(){
		displayCodeList($(this).closest('tr').data('code'));
	});
	
	$('#znz-code-list .qzbtn').live('click', function(){
		var data=$(this).closest('tr').data('code'),
		amount=data.actionNum * data.mode * data.beiShu,
		chouShi=amount * (data.gameFanDian - data.userFanDian + 3) / 100,
		fandDian=amount * data.setFanDian / 100,
		zjCount=MaxZjCount[data.zjFun].call(data.actionData),
		zjAmount=zjCount * data.bonusProp * data.beiShu * data.mode / 2,
		dongjieCoin=zjAmount+fandDian+chouShi;

		$('<div><p>最大中奖金额：<span class="zj-amount"></span>元</p><p>支付返点：<span class="fan-dian"></span>元</p><p>需要冻结资金共：<span class="dj-amount"></span>元</p></div>')//<p>支付抽水：<span class="shou-shui">元</span></p>
		.find('.zj-amount').text(zjAmount.round(2))
		.end().find('.fan-dian').text((chouShi+fandDian).round(2))
		//.end().find('.shou-shui').text(chouShi.round(2))
		.end().find('.dj-amount').text(dongjieCoin.round(2))
		.end().dialog({
			title:'抢庄',
			modal:true,
			buttons:{
				"确定抢庄":function(){
					
					$.ajax({
						url:'/index.php/game/znzPost/' + data.id,
						type:'POST',
						dataType:'json',
						data:{
							fanDianAmount:fandDian,
							qz_chouShui:chouShi,
							qz_fcoin:zjAmount+fandDian+chouShi
						},
						error:function(xhr, textStatus, errThrow){
							var errorMessage=xhr.getResponseHeader('X-Error-Message');
							if(errorMessage){
								alert(decodeURIComponent(errorMessage));
							}else{
								alert(textStatus || errThrow);
							}
						},
						success:function(data, textStatus, xhr){
							var errorMessage=xhr.getResponseHeader('X-Error-Message');
							if(errorMessage){
								alert(decodeURIComponent(errorMessage));
							}else{
								$('#znz-game').load('/index.php/index/znz/'+game.type);
								alert(data);
								reloadMemberInfo();
							}
						}
					});
					
					$(this).dialog("destroy");
				},
				"取消":function(){
					$(this).dialog("destroy");
				}
			}
		});
	});

	//}}}
	
	$('.dantuo :radio').live('click', function(){
		var $dom=$(this).closest('.dantuo');
		
		if(this.value){
			$dom.next().hide().next().show();
		}else{
			$dom.next().show().next().hide();
		}
	});
	
	
	$('.dmtm :input.code').live('click',function(event){
		var $this=$(this),
		$dom=$this.closest('.dmtm');
		if($('.code.checked[value=' + this.value +']', $dom).not(this).length==1){
			$this.removeClass('checked');
			AlertDialog('选择胆码不能与拖码相同');
			return false;
		}
	});
	
	$('.zhixu115 :input.code').live('click',function(event){
		var $this=$(this);
		if(!$this.is('.checked')) return false;
		
		var $dom=$this.closest('.zhixu115');
		$('.code.checked[value=' + this.value +']', $dom).removeClass('checked');
		$this.addClass('checked');
	});
	
	// 声音状态
	if(getVoiceStatus()=='off'){
		$('#voice').removeClass('voice-on').addClass('voice-off');
	}
});

var MaxZjCount={
	// 普通单式，直接对比
	ds:function(){
		var zjCount=0,t=1,s;
		$.each(this.split('|').sort(), function(){
			if(s==String(this)){
				t++;
			}else{
				s=this;
				if(t>zjCount) zjCount=t;
				t=1;
			}
		});
		if(t>zjCount) zjCount=t;
		
		return zjCount;
	},
	
	// 普通复式
	fs:function(){
		return 1;
	},
	
	// 大小单双
	dxds:function(){
		var d=this.split(',').map(function(v){
			return v
			.replace('单','双')
			.replace('大', '小')
			.split("").sort().join('')
			.replace(/双{2,}/,'双')
			.replace(/小{2,}/,'小')
			.length;
		});
		
		//console.log(d);
		
		return d[0] * d[1];
	},
	
	// 五星定位胆
	dd5x:function(){
		return this.split(',').filter(function(v){return v!='-'}).length;
	},
	
	// 不定胆
	bdd:function(){
		return this.length>3?3:this.length;
	}
}

//{{{ 聊天室
function closeFace(){
	if($(".faceBox").is(':visible')){
		$(".faceBox").hide(200);
	}else{
		$(".faceBox").show(100);
	}
}

function inputFace(txt){
	closeFace();
	grin(document.getElementById("talk-in"),txt);
}

/**
 * 发送聊天信息
 */
function chatBeforSubmit(){
	var self=this;
	if($('#talk-in').data('status')=='1'){
		// 发言时间限制
		var time;
		if(time=$.cookie('lastChatTime')){
			time=parseInt(time);
			var date=new Date(),
			time=Math.ceil((new Date()-time)/1000);
			limitTime=parseInt($('#talk-in').data('frequency'));//秒
			if(time<limitTime){
				appendTalk({
					user:'系统',
					time:new Date(),
					chat:'您发言太频繁，还差'+(limitTime-time)+'秒才能再次发言!'
				});
				return false;
			}
		}
		
		$.ajax({
			url:'http://'+location.host+':8080/say',
			dataType:'jsonp',
			jsonp:'jsonpcallback',
			data:{
				user:window.user,
				chat:this.chat.value,
				time:$(this).data('time')
			},
			success:function(data){
				self.chat.value='';
				//console.log(data);
				if(data && data.error){
					appendTalk({user:'系统',time:(new Date()).getTime(), chat:data.error});
				}else{
					$.cookie('lastChatTime',(new Date()).getTime());
				}
			},
			error:function(xhr,textStatus, errorThrow){
				//console.log(textStatus);
			}
		});
	}else{
		alert($('.talkBoxCss3').text());
	}
	return false
}
function appendTalks(data){
	if(!$.isArray(data) || data.length==0) return;
	var $chat=$('#chat-content');
	data.forEach(appendTalk);
}

function appendTalk(chat){
	var s='';
	var $chat=$('#chat-content');
	if(aflag && chat.user!='系统'){
		s=' <a href="javascript:;" onclick="chatGag(\''+chat.user+'\')" title="禁言"><img src="/skin/main/images/jy.gif" width="12" height="12"/></a>'
	}
	
	var date=new Date(chat.time);
	$chat.append("<span class='talkBoxCss1'>["+date.getHours()+':'+ date.getMinutes()+':'+ date.getSeconds()+"] <span class='talkBoxCss2'>"+chat.user.replace(/^(\w)\w*(\w{3})$/, "$1***$2")+s+"</span><span class='talkBoxCss3'>"+chat.chat+"</span>");
	$chat[0].scrollTop=99999;
}

function chatGag(user){
	//console.log(user);
	$.ajax({
		url:'http://'+location.host+':8080/setGad',
		dataType:'jsonp',
		jsonp:'jsonpcallback',
		data:{user:user},
		success:function(data){
			//console.log(data);
		},
		error:function(xhr,textStatus, errorThrow){
			//console.log(textStatus);
		}
	});
}

function wsCall(){
	var ws=new WebSocket('ws://'+location.host+':8080/');
	ws.onmessage=function(msg){
		appendTalk($.parseJSON(msg.data));
	}
	
	ws.onclose=function(){
		wsCall();
	}
}

$(function(){
	if($('#talk-in').data('status')=='1'){
		if(typeof WebSocket!='undefined'){
			wsCall();
		}else{
			getTalk({user:window.user});
		}
		
		$('#talk-in').keypress(function(event){
			if(event.charCode==13||event.keyCode==13){
				$(this.form).trigger('submit');
				return false;
			}
		});
		
		$('#faceBox').on('click', 'img', function(){
			grin($('#talk-in')[0], '/:'+$(this).attr('rel'));
			closeFace();
		});
	}
});

function getTalk(data){
	if($('#talk-in').data('status')=='1'){
		$.ajax({
			url:'http://'+location.host+':8080/get',
			dataType:'jsonp',
			jsonp:'jsonpcallback',
			data:data,
			success:function(data){
			
				if(!data) return;
				if(data.error){
					//apendTalk(data);
				}else{
					appendTalks(data.chats);
				}
			
				if(window.chatTimer) clearInterval(window.chatTimer);
				window.chatTimer=setInterval(function(){
					getTalk({user:window.user, time:data.time});
				}, 1000);
			},
			error:function(xhr,textStatus, errorThrow){
				//console.log(textStatus);
			}
		});
	}
}

function sendTalk(dom){
	if($(!'#talk-in').val()) throw('发言不能为空！');
	$(dom).closest('form').trigger('submit');
}


//myField 光标所在的控件名 document.Form.XXX 
//tag 所要插入的值 
function grin(myField,tag) { 
        //var myField; 
        //myField = document.getElementById('content'); 
        if (document.selection) { 
                myField.focus(); 
                sel = document.selection.createRange(); 
                sel.text = tag; 
                myField.focus(); 
        } 
        else if (myField.selectionStart || myField.selectionStart == '0') { 
                var startPos = myField.selectionStart; 
                var endPos = myField.selectionEnd; 
                var cursorPos = endPos; 
                myField.value = myField.value.substring(0, startPos) 
                                          + tag 
                                          + myField.value.substring(endPos, myField.value.length); 
                cursorPos += tag.length; 
                myField.focus(); 
                myField.selectionStart = cursorPos; 
                myField.selectionEnd = cursorPos; 
        } 
        else { 
                myField.value += tag; 
                myField.focus(); 
        } 
} 

//}}}

//{{{ 播放声音
function playVoice(src, domId){
	if(getVoiceStatus()=='off') return;
	var $dom=$('#'+domId)
	if($.browser.msie){
		// IE用bgsound标签处理声音
		
		if($dom.length){
			$dom[0].src=src;
		}else{
			$('<bgsound>',{src:src, id:domId}).appendTo('body');
		}
	}else{
		// IE以外的其它浏览器用HTML5处理声音
		if($dom.length){
			$dom[0].play();
		}else{
			$('<audio>',{src:src, id:domId}).appendTo('body')[0].play();
		}
	}
}

function setVoiceStatus(flag){
	var session=(typeof sessionStorage!='undefined');
	var key='voiceStatus';
	if(session){
		if(!flag){
			sessionStorage.setItem(key,'off');
		}else{
			sessionStorage.removeItem(key);
		}
	}else{
		if(!flag){
			$.cookie(key, 'off');
		}else{
			$.cookie(key, null);
		}
	}
}

function getVoiceStatus(){
	var key='voiceStatus';
	if(typeof sessionStorage!='undefined'){
		return sessionStorage.getItem(key);
	}else{
		return $.cookie(key);
	}
}

function voiceKJ(){
	var $dom=$('#voice');
	if(getVoiceStatus()!='off'){
		setVoiceStatus(false);
		$dom.attr('class','voice-off');
	}else{
		setVoiceStatus(true);
		$dom.attr('class','voice-on');
	}
}
//}}}

function sxznz(){
	$('#znz-game').load('/index.php/index/znz/'+game.type, function(){
		$('#bet-game').hide();
		$(this).show();
	});
}
