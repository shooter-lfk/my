$(function(){

	//{{{ HTML标签扩展部分
	// A链接扩展
	/**
	 * AJAX链接
	 * target="ajax"：AJAX请求
	 * onajax：AJAX调用前触发，返回false时阻止
	 * call：AJAX完后触发，callback(err, data, xhr) this指向当前html元素，err当出错的时间有值，data为服务器返回值(解析过)，xhr为HttpRequest对象
	 * dataType：默认html，服务器响应类型，可用json，xml
	 */
	$('a[target=ajax]').live('click', function(){
		var $this	= $(this),
		self		= this,
		onajax		= window[$this.attr('onajax')],
		title		= $this.attr('title'),
		call		= window[$this.attr('call')];
		
		if(title && !confirm(title)) return false;
		
		if(typeof call!='function'){
			// 设置一个默认的响应回调
			call=function(){}
		}
		
		if('function'==typeof onajax){
			// 如果ajax请求前事件处理返回false
			// 则阻止后继事件
			try{
				if(onajax.call(this)===false) return false;
			}catch(err){
				call.call(self, err);
				return false;
			}
		}

		$.ajax({
			url:$this.attr('href'),
			
			// 异步请求
			async:true,
			
			// 把当前存储的数据做为参数传递
			data:$this.data(),
			
			// 默认用GET请求，也可以用method属性设置
			type:$this.attr('method')||'get',
			
			// dataType属性用于设置响应数据格式，默认html，可选json和xml
			dataType:$this.attr('dataType')||'html',
			
			error:function(xhr, textStatus, errThrow){
				// 据jQuery官方说，textStatus和errThrow中只有一个包括错误信息
				call.call(self, errThrow||textStatus);
			},
			
			success:function(data, textStatus, xhr, headers){
				var errorMessage=xhr.getResponseHeader('X-Error-Message');
				if(errorMessage){
					call.call(self, decodeURIComponent(errorMessage), data);
				}else{
					call.call(self, null, data);
				}
			}
		});
		
		return false;
	});
	
	// A弹出层打开链接
	/**
	 * target="modal"
	 * title="弹出层标题"
	 * width="弹出宽度"
	 * heigth=""
	 * modal=false
	 * buttons="确定:onsure|取消:oncancel"
	 * method="get"
	 */
	$('a[target=modal]').live('click', function(){
		var self=this,
		$self=$(self),
		title=$self.attr('title')||'',
		width=$self.attr('width')||'auto',
		heigth=$self.attr('heigth')||'auto',
		modal=($self.attr('modal')),
		method=$self.attr('method')||'get',
		buttons=$self.attr('button')||null;

		if(buttons) buttons=buttons.split('|').map(function(b){
			b=b.split(':');
			return {text:b[0], click:window[b[1]]};
		});
		
		$[method]($self.attr('href'), function(html){
			$(html).dialog({
				title:title,
				width:width,
				height:heigth,
				modal:modal,
				buttons:buttons
			});
		});
		
		return false;
	});
	
	// form扩展
	/**
	 * 简单AJAX表单
	 * target="ajax"：AJAX提交
	 * onajax：AJAX调用前触发，this指向from元素，返回false时阻止
	 * call：AJAX完后触发，callback(err, data, xhr) this指向当前html元素，err当出错的时间有值，data为服务器返回值(解析过)，xhr为HttpRequest对象
	 * 服务器响应类型为json
	 */
	$('form[target=ajax]').live('submit', function(){
		var data	= [], 
		$this		= $(this),
		self		= this,
		onajax		= window[$this.attr('onajax')],
		call		= window[$this.attr('call')];
		
		if(typeof call!='function'){
			// 设置一个默认的响应回调
			call=function(){}
		}
		
		if('function'==typeof onajax){
			// 如果ajax请求前事件处理返回false
			// 则阻止后继事件
			try{
				if(onajax.call(this)===false) return false;
			}catch(err){
				call.call(self, err);
				return false;
			}
		}

		$(':input[name]', this).each(function(){
			var $this=$(this),
			value=$this.data('value'),
			name=$this.attr('name');
			
			if($this.is(':radio, :checkbox') && this.checked==false) return true;
			
			if(value===undefined) value=this.value;
			
			data.push({name:name, value:value});
		});
		
		$.ajax({
			url:$this.attr('action'),
			
			// 异步请求
			async:true,

			data:data,
			
			// 默认用GET请求，也可以用method属性设置
			type:$this.attr('method')||'get',
			
			// dataType属性用于设置响应数据格式，默认json，可选html、json和xml
			dataType:$this.attr('dataType')||'json',
			
			headers:{"x-form-call":1},
			
			error:function(xhr, textStatus, errThrow){
				// 据jQuery官方说，textStatus和errThrow中只有一个包括错误信息
				call.call(self, errThrow||textStatus);
			},
			
			success:function(data, textStatus, xhr, headers){
				var errorMessage=xhr.getResponseHeader('X-Error-Message');
				if(errorMessage){
					call.call(self, decodeURIComponent(errorMessage), data);
				}else{
					call.call(self, null, data);
				}
			}
		});
		
		return false;
	});
	
	if($.datepicker) $('input[type=date]').datepicker({
		showOn: "button",
		buttonText:'快速选取日期',
		buttonImage: "/skin/main/images/date.gif",
		buttonImageOnly: true
	});
	
	$('#adv-top div').live('click', function(){
		var $this=$(this), $parent=$this.parent();
		if($this.is('.r-adv') && $parent.is('.right-top-a')) return ;
		if($this.is('.r-news') && $parent.is('.right-top-b')) return ;
	});
	
	// 登录按Enter进入
	if(!$.browser.opera && !$.browser.mozilla){
		$('input[name=vcode]').live('keypress', function(event){
			if(event.keyCode==13){
				$(this.form).trigger('submit');
			}
		});
	}
	
	// 弹出层分页
	$('.ui-dialog .bottompage a').live('click', function(){
		var $this=$(this);
		$this.closest('.ui-dialog-content').load($this.attr('href'));
		return false;
	});
	
	$('#adv-top a').live('click', function(){
		var $this=$(this),
		$dom=$this.closest('.adv');
		
		if($this.is('.r-adv')){
			// 点公告
			if($('.c-adv', $dom).is(':visible')) return false;
			$('#adv-top').removeClass('right-top-b').addClass('right-top-a');
			$('.c-adv', $dom).show();
			$('.c-news', $dom).hide();
		}else{
			// 点消息
			if($('.c-news', $dom).is(':visible')) return false;
			$('#adv-top').removeClass('right-top-a').addClass('right-top-b');
			$('.c-news', $dom).show();
			$('.c-adv', $dom).hide();
			loadUserBulletin();
		}
	});
	
	// 禁止右键
	$(document).bind('contextmenu', function(){
		return false;
	});

	//}}}
});

Number.prototype.round=Number.prototype.toFixed;
