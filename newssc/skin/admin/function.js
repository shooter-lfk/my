/* 常用函数 */
//{{{

// 播放声音
function playVoice(src, domId){
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

function defaultCloseModal(){
	$(this).dialog('destroy');
}
function goToDealWithCash(){
	$('.yw_b_2').trigger('click');
	$(this).dialog('destroy');
}

function CopyToClipboard(meintext, cb) {
	if (window.clipboardData) {
		// the IE-manier
		window.clipboardData.setData("Text", meintext);
	} else if (window.netscape) {
		// dit is belangrijk maar staat nergens duidelijk vermeld:
		// you have to sign the code to enable this, or see notes below
		netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
		
		// maak een interface naar het clipboard
		var clip = Components.classes['@mozilla.org/widget/clipboard;1']
			.createInstance(Components.interfaces.nsIClipboard);
		if (!clip) return;
		//alert(clip);
		// maak een transferable
		var trans = Components.classes['@mozilla.org/widget/transferable;1']
			.createInstance(Components.interfaces.nsITransferable);
		if (!trans) return;
		
		// specificeer wat voor soort data we op willen halen; text in dit geval
		trans.addDataFlavor('text/unicode');
		
		// om de data uit de transferable te halen hebben we 2 nieuwe objecten
		// nodig om het in op te slaan
		var str = new Object();
		var len = new Object();
		var str = Components.classes["@mozilla.org/supports-string;1"]
			.createInstance(Components.interfaces.nsISupportsString);
		var copytext = meintext;
		str.data = copytext;
		trans.setTransferData("text/unicode", str, copytext.length * 2);
		var clipid = Components.interfaces.nsIClipboard;
		if (!clip) return false;
		clip.setData(trans, null, clipid.kGlobalClipboard);
	} else {
		return false;
	}
	
	//alert("您已经复制: " + meintext);
	if(typeof cb=='function'){
		return cb(meintext);
	}else{
		return true;
	}
}
function debug(obj, level){
	level=level||9;
	if(level>DEBUG_LEVEL) return false;
	if(typeof DEBUG_CALL=='function'){
		DEBUG_CALL.call(window, obj);
	}
}

function success(message, time){
	return _info('success', message, time);
}

function error(message, time){
	return _info('error', message, time);
}

function warning(message, time){
	return _info('warning', message, time);
}

function info(message, time){
	return _info('info', message, time);
}

var _TIP_ID=0;
function _info(type, message, time){
	var messageId='message-tip-'+_TIP_ID++;
	$('<h4 style="display:none;" class="alert" id="'+messageId+'"></h4>')
	.addClass(type)
	.text(message)
	.prependTo('#message-tip')
	.show('slow');
	time=time||5000;
	
	if(time){
		setTimeout(function(){
			//alert(messageId);
			$('#'+messageId).hide('slow');
		}, time);
	}
	
	$('#message-tip :hidden').remove();
	
	return messageId;
}

function load(url, options){
	
	options=options||{};
	if(typeof url =='string') options.url=url;
	options.url=SCRIPT_NAME+options.url||'';
	options.title=options.title||'';
	
	if(typeof options.beforeLoad=='function'){
		try{
			var call=options.beforeLoad.call(options);
			if(call!==true) return call;
		}catch(e){
			return false;
		}
	}
	
	$.ajax({
		url:options.url,
		success:function(data, textStatus, xhr){
			if(checkStatus(xhr)===false) return false;
			
			//data=$(data);
			//$('input[type=date]', data).datepicker();
			
			$('#main').html(data).find('input[type=date]').datepicker();
		},
		error:function(jqXHR, textStatus, errorThrown){
			error('加载页面出错，请稍候重试或联系管理员。 ', 2000);
		}
	});
	
	return false;
}

function setPosition(){
	var $dom=$('#position'),
	args=[],
	i,len=arguments.length;
	
	for(i=0;i<len;i++) args[i]=arguments[i];
	args=args.map(function(v){
		return '<a>'+v+'</a>';
	}).join('<div class="breadcrumb_divider"></div>');
	//console.log(args);
	$dom.empty().append(args).find('a:last').addClass('current');
}

// 默认分页
function defaultPageAction(page){
	load(this.attr('rel')+'-'+page);
}
function defaultReplacePageAction(page){
	load(this.attr('rel').replace('{page}',page));
}
//}}}

/* 用户函数 */
//{{{
function checkStatus(xhr){//{{{
	var tmp;
	// 提示信息
	$.each(['alert', 'error', 'warning', 'success', 'info'], function(){
		var message=xhr.getResponseHeader('x-'+this+'-message');
		if(message){
			message=decodeURIComponent(message);
			var time=xhr.getResponseHeader('x-'+this+'-message-times')||3000;
			window[this].call(null, message, time);
			if(this=='error') tmp=true;
		}
	});
	
	if(tmp) return false;

	// 查看是否登录
	if(typeof xhr.getResponseHeader('x-not-login') == 'undefined'){
		top.location='/admin.php/user/login';
		return false;
	}
	
	// 检查是否跳转
	if(tmp=xhr.getResponseHeader('location')){
		top.location=tmp;
		return false;
	}
//}}}
}


//}}}

/* 会员操作函数 */
//{{{
function beforeAddMember(){
	if(!this.username.value.match(/[a-zA-z_]\w{4,15}/)) throw('用户名由5到16位字母或数字组成，头一位不能是数字');
	if(!this.password.value) throw('密码不能为空');
	if(this.password.value.length<6 && this.password.value) throw('密码不能少于6位');
	if(this.password.value != $('#cpasswd',this).val()) throw('确认密码不一样');
	//if($(':radio[name=type]:checked',this).attr('value')==1){
		if(!this.fanDian.value.match(/^[\d\.\%]{1,4}$/)) throw('请正确设置返点');
		if(parseFloat(this.fanDian.value)>parseFloat($(this.fanDian).attr('max'))) throw('返点不能大于'+$(this.fanDian).attr('max'));
		if(!this.fanDianBdw.value.match(/^[\d\.\%]{1,4}$/)) throw('请正确设置不定位返点');
		if(parseFloat(this.fanDianBdw.value)>parseFloat($(this.fanDianBdw).attr('max'))) throw('不定位返点不能大于'+$(this.fanDianBdw).attr('max'));
	// }else{
	// }
	var fanDianDiff= $(this.fanDian).attr('fanDianDiff');
	if((this.fanDian.value*1000) % (fanDianDiff*1000)) throw('返点只能是'+fanDianDiff+'%的倍数');
	if((this.fanDianBdw.value*1000) % (fanDianDiff*1000)) throw('不定位返点只能是'+fanDianDiff+'%的倍数');
}

function addMember(err, data){
	if(err){
		error(err);
	}else{
		success(data.message);
		$('#username').val(data.username);
		$('#password').val(this.password.value);
		this.reset();
	}
}


function userDataBeforeSubmitCode(){
	if(this.password.value.length<6&&this.password.value)throw('密码不能少于6位');
	if(this.coinPassword.value.length<6&&this.coinPassword.value) throw('资金密码不能少于6位');
	if(this.password.value||this.coinPassword.value){
		if(this.password.value==this.coinPassword.value) throw('密码和资金密码不能相同');
	}
	if(!this.fanDian.value.match(/^[\d\.\%]{1,4}$/)||!this.fanDianBdw.value.match(/^[\d\.\%]{1,4}$/)) throw('请正确设置返点');
	if(parseFloat(this.fanDian.value)>parseFloat($(this.fanDian).attr('max'))) throw('返点不能大于或等于'+$(this.fanDian).attr('max'));
	if(parseFloat(this.fanDian.value)<parseFloat($(this.fanDian).attr('min'))) throw('返点不能小于'+$(this.fanDian).attr('min'));
	if(parseFloat(this.fanDianBdw.value)>parseFloat($(this.fanDianBdw).attr('max'))) throw('不定位返点不能大于'+$(this.fanDianBdw).attr('max'));
	if(parseFloat(this.fanDianBdw.value)<parseFloat($(this.fanDianBdw).attr('min'))) throw('不定位返点不能小于'+$(this.fanDianBdw).attr('min'));
	var fanDianDiff= $(this.fanDian).attr('fanDianDiff');
	if((this.fanDian.value*1000) % (fanDianDiff*1000)) throw('返点只能是'+fanDianDiff+'%的倍数');
	if((this.fanDianBdw.value*1000) % (fanDianDiff*1000)) throw('不定位返点只能是'+fanDianDiff+'%的倍数');
}

function userDataSubmitCode(err, data){
	if(err){
		alert(err);
	}else{
		success('成功');
		$(this).parent().dialog('destroy');
		reload();
	}
}
function nothin(err, data){
	$(this).parent().dialog('destroy');
	reload();
}

//}}}


/* 开奖数据函数 */
//{{{

/**
 * 开奖列表分页
 */
function dataPageAction(page){
	//var type=this.attr('rel'),
	//url='data/index-'+page+'/'+type;
	//
	//load(url);
	load($(this).attr('rel').replace('{page}', page));
}

/**
 * 提交开奖数据
 */
function dataAddCode(){
	$('form', this).trigger('submit');
}

function dataBeforeSubmitCode(){
	
}

function dataSubmitCode(err, data){
	if(err){
		alert(err);
	}else{
		$(this).parent().dialog('destroy');
		reload();
	}
}

function setKj(){
	alert('已经对未开奖的投注重新开奖');
}

//}}}

//{{{业务流水函数

function reload(){
	$('#main .pageinfo .current').trigger('click');
}

function defaultError(xhr, textStatus, errThrow){
	error(errThrow||textStatus);
	reload();
}

function defaultSuccess(data, textStatus, xhr){
	var errorMessage=xhr.getResponseHeader('X-Error-Message');
	if(errorMessage){
		error(decodeURIComponent(errorMessage));
	}else{
		success(data);
		reload();
	}
}

function defaultAjaxLink(err, data){
	if(err){
		error(err);
	}else{
		reload();
		if(data) success(data);
	}
}

function cashLogDelete(err, data){
	if(err){
		error(err);
	}else{
		success(data);
		reload();
	}
}

// 弹出充值页
function rechargModal(){
	$.get(SCRIPT_NAME + 'business/rechargeModal', function(html){

		$(html).dialog({
			title:'用户充值',
			width:340,
			buttons:{
				"确定充值":function(event, ui){
					var $this=$(this),
					$userRid=$(':radio[name=user]:checked', this),
					$uid=$('input[name=uid]', this),
					$amount=$('input[name=amount]', this),
					//min=parseInt($amount.attr('min')),
					userRid=parseInt($userRid.val()),
					uid=$uid.val(),
					amount=$amount.val();
					
					$(this).dialog("destroy");
					try{
						if(userRid==1){
							if(isNaN(uid)) throw('用户ID不正确，用户ID为用户的数字ID');
							uid=parseInt(uid);
						};
						if(!amount.match(/^-?\d+(\.\d{0,2})?$/)) throw('充值金额错误');
						amount=parseFloat(amount).toFixed(2);
						//if(!isNaN(min) && min>amount) throw('充值金额不能少于'+min);
					}catch(err){
						error(err);
						return;
					}
					
					$.ajax( SCRIPT_NAME + 'business/rechargeAction/' + uid + '/' + amount+ '/' + userRid, {
						dataType:'json',
						error:defaultError,
						success:defaultSuccess
					});
				},
				
				"取消":function(event, ui){
					$(this).dialog("destroy");
				}
			}
		});
		
	});
}

function rechargeSubmitCode(err, data){
	if(err){
		alert(err);
	}else{
		success('成功');
		$(this).parent().dialog('destroy');
		reload();
	}
}
/**
 * 弹出层显示投注号码
 */
function viewBetList(){

	$('<textarea>',{
		cols:56,
		rows:8
	}).append($(this).data('code'))
	.dialog({
		title:'投注号码',
		width:465,
		buttons:{
			"关闭":function(event, ui){
				$(this).dialog("destroy");
			}
		}
	});
}

/**
*确定充值到帐
*/ 
function rechargeBeforeSubmit(){
	if(!this.rechargeAmount.value.match(/^\d+(\.\d+)?$/)) throw('请正确输入金额');
}

/**
 * 普通查询
 */
 function defaultSearch(err, html){
	if(err){
		error(err);
	}else{
		$('#main').html(html).find('input[type=date]').datepicker();
	}
}
function defaultList(err, data){
	if(err){
		alert(err);
	}else{
		$('.tab_content').html(data);
	}
}
/**
 * 普通投注分页
 */
function betLogSearchPageAction(page){
	load($(this).attr('rel').replace('{page}', page));
}

//}}}

/* 管理人员 */
//{{{

function manageAddManagerModal(){
	$.get(SCRIPT_NAME + 'manage/addManagerModal', function(html){

		$(html).dialog({
			title:'添加管理员',
			width:400,
			buttons:{
				"确定添加":function(event,ui){
					var $this=$(this);
					$this.find('form').submit();
					//$this.dialog("destroy");
				},
				"取消":function(event,ui){
					$(this).dialog("destroy");
				}
			}
		});

	});
}

function manageBeforeAddManager(){
	if(!this.username.value.match(/^[a-zA-Z_]\w{4,15}$/)) throw('用户名不正确，用户名由5到16位字母、数字或下画线组成，头位不能是数字');
	if(!this.password.value.match(/^.{6,32}$/)) throw('密码由6到32个字符组成');
	if(this.password.value!=$('.cpwd', this).val()) throw('两次输入密码不一样');
}

function manageAddManager(err, data){
	if(err){
		error(err);
	}else{
		if(data) success(data);
		$(this).closest('.manager-edit').dialog('destroy').remove();
		load('manage/index');
	}
}

function manageDeleteManager(err, data){
	if(err){
		error(err);
	}else{
		if(data) success(data);
		load('manage/index');
	}
}

function manageChangePwdModal(err, html){

	$(html).dialog({
		title:'修改管理员密码',
		width:400,
		buttons:{
			"确定":function(event,ui){
				var $this=$(this);
				$this.find('form').submit();
				//$this.dialog("destroy");
			},
			"取消":function(event,ui){
				$(this).dialog("destroy");
			}
		}
	});

}

function manageBeforeChangePwd(){
	var reg=/^.{6,32}$/;
	if(!this.oldpwd.value.match(reg)) throw('原密码格式不正确');
	if(!this.password.value.match(reg)) throw('密码格式不正确');
	if(this.password.value!=$('.cpwd', this).val()) throw('两次输入密码不一样');
}

function manageChangePwd(err, data){
	if(err){
		error(err);
	}else{
		if(data) success(data);
		$(this).closest('.manager-edit').dialog('destroy').remove();
		load('manage/index');
	}
}

//}}}

/* 系统管理相关函数 */
//{{{

/**
 * 系统设置
 */
function sysSettings(err, data){
	if(err){
		error(err);
	}else{
		success('修改系统设置成功');
	}
}


/**
 * 添加公告
 */
function sysAddNotice(){
	$.get(SCRIPT_NAME + 'system/noticeModal', function(html){

		$(html).dialog({
			title:'添加公告',
			width:500,
			buttons:{
				"发布":function(event,ui){
					var $this=$(this);
					$this.find('form').submit();
					$this.dialog("destroy");
				},
				"取消":function(event,ui){
					$(this).dialog("destroy");
				}
			}
		});

	});
}

function sysReloadNotice(err, data){
	if(err){
		error(err);
	}else{
		success(data);
		load('system/notice');
	}
}

function sysBeforeUpdateNotice(){
	var $this=$(this);
	$this.closest('tr').find(':input[name]').each(function(){
		var $input=$(this);
		if($input.is(':radio, :checkbox') && this.checked==false) return true;
		$this.data($input.attr('name'), this.value);
	});
}

/**
 * 编辑银行
 */
function sysEditBank(id){

	$('<div class="bank-modal"><iframe frameborder="0" src="/admin.php/system/bankModal/'+(id||'')+'" style="width:480px;height:230px;"></iframe></div>')
	.dialog({
		title:'编辑银行',
		width:500,
		buttons:{
			"确定":function(event,ui){
				frames[frames.length-1].document.forms[0].submit();
			},
			"取消":function(event,ui){
				$(this).dialog("destroy");
			}
		}
	});

}

function onUpdateCompile(type, msg){
	var err, data;
	$('.bank-modal').dialog('destroy').remove();
	if(type=='error'){
		err=msg;
	}else{
		data=msg;
	}
	
	sysReloadBank(err, data);
}

function sysReloadBank(err, data){
	if(err){
		error(err);
	}else{
		if(data) success(data);
		load('system/bank');
	}
}

/**
 * 编辑会员银行
 */

function EditBank(id){

	$('<div class="bank-modal"><iframe frameborder="0" src="/admin.php/member/bankModal/'+(id||'')+'" style="width:300px;height:150px;"></iframe></div>')
	.dialog({
		title:'编辑银行',
		width:500,
		buttons:{
			"确定":function(event,ui){
				frames[frames.length-1].document.forms[0].submit();
			},
			"取消":function(event,ui){
				$(this).dialog("destroy");
			}
		}
	});
}
function onUpdateCompile(type, msg){
	var err, data;
	$('.bank-modal').dialog('destroy').remove();
	if(type=='error'){
		err=msg;
	}else{
		data=msg;
	}
	
	ReloadBank(err, data);
}

function ReloadBank(err, data){
	if(err){
		error(err);
	}else{
		if(data) success(data);
		load('member/bank');
	}
}


/**
 * 彩种设置
 */
function sysBeforeUpdateType(){
	var $this=$(this);
	$this.closest('tr').find(':input[name]').each(function(){
		var $input=$(this);
		if($input.is(':radio, :checkbox') && this.checked==false) return true;
		$this.data($input.attr('name'), this.value);
	});
}

function sysUpdateType(err, data){
	if(err){
		error(err);
	}else{
		if(data) success(data);
		load('system/type');
	}
}

/**
 * 玩法
 */
function reloadPlayed(err, data){
	if(err){
		error(err);
	}else{
		if(data) success(data);
		$('#main .tabs .active a').trigger('click');
	}
}

function sysBeforeUpdatePlayed(){
	var $this=$(this);
	$this.closest('tr').find(':input[name]').each(function(){
		var $input=$(this);
		if($input.is(':radio, :checkbox') && this.checked==false) return true;
		$this.data($input.attr('name'), this.value);
	});
}

//}}}

//{{{ 客服中心与积分兑换

/***客服***/
//登录客服
function serviceOpen(err, data){
	var openWindow=window.open("","","height=400, width=550, top=0, left=0,toolbar=no, menubar=no, scrollbars=no, resizable=no, location=n o, status=no");
	openWindow.document.write(data);
	$(this).parent().prev().find('span').addClass('spn4');
}

/*增加客服*/
function serviceAddNew(err,data){
	if(err){
		error(err);
	}else{
		$('#addServiceAdmin').load(' ');
		success("成功添加！");
		$('#main').html(data);
		reload();
	}
}

/*删除客服*/
function serviceDel(err,data){
	if(err){
		error(err);
	}else{
		success("成功删除！");
		$('#main').html(data);
		reload();
	}
}

/*修改保存客服*/
function serviceSave(err,data){
	if(err){
		error(err);
	}else{
		success("修改成功！");
		$('#main').html(data);
		reload();
	}
}
/***客服*end***/

/***兑换商品***/
//添加商品
function scoreEditGoods(id){

	$('<div class="goods-modal"><iframe frameborder="0" src="/admin.php/Score/goodsModal/'+(id||'')+'" style="width:580px;height:470px;"></iframe></div>')
	.dialog({
		title:'编辑商品',
		width:600,
		buttons:{
			"确定":function(event,ui){
				frames[frames.length-1].document.forms[0].submit();
				$('.pageinfo .current').trigger('click');
			},
			"取消":function(event,ui){
				$(this).dialog("destroy");
			}
		}
	});

}

function goodsUpdateCompile(type, msg){
	var err, data;
	$('.goods-modal').dialog('destroy').remove();
	if(type=='error'){
		err=msg;
	}else{
		data=msg;
	}
	
	scoreReloadGoods(err, data);
}

function scoreReloadGoods(err, data){
	if(err){
		error(err);
	}else{
		if(data) success(data);
		load('Score/goodsList');
	}
}

function pointHandle(err, data){
	if(err){
		error(err);
	}else{
		if(data) success(data);
		$('.pageinfo .current').trigger('click');
	}
}

function goodsHandle(err, data){
	if(err){
		error(err);
	}else{
		if(data) success(data);
		$('.pageinfo .current').trigger('click');
	}
}
//goodsList
//}}}

function clearDataBefor(){
	//if($("#clearData").val()) error("日期未填");)
	var date=$("#clearData").val();
	if(!date) throw('日期未填');
	$(this).data('date', date);
}
function clearDataSuccess(err, msg){
	if(err){
		alert(err);
	}else{
		alert("成功清除！");;
	}
}

//m//等级积分设置
function setMemberLevel(err, data){
	if(err){
		error(err);
	}else{
		success('修改成功');
	}
}

//删除
function clearUsersBefor(){
	var coin=$("#clearMemberCoin").val();
	var date=$("#clearMemberDate").val();
	if(!coin) throw('账户资金未填');
	if(!date) throw('天数未填');
	$(this).data('coin_del', coin);
	$(this).data('date_del', date);
}