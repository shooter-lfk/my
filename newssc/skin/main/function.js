//{{{ 通用复制函数
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
	
	AlertDialog("您已经复制: " + meintext);
	if(typeof cb=='function'){
		return cb(meintext);
	}else{
		return true;
	}
}
//}}}

function showBetInfo(id){
	$.get('/index.php/record/betInfo/'+id, function(data){
		$(data).dialog({
			title:'投注信息',
			width:500,
			buttons:{
				"关闭":function(){
					$(this).dialog("destroy");
				}
			}
		});
	});
}

function wait(){
	$('<img src="/skin/main/images/wait.gif" />').modal({
		modal:true,
		escClose:false,
		overlayCss:{
			background:'#000'
		},
		dataCss:{
			padding:'0px',
			margin:'0px'
		}
	});
}

function destroyWait(){
	$.modal.close();
}

function defaultModalCloase(event, ui){
	$(this).dialog('destroy');
}

//{{{ 开奖相关函数
var T,S;
function gameKanJiangDataC(diffTime, actionNo){

	if(diffTime<=0){
		//console.log(diffTime);
		// 进入开奖冻结时间
		if(S){
			// 时间到进入开奖冻结时间
			diffTime=kjTime;
		}else if(S===null){
			// 开奖时间
			$('#kaijiang .sytime').html('正在销售');
			$('#kaijiang .time').html('<font>↑正在开奖中</font>');
					$('.kjfousin .activity').html('');
			$('#btnPostBet').unbind('click');
			$('#btnPostBet').bind('click',gamePostCode);
			getQiHao(setKjing);
			loadKjData();
			return;
		}else{
			// 打开就进入开奖冻结时间
			diffTime+=kjTime;
		}
		$('#kaijiang .sytime').html('已封单，开奖剩余');
		$('.kjfousin .activity').html('<div class="cxtx"></div>');
		$('#btnPostBet').unbind('click');
		$('#btnPostBet').bind('click', function(){
			AlertDialog('本期已截至投注');
		});
		
		S=null;
		if(T) clearTimeout(T);
		//T=setTimeout(gameKanJiangDataC, 1, diffTime);
		
		if($.browser.msie){
			T=setTimeout(function(){
				gameKanJiangDataC(diffTime);
			}, 1);
		}else{
			T=setTimeout(gameKanJiangDataC, 1, diffTime);
		}		
		return;
	}
	
	var $dom=$('#pre-kanjiang'),
	
	m=Math.floor(diffTime % 60),
	s=(diffTime---m)/60;
	
	if(actionNo) $dom.prev().find('span').html(actionNo);

	if(s<10){
		s="0"+s;
	}
	
	if(m<10){
		m="0"+m;
	}

	if(s>60){
		h=Math.floor(s/60);
		s=s-h*60;
		$dom.text(h+":"+s+":"+m);
	}else{
		$dom.text(s+":"+m);
	}

	//console.log('m:%s, s:%s', m, s);
	if(S && m==3 && s==0){
		playVoice('/skin/sound/stop-time.wav', 'stop-time-voice');
	}
	
	if(m==0 && s==0){
		//$('#kaijiang').load($dom.attr('action'));
		loadKjData();
	}else{
		//T=setTimeout(gameKanJiangDataC, 1000, diffTime);
		if($.browser.msie){
			T=setTimeout(function(){
				gameKanJiangDataC(diffTime);
			}, 1000);
		}else{
			T=setTimeout(gameKanJiangDataC, 1000, diffTime);
		}
	}
}

function getQiHao(callback){
	$.getJSON('/index.php/index/getQiHao/'+game.type, function(data){
		if(data && data.lastNo && data.thisNo){
			$('.kj-title span').html(data.lastNo.actionNo);
			$('.kj-bottom span').html(data.thisNo.actionNo);
			//callback(data);
			setKjing();
			//alert(8);
		}
	});
}

function setKjing(){
	var hao,$dom=$('.kj-hao li:first');
	//console.log($dom.text()=='');
	//if($dom.text()==''){
		hao=$('li',$dom.parent()).length==5?'正在开奖中':'开奖中';
		hao=hao.split('');
		
		$('.kj-hao li').each(function(i){
			$(this).html(('<div id="num_'+i+'" class="no" ></div>')||'');
			//setTimeout("setKjing("+i+",'"+hao[i]+"')",times);
		});
	// }
}

function showorhide(i,css)
{
	if($("#left_"+i).is(":hidden")){
		$("#left_"+i+"_"+i).attr("class",css);
		$("#left_"+i).show();
	}
	else
	{
		$("#left_"+i+"_"+i).attr("class",css+"1");
		$("#left_"+i).hide();
	}
}


function loadKjData(){
	$.ajax('/index.php/index/getLastKjData/'+$('#kaijiang').attr('type'),{
		dataType:'json',
		cache:false,
		error:function(){
			setTimeout(loadKjData, 5000);
		},
		success:function(data, textStatus, xhr){
			//console.log(data);
			if(!data){
				setKjing();
				setTimeout(loadKjData, 5000);
			}else{
				try{
					
					var times=3000;
					var $dom=$('#kaijiang'),
					hao=data.data.split(',');
					$('.kj-title span').html(data.actionNo);

					$('.kj-hao li').each(function(i){
						times-=500;
						if(game.type==18||game.type==19){
							setTimeout("setKjing1("+i+",'<img src=/skin/main/images/number/c"+hao[i]+".gif />')",times);
						}else{
							setTimeout("setKjing1("+i+",'<img src=/skin/main/images/number/"+hao[i]+".gif />')",times);
						}
					});
					
					$('.kja-title div:first').trigger('click');
					$('.jiang.current select').trigger('change');
					//reloadMemberInfo();
					gameFreshOrdered();
					
					if($('#adv-top .c-news').is(':visible')) loadUserBulletin()
					
					if(T) clearTimeout(T);
					gameKanJiangDataC(data.diffTime-kjTime, data.thisNo);
					$('#kaijiang .sytime').html('投注剩余时间');
					$('.kjfousin .activity').html('');
					$('#btnPostBet').unbind('click');
					$('#btnPostBet').bind('click',gamePostCode);
					playVoice('/skin/sound/kai-jiang.wav', 'kai-jian-voice')
					S=true;
					showresult();
				}catch(err){
					//fconsole.log(err);
					setTimeout(loadKjData, 5000);
				}
			}
		}
	});
}

function showresult()
{
	$.ajax('/index.php/index/getLastKjData1/'+$('#kaijiang').attr('type'),{
		dataType:'json',
		cache:false,
		success:function(data){
			if(data)
			{
				$("#qishu").html(data.actionNo);
				$("#tzs").html(data.data/2-1);
				if(data.data1-1==0)$("#ykje").html(-data.data+2);
				else
					$("#ykje").html(data.data1-1);//alert(data.data+","+data.data1+","+);
					 $("#message").Show();
					 setTimeout('$("#message").slideUp(1000);',5000);
			}
			else
			 {
				 $.getJSON('/index.php/index/getQiHao/'+$('#kaijiang').attr('type'), function(data){
					if(data && data.lastNo && data.thisNo){
						$("#qishu").html(data.lastNo.actionNo);
						$("#tzs").html("0");
						$("#ykje").html("0");	 
					}
				 });
				$("#message").Show();
				setTimeout('$("#message").slideUp(1000);',5000);
			 }
			 
		}
	});
}


function setKjing1(i,hao)
{
	$("#num_"+i).removeClass("no");
	$("#num_"+i).html(hao);
}

// 加载用户消息
function loadUserBulletin(){
	$('#adv-top').parent().find('.c-news div').load('/index.php/user/bulletin');
}

//}}}

//{{{ 安全中心相关函数

/**
 * 修改密码前调用
 */
function safeBeforSetPwd(){
	//console.log(this);
	
	if(!this.oldpassword.value){
		AlertDialog('请输入原密码');
		return false;
	}
	
	if(this.oldpassword.value.length<6){
		AlertDialog('原密码至少6位');
		return false;
	}
	
	if(!this.newpassword.value){
		AlertDialog('请输入新密码');
		return false;
	}
	
	if(this.newpassword.value.length<6){
		AlertDialog('密码至少6位');
		return false;
	}
	
	var confirmpwd=$(':password.confirm', this).val();
	if(confirmpwd!=this.newpassword.value){
		AlertDialog('两次输入密码不一样');
		return false;
	}
	
	return true;
}

/**
 * 修改资金密码前调用
 */
function safeBeforSetCoinPwd(){
	if(!this.newpassword.value){
		AlertDialog('请输入新密码');
		return false;
	}
	
	if(this.newpassword.value.length<6){
		AlertDialog('密码至少6位');
		return false;
	}
	
	var confirmpwd=$(':password.confirm', this).val();
	if(confirmpwd!=this.newpassword.value){
		AlertDialog('两次输入密码不一样');
		return false;
	}
	
	return true;
}

/**
 * 修改密码和资金密码调用
 */
function safeSetPwd(err, data){
	if(err){
		AlertDialog(err);
	}else{
		this.reset();
		AlertDialogyes(data);
	}
}

/**
 * 修改银行信息前调用
 */
function safeBeforSetCBA(){
	//if(!this.cb_type.value) throw('银行类型没有填写');
	if(!this.account.value) throw('银行帐号没有填写');
	if(!this.username.value) throw('银行开户名没有填写');
	//if(!this.safeEmail.value) throw('密保邮箱没有填写');
	//if(!/^\w+\@(\w+\.)?\w{2,4}$/.test(this.safeEmail.value)) throw('密保邮箱格式不正确');
	if(!this.coinPassword.value) throw('请输入资金密码');
}

/**
 * 修改银行信息调用
 */
function safeSetCBA(err, data){
	if(err){
		AlertDialog(err);
	}else{
		AlertDialogyes(data);
		location.reload();
	}
}

//}}}

//{{{ 团队管理相关函数

function teamCopyTip(text){
	if(text) AlertDialogyes('复制成功');
}

/**
 * 新增会员前调用
 */
function teamBeforeAddMember(){
	var type=$('[name=type]:checked',this).val();
	//console.log($('[name=type]:checked',this));
	if(!this.username.value) throw('请输入用户名');
	if(!/^\w{4,16}$/.test(this.username.value)) throw('用户名由4到16位的字母、数字及下划线组成');
	if(!this.password.value) throw('请输入密码');
	if(this.password.value.length<6) throw('密码至少6位');
	if(document.getElementById('cpasswd').value!=this.password.value) throw('两次输入密码不一样');
	if(!this.qq.value) throw('请如实记录会员联系QQ');
	//if(!this.subCount.value) throw('请输入人数配额');
	//if(!/^\d+$/.test(this.subCount.value)) throw('人数配额只能填写正整数');
	if(!this.fanDian.value) throw('请输入返点');
	if(parseFloat(this.fanDian.value)<0) throw('返点不能小于0%');
	var minFanDianUserCount= parseFloat($(this.fanDian).attr('minFanDianUserCount'));	
	if(parseFloat(this.fanDian.value)<minFanDianUserCount) throw('不能低于最低限制人数返点'+minFanDianUserCount+'%');
	if(parseFloat(this.fanDian.value)>=parseFloat($(this.fanDian).attr('max'))) throw('返点不能大于或等于'+$(this.fanDian).attr('max'));
	if(!this.fanDianBdw.value) throw('请输入不定位返点');
	if(parseFloat(this.fanDianBdw.value)>parseFloat($(this.fanDianBdw).attr('max'))) throw('不定位返点不能大于'+$(this.fanDianBdw).attr('max'));
	var fanDianDiff= $(this.fanDian).attr('fanDianDiff');	
	//if((this.iskai.value==0) && (this.fanDian.value*1000) % (fanDianDiff*1000)) throw('返点只能是'+fanDianDiff+'%的倍数');	
	//if((this.iskai.value==0) && (this.fanDianBdw.value*1000) % (fanDianDiff*1000)) throw('不定位返点只能是'+fanDianDiff+'%的倍数');
	
}

/**
 * 新增会员调用
 */
function teamAddMember(err, data){
	if(err){
		AlertDialog(err);
	}else{
		$('#username').val(this.username.value);
		$('#password').val(this.password.value);
		//this.reset();
		AlertDialogyes(data);
		//location.reload();
	}
}
/**
 * 编辑会员前调用
 */
function teamBeforeUserMember(){
	if(!this.qq.value) throw('请如实记录会员联系QQ');
	if(!this.fanDian.value.match(/^[\d\.\%]{1,4}$/)||!this.fanDianBdw.value.match(/^[\d\.\%]{1,4}$/)) throw('请正确设置返点');
	if(!this.fanDian.value) throw('请输入返点');
	if(parseFloat(this.fanDian.value)<0) throw('返点不能小于0%');
	if(parseFloat(this.fanDian.value)>=parseFloat($(this.fanDian).attr('max'))) throw('返点不能大于或等于'+$(this.fanDian).attr('max'));
	if(parseFloat(this.fanDian.value)<parseFloat($(this.fanDian).attr('min'))) throw('返点不能小于'+$(this.fanDian).attr('min'));
	if(!this.fanDianBdw.value) throw('请输入不定位返点');
	if(parseFloat(this.fanDianBdw.value)>parseFloat($(this.fanDianBdw).attr('max'))) throw('不定位返点不能大于'+$(this.fanDianBdw).attr('max'));
	if(parseFloat(this.fanDianBdw.value)<parseFloat($(this.fanDianBdw).attr('min'))) throw('不定位返点不能小于'+$(this.fanDianBdw).attr('min'));
	var fanDianDiff= $(this.fanDian).attr('fanDianDiff');
	if((this.fanDian.value*1000) % (fanDianDiff*1000)) throw('返点只能是'+fanDianDiff+'%的倍数');
	if((this.fanDianBdw.value*1000) % (fanDianDiff*1000)) throw('不定位返点只能是'+fanDianDiff+'%的倍数');
}

/**
 * 编辑会员调用
 */
function teamUserMember(err, data){
	if(err){
		AlertDialog(err);
	}else{
		AlertDialogyes(data);
	}
}

//清除空格
function ignoreSpaces(string) {
	var temp = "";
	string = '' + string;
	splitstring = string.split(" ");
	for(i = 0; i < splitstring.length; i++)
	temp += splitstring[i];
	return temp;
}

//}}}

//{{{ 登录相关
function userBeforLogin(){
	
}

function userLogin(err, data){
	if(err){
		AlertDialog(err);
		$('input[name=vcode]')
		.val('')
		.closest('div')
		.find('.yzmNum img')
		.click();
		
	}else{
		location='/';
	}
}

//}}}

//{{{推广注册
function registerBeforSubmit(){
	var type=$('[name=type]:checked',this).val();
	//console.log($('[name=type]:checked',this));
	if(!this.username.value) throw('请输入用户名');
	if(!/^\w{4,16}$/.test(this.username.value)) throw('用户名由4到16位的字母、数字及下划线组成');
	if(!this.password.value) throw('请输入密码');
	if(this.password.value.length<6) throw('密码至少6位');
	if(document.getElementById('cpasswd').value!=this.password.value) throw('两次输入密码不一样');
	if(!this.qq.value) throw('请输入联系QQ');
	//if(!this.safeEmail.value) throw('密保邮箱没有填写');
	//if(!/^\w+\@(\w+\.)?\w{2,4}$/.test(this.safeEmail.value)) throw('密保邮箱格式不正确');
}
function registerSubmit(err,data){
	if(err){
		AlertDialog(err);
	}else{
		location='/';
	}
}
//{{{修改返点
function teamBeforemodifyfandian(){
	
	if(!this.fanDian.value) throw('请输入返点');
	if(parseFloat(this.fanDian.value)<0) throw('返点不能小于0%');
	if(parseFloat(this.fanDian.value)>=parseFloat($(this.fanDian).attr('max'))) throw('返点不能大于或等于'+$(this.fanDian).attr('max'));
	if(!this.fanDianBdw.value) throw('请输入不定位返点');
	if(parseFloat(this.fanDianBdw.value)>parseFloat($(this.fanDianBdw).attr('max'))) throw('不定位返点不能大于'+$(this.fanDianBdw).attr('max'));
		
	var fanDianDiff= $(this.fanDian).attr('fanDianDiff');
	

	if((this.iskai.value==0) && (this.fanDian.value*1000) % (fanDianDiff*1000)) throw('返点只能是'+fanDianDiff+'%的倍数');	
	if((this.iskai.value==0) && (this.fanDianBdw.value*1000) % (fanDianDiff*1000)) throw('不定位返点只能是'+fanDianDiff+'的倍数');

}


function teammodifyfandian(err,data){
	if(err){
		AlertDialog(err);
	}else{
		AlertDialogyes(data);
		location.reload();
	}
	
}

//{{{设置返点
function sheagentBefore(){
	
	if(!this.uid.value) throw('会员ID无效');
	
}


function sheagent(err,data){
	if(err){
		AlertDialog(err);
	}else{
		alert(data);
		success(data);
		load('member/member-list.php');
	}
	
}

//}}}	
	
//{{{ 游戏相关函数
/**
 * 快速选择唯一选择
 */
function uniqueSelect(parent){
	var $this=$(this),$unique=parent.closest('.unique'),
	fun=function(i,c){
		return $('input.code.checked[value='+this.value+']').length?'':'checked';
	};
	
	
	if($this.is('.all')){
		// 全－全部选中
		$('input.code',parent).addClass(fun);
	}else if($this.is('.large')){
		// 大－选中5到9
		$('input.code.max',parent).addClass(fun);
		$('input.code.min',parent).removeClass('checked');
	}else if($this.is('.small')){
		// 小－选中0到4
		$('input.code.min',parent).addClass(fun);
		$('input.code.max',parent).removeClass('checked');
	}else if($this.is('.odd')){
		// 单－选中单数
		$('input.code.d',parent).addClass(fun);
		$('input.code.s',parent).removeClass('checked');
	}else if($this.is('.even')){
		// 双－选中双数
		$('input.code.s',parent).addClass(fun);
		$('input.code.d',parent).removeClass('checked');
	}else if($this.is('.none')){
		// 清－全不选
		$('input.code',parent).removeClass('checked');
	}
}

function reload(){
	location.reload();
}

function reloadMemberInfo(){
	$('.user').load('/index.php/index/userInfo');
}

function randomSelectCode(len, codes){
	var i,selectCode=[], codesLen=codes.length;
	for(i=0; i<len; i++){
		selectCode[i]=Math.floor(Math.random()*codesLen);
	}
	
	return selectCode;
}
/**
 * 追号
 */
function setGameZhuiHao(data){
	//console.log(data);
	
	$.get('/index.php/index/zhuiHaoModal', function(html){
		$(html).alert({
			title:'<select name="qh"><option value="10">最近10期</option><option value="20">最近20期</option><option value="30">最近30期</option><option value="40">最近40期</option><option value="50">最近50期</option><option value="0">今天全部</option></select>　<label><input type="checkbox" checked name="zhuiHaoMode" value="1"/>中奖后停止追号</label>　追号期数：<span class="qs">0</span>　总金额：<span class="amount">0.00</span>元',
			minWidth:600,
			height:300,
			modal:true,
			stack:false,
			dialogClass:'zhui-hao-modal',
			
			buttons:{
				"全选":function(){
					$('thead :checkbox', this).prop('checked', true).trigger('change');
				},
				"反选":function(){
					$('tbody :checkbox', this).each(function(){
						this.checked=!this.checked;
						$(this).trigger('change');
					});
					$('thead :checkbox', this).prop('checked', false);
				},
				
				"确定追号":function(){
					var data=[];
					$('tbody :checkbox:checked', this).each(function(){
						var $this=$(this),
						$tr=$this.closest('tr');
						data.push([$('td:eq(1)', $tr).text(), $('.beishu', $tr).val(), $('td:eq(4)', $tr).text()].join('|'));
					});
					
					if(!data.length){
						AlertDialog('追号至少选一期');
						return false;
					}
					
					$('.touzhu-bottom .tz-buytype :checkbox[name=zhuiHao]').data({
						zhuiHao:data.join(';'),
						zhuiHaoMode:$(this).closest('.zhui-hao-modal').find(':checkbox[name=zhuiHaoMode]:first')[0].checked?1:0
					})[0].checked=true;
					$( this ).AlertDialog( "destroy" );
					gameCalcAmount();
				},
				"取消追号":function(){
					$('.touzhu-bottom .tz-buytype :checkbox[name=zhuiHao]').removeData()[0].checked=false;
					$( this ).AlertDialog( "destroy" );
					gameCalcAmount();
				}
			},
			
			open:function(event, ui){
				//console.log(this);
				var $this=$(this),
				price=Math.round(data.mode * data.actionNum * 100)/100;
				$this.attr('rel', price);
				$this.attr('src', '/index.php/index/zhuiHaoQs/'+data.type+'/'+price+'/');
				//console.log($this.attr('src')+10);
				$('.tr-cont', this).load($this.attr('src')+10);
				
				$this.closest('.zhui-hao-modal').find('select:first').change(function(){
					$('tbody', $this).load($this.attr('src')+this.value);
				});
			}
		});
	});
	

}

function doZhuiHaoCount(){
	var count=0, amount=0;
	$('tbody tr :checkbox', this).each(function(i, v){
		
	});
}

/**
 * 查看投注号码
 */
function displayCodeList(opts){
	$('<div>').append(
		$('<textarea class="code-tip-box"></textarea>')
		.append(opts.actionData)
	).AlertDialog({title:'投注号码'});
}

function gameMsgAutoTip(){
	var obj,$game=$('#num-select .pp'),
	calcFun=$game.attr('action');
	
	if(calcFun && (calcFun=window[calcFun]) && (typeof calcFun=='function')){
		try{
			obj=calcFun.call($game);
			if($.isArray(obj)){
				o={actionNum:0};
				obj.forEach(function(v,i){
					o.actionNum+=v.actionNum;
				});
				obj=o;
			}
			//console.log(obj);
			//var str='共'+obj.actionNum+'注，金额'+(gameGetMode()*gameGetBeiShu()*obj.actionNum).round(2)+'元';
			$('#game-tip-dom').text('共'+obj.actionNum+'注，金额'+(gameGetMode()*gameGetBeiShu()*obj.actionNum).round(2)+'元');
		}catch(err){
			//console.log(err);
			$('#game-tip-dom').text(err);
		}
	}
}

/**
 * 设置倍数
 */
function setBeiShuCookie(selector){
	var $e=$(selector),
	//opts={expires:0},
	value=parseFloat($e.val());
	
	//console.log(value);
	
	if(value<=0 || isNaN(value)){
		//AlertDialog('请正确设置倍数');
	}else{
		$.cookie('beishu', value);
		//AlertDialog('保存倍数成功，下次默认倍数为当前设置的值。');
	}
	
	//if(value=gameGetFanDian()){
		$.cookie('fanDian', gameGetFanDian());
	//}
	
	if(value=$(':radio[name=danwei]:checked').val()){
		$.cookie('mode', value);
	}
	
	AlertDialogyes('保存成功。');
}

/**
 * 时时彩随机投注
 *
 * @params int number		随机投几注，默认为1
 */
/*
function gameActionRandom(number){

	var $game=$('#num-select .pp'),
	fun=$game.attr('random');
	//len=$game.attr('length');
	
	try{
		
		fun=window[fun];
		if(typeof fun=='function'){
			gameAddCode(fun.call($game, number));
		}
		
	}catch(err){
		AlertDialog(err);
	}
}
*/

/**
 * 清除号码
 *
 * @params bool isSelected	是否只清除选中的项，默认false
 */
function gameActionRemoveCode(isSelected){
	$('.touzhu-cont tr').remove();
	$('.touzhu-bottom :checkbox[name=zhuiHao]').removeData()[0].checked=false;
	gameCalcAmount();
}

/**
 * 添加预投注
 * code {actionNo:'12,3,4,567,8', actionNum:6}
 */
function gameAddCode(code){
	
	
	if($.isArray(code)){
		for(var i=0; i<code.length; i++) gameAddCode(code[i]);
		return;
	}
	
	if(code.actionNum==0) throw('号码不正确');
	try{
		code=$.extend({
			
			// 反点
			fanDian: gameGetFanDian(),
			bonusProp:gameGetPl(code),
			// 模式
			mode: gameGetMode(),
			
			// 倍数
			beiShu: gameGetBeiShu(),

			// 预定单ID
			orderId: (new Date())-2147483647*623
		}, code);
		
		var weiShu=0, wei='',
		modeName={'2':'元', '0.2':'角', '0.02':'分'},
		amount=code.mode * code.beiShu * code.actionNum,
		$wei=$('#wei-shu'),
		playedName=code.playedName||$('.game-cont .current').text(),
		weiCount=parseInt($wei.attr('length'));
		
		if(code.playedName) delete code.playedName;
		delete code.isZ6;
		
		//console.log(code.mode);
		
		if($wei.length){
			if($(':checked', $wei).length!=weiCount) throw('请选择'+weiCount+'位数！');
			$(':checked', $wei).each(function(){
				weiShu|=parseInt(this.value);
			});
		}
		code.weiShu=weiShu;
		
		if(weiShu){
			var w={16:'万', 8:'千', 4:'百', 2:'十',1:'个'}
			for(var p in w){
				if(weiShu & p) wei+=w[p];
			}
			wei+=':';
		}
		//console.log(weiShu);
		
		$('#num-select input:hidden').each(function(){
			code[$(this).attr('name')]=this.value;
		});

		delete code.undefined;
		$('<tr>').data('code', code)
		.append(
			// 玩法
			$('<td>').append(playedName)
		)
		.append(
			// 号码列表
			$('<td class="code-list">').append(wei+(code.actionData.length>18?(code.actionData.substr(0,5)+'...'):code.actionData))
		)
		.append(
			// 注数
			$('<td>').data('value', code.actionNum).append('['+code.actionNum+'注]')
		)
		.append(
			// 总金额
			$('<td>').data('value', amount).append(amount.round(2)+"元")
		)
		.append(
			// 倍数
			$('<td>').append(code.beiShu+'倍')
		)
		.append(
			// 单价
			$('<td>').append(modeName[code.mode])
		)
		// .append(
		// 	奖－返
		// 	$('<td>').append('奖－返：'+parseFloat(code.bonusProp).round(2)+'-'+parseFloat(code.fanDian).round(1)+'%')
		// )
		.append(
			// 操作
			$('<td><div class="del img02"></div></td>')
		)
		.appendTo('.touzhu-cont table');
		
		$('#textarea-code').val("");
		gameCalcAmount();
		
		$('.tz-buytype :checkbox[name=zhuiHao]').removeData()[0].checked=false;
		
		$('.num-table :button.checked').removeClass('checked');
	}catch(err){
		AlertDialog(err);
	}
}

/**
 * 添加投注
 */
function gamePostCode(){
	var code=[],	// 存放投注号特有信息
	zhuiHao,		// 存放追号信息
	data={};		// 存放共同信息

	$('.touzhu-cont tr').each(function(){
		code.push($(this).data('code'));
	});
	
	if(code==""){
		AlertDialog('您还未添加预投注');
		return false;
	}

	$('.touzhu-bottom :checkbox:checked').each(function(){
		data[$(this).attr('name')]=this.value;
	});
	
	if($(':checkbox[name=zhuiHao]')[0].checked){
		var $dom=$(':checkbox[name=zhuiHao]');
		zhuiHao=$dom.data('zhuiHao');
		data.zhuiHao=1;
		data.zhuiHaoMode=$dom.data('zhuiHaoMode');
	}

	wait();
	var actionNo=$.parseJSON($.ajax('/index.php/game/getNo/'+game.type,{async:false}).responseText);
	destroyWait();
	if(!actionNo){
		AlertDialog('获取投注期号出错');
		return false;
	}
	
	var tipString='确定要购买第'+actionNo['actionNo']+'期？\n'+$('.tz-tongji').text();
	if(!confirm(tipString)){
		return false;
	}
	
	data['actionNo']=actionNo.actionNo;
	data['kjTime']=actionNo.actionTime;

	wait();
	$.ajax('/index.php/game/postCode', {
		data:{
			code:code,
			para:data,
			zhuiHao:zhuiHao
		},
		type:'post',
		dataType:'json',
		error:function(xhr, textStatus, errorThrown){
			gamePostedCode(errorThrown||textStatus);
		},
		success:function(data, textStatus, xhr){
			gamePostedCode(null, data);
		},
		complete:function(xhr, textStatus){
			// 服务器运行异常
			// 尝试获取服务器抛出
			destroyWait();
			var errorMessage=xhr.getResponseHeader('X-Error-Message');
			if(errorMessage) gamePostedCode(decodeURIComponent(errorMessage));
		}
	});
}

/**
 * 投注后置函数
 */
function gamePostedCode(err, data){
	if(err){
		if('您的可用资金不足，是否充值？'==err){
			if(window.confirm(err)) location='/index.php/cash/recharge';
		}else{
			AlertDialog(err);
		}
	}else{
		gameActionRemoveCode();
		gameFreshOrdered();
		//reloadMemberInfo();
		gameCalcAmount();
		$('#game-tip-dom').text('');
		//reload();
	}
}


/**
 * 计算注数与金额，并显示
 */
function gameCalcAmount(){
	var count=0;amount=0.0, $zhuiHao=$(':checkbox[name=zhuiHao]');
	
	if($zhuiHao.prop('checked')){
		var data=$('.touzhu-cont tr').data('code');
		$zhuiHao.data('zhuiHao').split(';').forEach(function(v){
			count+=parseInt(v.split('|')[1]);
		});
		amount=data.mode*data.actionNum*count;
	}else{
		$('.touzhu-cont tr').each(function(){
			var $this=$(this);
			count+=$('td:eq(2)', $this).data('value');
			amount+=$('td:eq(3)', $this).data('value');
		});
	}

	$('#all-count').text(count);
	$('#all-amount').text(amount.round(2));
}

/**
 * 添加投注
 */

function gameActionAddCode(){
	//奖金返点限制[如奖金模式在1920以下才能购买分模式(返点大于最大返点-11)]
	var modeName={'2.00':'元','0.20':'角','0.02':'分'},
	$mode=$(':radio:checked[name=danwei]'),
	$slider=$('#slider'),
	fanDian=gameGetFanDian(),
	modeFanDian=$mode.data().maxFanDian,
	userFanDian=$slider.attr('fan-dian'),
	mode=$mode.val();
	
	if(userFanDian-fanDian> modeFanDian){
		var pl=$('#fandian-value').data(),
		_amount=(pl.maxpl-pl.minpl)/$slider.attr('game-fan-dian')*modeFanDian+(pl.minpl-0);
		AlertDialog(modeName[mode]+'模式最大奖金只能为'+_amount.toFixed(2));
		return false;
	}
	
	// 单笔中奖限额
	var maxZjAmount=$slider.data().betZjAmount;
		//console.log('限额：%s, 中奖：%s', maxZjAmount, gameGetPl() * mode * ($('#beishu').val()||1));
	if(maxZjAmount){
		if($('#fandian-value').data('pl') * mode/2 * ($('#beishu').val()||1) > maxZjAmount){
			AlertDialog('单笔中奖奖金不能超过'+maxZjAmount+'元');
			return false;
		}
	}

	var obj,$game=$('#num-select .pp'),
	calcFun=$game.attr('action');
	if(calcFun && (calcFun=window[calcFun]) && (typeof calcFun=='function')){
		try{
			obj=calcFun.call($game);
			//console.log(obj);
			// 单笔投注注数限额
			var maxBetCount=$slider.data().betCount;
			if(maxBetCount && obj.actionNum>maxBetCount){
				AlertDialog('单笔投注注数最大不能超过'+maxBetCount+'注');
				return false;
			}
			
			if(typeof obj!='object'){
				throw('未知出错');
			}else{
				gameAddCode(obj);
			}
		}catch(err){
			AlertDialog(err);
		}
	}
}

/**
 * 更新定单列表
 */
function gameFreshOrdered(err, msg){
	if(err){
		AlertDialog(err);
	}else{
		$('#order-history').load('/index.php/game/getOrdered/'+game.type, reloadMemberInfo);
	}
}

/**
 * 设置反点
 *
 * @params value		反点值，可以是个浮点数，表示在当前值时的增量
 */

function gameSetFanDian(value){
	var $dom=$("#fandian-value"),
	gameFanDian=parseFloat($('#slider').attr('game-fan-dian')),
		myFanDian=parseFloat($('#slider').attr('fan-dian')),
		pl=parseFloat($dom.data('maxpl')),
	minPl=parseFloat($dom.data('minpl')),
	//str=(pl-minPl)/gameFanDian*myFanDian+minPl-(pl-minPl)*value/gameFanDian;//拖动返点总数
	str=(pl-minPl)/gameFanDian*myFanDian+minPl-(pl-minPl)*value/gameFanDian;//拖动返点总数
	moshi=1700+value.round(1)*20;
	str=str.round(2);
	
	$('#slider').slider('option', 'value', value);
	
	if(pl==minPl){
		$('.fandian-box').hide();
		//value=0;
		$dom.data('pl', str);
		str+=' ';
		$dom.text(str);
	}else{
		$('.fandian-box').show();
		$dom.data('pl', str);
			str+=' / '+value.round(1)+'%';
		//str+='/'+moshi;
		$dom.text(str);
	}
	
}

/**
 * 设置赔率
 */
var FANDIAN=0;
function gameSetPl(value, flag, fanDianBdw){
	//console.log(value);
	var $dom=$('#slider');
	//value=((100-parseFloat($dom.attr('game-fan-dian'))+parseFloat($dom.attr('max')))*value/100).round(1);

	$('#fandian-value').data('maxpl', value.bonusProp);
	$('#fandian-value').data('minpl', value.bonusPropBase);
	
	var $slider=$('#slider').closest('.fandian-box');
	if(flag){
		$('.fandian-k').css('visibility','hidden');
	}else{
		$('.fandian-k').css('visibility','visible');
	}
	
	if(fanDianBdw){
		//FANDIAN=gameGetFanDian();
		gameSetFanDian(fanDianBdw);
	}else{
		FANDIAN=FANDIAN||gameGetFanDian();
		gameSetFanDian(FANDIAN);
	}
}

/**
 * 读取反点值
 */
function gameGetFanDian(){
	return $('#slider').slider('option', 'value');
}

/**
 * 读取陪率
 */
function gameGetPl(code){
	var $dom=$('#num-select .pp');
	if($dom.is('[action=tzSscHhzxInput]')){
		//gameSetPl
		if(code.isZ6){
			var set={
				bonusProp:parseFloat($dom.attr('z6max')),
				bonusPropBase:parseFloat($dom.attr('z6min'))
			};
		}else{
			var set={
				bonusProp:parseFloat($dom.attr('z3max')),
				bonusPropBase:parseFloat($dom.attr('z3min'))
			};
		}
		//console.log(set);
		gameSetPl(set, true);
	}
	
	return $('#fandian-value').data('pl');
}

// 读取模式
function gameGetMode(){
	return parseFloat($('#game-dom :radio[name=danwei]:checked').val()||1);
}

// 读取倍数
function gameGetBeiShu(){
	var txt=$('#beishu').val();
	if(!txt) return 1;
	
	if(txt.match(/[^0-9]/)){
		throw('倍数只能为正整数');
	}
	
	if(isNaN(txt=parseInt(txt))) throw('倍数设置不正确');
	return txt;
}

//}}}

//{{{ 相关算法集
/**
 * 笛卡尔乘积算法
 *
 * @params 一个可变参数，原则上每个都是数组，但如果数组只有一个值是直接用这个值
 *
 * useage:
 * console.log(DescartesAlgorithm(2, [4,5], [6,0],[7,8,9]));
 */
function DescartesAlgorithm(){
	var i,j,a=[],b=[],c=[];
	if(arguments.length==1){
		if(!$.isArray(arguments[0])){
			return [arguments[0]];
		}else{
			return arguments[0];
		}
	}
	
	if(arguments.length>2){
		for(i=0;i<arguments.length-1;i++) a[i]=arguments[i];
		b=arguments[i];
		
		return arguments.callee(arguments.callee.apply(null, a), b);
	}

	if($.isArray(arguments[0])){
		a=arguments[0];
	}else{
		a=[arguments[0]];
	}
	if($.isArray(arguments[1])){
		b=arguments[1];
	}else{
		b=[arguments[1]];
	}

	for(i=0; i<a.length; i++){
		for(j=0; j<b.length; j++){
			if($.isArray(a[i])){
				c.push(a[i].concat(b[j]));
			}else{
				c.push([a[i],b[j]]);
			}
		}
	}
	
	return c;
}

/**
 * 组合算法
 *
 * @params Array arr		备选数组
 * @params Int num
 *
 * @return Array			组合
 *
 * useage:  combine([1,2,3,4,5,6,7,8,9], 3);
 */
function combine(arr, num) {
	var r = [];
	(function f(t, a, n) {
		if (n == 0) return r.push(t);
		for (var i = 0, l = a.length; i <= l - n; i++) {
			f(t.concat(a[i]), a.slice(i + 1), n - 1);
		}
	})([], arr, num);
	return r;
}

/**
 * 排列算法
 */
function permutation(arr, num){
	var r=[];
	(function f(t,a,n){
		if (n==0) return r.push(t);
		for (var i=0,l=a.length; i<l; i++){
			f(t.concat(a[i]), a.slice(0,i).concat(a.slice(i+1)), n-1);
		}
	})([],arr,num);
	return r;
}

//}}}

//{{{ 抢庄玩法相关函数
function gameLoadZnzPage(type){
	$('.game-left.img-bj').load('/index.php/index/znz/'+type);
}

//}}}

//{{{ 计算注数算法集
	
/**
 * 全选号码
 *
 * @params			没有参数，函数的this指向$('#num-select')
 * @return			要求返回一个对象{actionData:"1,2,3,4,5,6",actionNum:2}
 * @throw			遇到不正常时请抛出，系统会自动处理
 */
function tzAllSelect(){
	var code=[], len=1,codeLen=parseInt(this.attr('length')), delimiter=this.attr('delimiter')||"";
	
	
	//console.log(this.has('.checked'));
	if(this.has('.checked').length!=codeLen) throw('请选'+codeLen+'位数字');
	
	this.each(function(i){
		//console.log(i);
		var $code=$('input.code.checked', this);
		if($code.length==0){
			//throw('选择号码不正确');
			code[i]='-';
		}else{
			len*=$code.length;
			code[i]=[];
			$code.each(function(){
				code[i].push(this.value);
			});
			code[i]=code[i].join(delimiter);
			
		}
	});
	
	return {actionData:code.join(','), actionNum:len};
}
/**
 * 大小单双选号
 *
 * @params			没有参数，函数的this指向$('#num-select')
 * @return			要求返回一个对象{actionData:"1,2,3,4,5,6",actionNum:2}
 * @throw			  遇到不正常时请抛出，系统会自动处理
 */
function tzDXDS(){
	var code=[], len=1,codeLen=2;
	
	
	//console.log(this.has('.checked'));
	if(this.has('.checked').length!=codeLen) throw('请选'+codeLen+'位数字');
	
	this.each(function(i){
		//console.log(i);
		var $code=$('input.code.checked', this);
		if($code.length==0){
			//throw('选择号码不正确');
			code[i]='-';
		}else{
			len*=$code.length;
			code[i]=[];
			$code.each(function(){
				code[i].push(this.value);
			});
			code[i]=code[i].join("");
			
		}
	});
	
	return {actionData:code.join(','), actionNum:len};
}

/**
 * 五星定位胆选号
 *
 * @params			没有参数，函数的this指向$('#num-select')
 * @return			要求返回一个对象{actionData:"1,2,3,4,5,6",actionNum:2}
 * @throw			  遇到不正常时请抛出，系统会自动处理
 */
function tz5xDwei(){
	var code=[], len=0;
	
	
	//console.log(this.has('.checked'));
	//if(this.has('.checked').length!=codeLen) throw('请选'+codeLen+'位数字');
	
	this.each(function(i){
		//console.log(i);
		var $code=$('input.code.checked', this);
		if($code.length==0){
			//throw('选择号码不正确');
			code[i]='-';
		}else{
			len+=$code.length;
			code[i]=[];
			$code.each(function(){
				code[i].push(this.value);
			});
			code[i]=code[i].join("");
			
		}
	});
	
	if(!len) throw('至少选一个号码');
	
	return {actionData:code.join(','), actionNum:len};
}

/**
 * 不定胆选号
 *
 * @params			没有参数，函数的this指向$('#num-select')
 * @return			要求返回一个对象{actionData:"1,2,3,4,5,6",actionNum:2}
 * @throw			  遇到不正常时请抛出，系统会自动处理
 */
function tz5xBDwei(){
	var code="", len=0, $code=$('input.code.checked', this);
	len=$code.length;
	if(!len) throw('至少选一个号码');
	
	$code.each(function(){
		code+=this.value;
	});
	//console.log(code);
	return {actionData:code, actionNum:len};
}

/**
 * 时时彩录入式投注
 * 这种方式投注时可共享DOM和length属性
 */
function tzSscInput(){
	var codeLen=parseInt(this.attr('length')),
	codes=[],
	str=$('#textarea-code',this).val().replace(/[^\d]/g,'');
	
	if(str.length && str.length % codeLen == 0){
		if(/[^\d]/.test(str)) throw('投注有错，不能有数字以外的字符。');
		codes=codes.concat(str.match(new RegExp('\\d{'+codeLen+'}', 'g')));
	}else{
		throw('输入号码不正确');
	}
	
	codes=codes.map(function(code){
		return code.split("").join(',')
	});
	
	return {actionData:codes.join('|'), actionNum:codes.length}
}

/**
 * 时时彩录入式组选投注
 * 这种方式投注时可共享DOM和length属性
 */
function tzSscZuInput(){
	var codeLen=parseInt(this.attr('length')),
	codes=[];
	$('#textarea-code',this).val().split(/[\r\n]/).forEach(function(str){
		if(str.length && str.length % codeLen == 0){
			if(/[^\d]/.test(str)) throw('投注有错，不能有数字以外的字符。');
			codes=codes.concat(str.match(new RegExp('\\d{'+codeLen+'}', 'g')));
		}else{
			throw('输入号码不正确');
		}
	});
	
	codes.forEach(function(code){
		if((new RegExp("^(\\d)\\1{"+(codeLen-1)+"}$")).test(code)) throw('组选不能为豹子');
	});
	
	codes=codes.map(function(code){
		return code.split("").join(',')
	});

	return {actionData:codes.join('|'), actionNum:codes.length}
}

/**
 * 时时彩录入式选位数投注
 * 这种方式投注时可共享DOM和length属性
 */
function tzSscWeiInput(){
	var codeLen=parseInt(this.attr('length')),
	codes=[],weiShu=[],
	str=$('#textarea-code',this).val().replace(/[^\d]/g,'');
	
	if($('#wei-shu :checked',this).length!=codeLen) throw('请选'+codeLen+'位数');
	$('#wei-shu :checkbox',this).each(function(i){
		if(!this.checked) weiShu.push(i);
	});

	if(str.length && str.length % codeLen == 0){
		if(/[^\d]/.test(str)) throw('投注有错，不能有数字以外的字符。');
		codes=codes.concat(str.match(new RegExp('\\d{'+codeLen+'}', 'g')));
	}else{
		throw('输入号码不正确');
	}
	
	
	codes=codes.map(function(code){
		code=code.split("");
		
		weiShu.forEach(function(v,i){
			code.splice(v, 0, '-');
		});
		
		return code.join(',');
	});

	return {actionData:codes.join('|'), actionNum:codes.length}
}

/**
 * 时时彩录入式组选位数投注
 * 这种方式投注时可共享DOM和length属性
 */
function tzSscZuWeiInput(){
	var codeLen=parseInt(this.attr('length')),
	codes=[],weiShu=[],
	str=$('#textarea-code',this).val().replace(/[^\d]/g,'');
	
	if($('#wei-shu :checked',this).length!=codeLen) throw('请选'+codeLen+'位数');
	$('#wei-shu :checkbox',this).each(function(i){
		if(!this.checked) weiShu.push(i);
	});
	

	if(str.length && str.length % codeLen == 0){
		if(/[^\d]/.test(str)) throw('投注有错，不能有数字以外的字符。');
		codes=codes.concat(str.match(new RegExp('\\d{'+codeLen+'}', 'g')));
	}else{
		throw('输入号码不正确');
	}
	
	
	codes.forEach(function(code){
		if((new RegExp("^(\\d)\\1{"+(codeLen-1)+"}$")).test(code)) throw('组选不能为豹子');
	});
	
	codes=codes.map(function(code){
		code=code.split("");
		
		weiShu.forEach(function(v,i){
			code.splice(v, 0, '-');
		});
		
		return code.join(',');
	});

	return {actionData:codes.join('|'), actionNum:codes.length};
}


/**
 * 组合组选
 */
function tzCombineSelect(){
	var codeLen=parseInt(this.attr('length')),
	codes='', $select=$('.checked'),len;
	
	if($select.length<codeLen) throw('请选'+codeLen+'位数');
	
	$select.each(function(){
		codes+=this.value;
	});
	
	len=combine(codes.split(""), codeLen).length;
	
	return {actionData:codes, actionNum:len};
}

/**
 * 排列组选
 */
function tzPermutationSelect(){
	var codeLen=parseInt(this.attr('length')),
	codes='', $select=$('.checked'),len;
	
	if($select.length<codeLen) throw('请选'+codeLen+'位数');
	
	$select.each(function(){
		codes+=this.value;
	});
	
	len=permutation(codes.split(""), codeLen).length;
	
	return {actionData:codes, actionNum:len};
}

function tzPermutation3Select(){
	var codeLen=parseInt(this.attr('length')),
	codes='', $select=$('.checked'),len;
	
	if($select.length<codeLen) throw('请选'+codeLen+'位数');
	
	$select.each(function(){
		codes+=this.value;
	});
	
	len=3*permutation(codes.split(""), codeLen).length;
	
	return {actionData:codes, actionNum:len};
}

/**
 * 混合组选录入式投注
 */
function tzSscHhzxInput(){
	var codeList=$('#textarea-code').val(),		// 输入号码列表
	played=this.attr('played'),					// 玩法：前、后、任选
	z3=[],			// 分解出来的组三列表
	z6=[];			// 分解出来的组六列表
	
	var o={"前":[16,17],"后":[19,20],"任选":[22,23]};
	
	if(played=='任选' && $('#wei-shu :checked',this).length!=3) throw('请选3位数');
	
	
	codeList=codeList.replace(/[^\d]/gm,'');
	if(codeList.length==0) throw('请输入号码');
	if(codeList.length % 3) throw('输入号码不正确');
	
	codeList.replace(/[^\d]/gm,'').match(/\d{3}/g).forEach(function(code){
		var reg=/(\d)(.*)\1/;
		if(/(\d)\1{2}/.test(code)){
			throw('组选不能为豹子');
		}else if(reg.test(code)){
			// 组三
			//z3.push(code.replace(reg,'$1$2'));
			z3.push(code);
		}else{
			// 组六
			z6.push(code);
		}
	});
	
	if(z3.length && z6.length){
		return [{playedId:o[played][0], playedName:played+'三组三', actionData:z3.join(','), actionNum:z3.length, isZ6:false},
				{playedId:o[played][1], playedName:played+'三组六', actionData:z6.join(','), actionNum:z6.length, isZ6:true}];
	}else if(z3.length){
		return {playedId:o[played][0], playedName:played+'三组三', actionData:z3.join(','), actionNum:z3.length, isZ6:false};
	}else if(z6.length){
		return {playedId:o[played][1], playedName:played+'三组六', actionData:z6.join(','), actionNum:z6.length, isZ6:true};
	}
}


/**
 * 十一选五任选玩法投注
 */
function tz11x5Select(){
	var code=[], len=1,codeLen=parseInt(this.attr('length')),sType=!!$('.dantuo :radio:checked').val();
	//console.log(this);
	
	if(sType){
		// 胆拖方式
		var $d=$(this).filter(':visible:first'),
		$t=$d.next(),
		dLen=$('.code.checked', $d).length;
		
		if(dLen==0){
			throw('至少选一位胆码');
		}else if(dLen>=codeLen){
			throw('最多只能选择'+(codeLen-1)+'个胆码');
		//}else if(dLen==1){
		//	$(':input:visible.code.checked').each(function(i,o){
		//		code[i]=o.value;
		//	});
		//	if(code.length<codeLen) throw('胆码和拖码至少选择'+codeLen+'位数');
		//	
		//	return {actionData:code.join(' '), actionNum:combine(code, codeLen).length};
		}else{
			var dCode=[],tCode=[];
			$('.code.checked', $d).each(function(i,o){
				dCode[i]=o.value;
			});
			
			$('.code.checked', $t).each(function(i,o){
				tCode[i]=o.value;
			});
			
			len=combine(tCode, codeLen-dCode.length).length;
			return {actionData:'('+dCode.join(' ')+')'+tCode.join(' '), actionNum:len};
		}
	}else{
		// 普通方式
		$(':input:visible.code.checked').each(function(i,o){
			//console.log(i);
			code[i]=o.value;
		});
		if(code.length<codeLen) throw('至少选择'+codeLen+'位数');
		
		return {actionData:code.join(' '), actionNum:combine(code, codeLen).length};
	}
}

//}}}

//{{{随机投注函数集

/**
 * 时时彩随机投注函数
 * 
 * @params num		投机投几注，默认为1，可以设置为5，选几位数由HTML属性length得
 * @return			要求返回一个对象{actionData:"1,23,4,5,6",actionNum:2}
 *
 */
/*
function sscRandom(num){
	var i, j, code, codes=[], codeLen=parseInt(this.attr('length'));
	
	for(i=0; i<num; i++){
		
		code=[];
		for(j=0; j<codeLen; j++){
			code.push(Math.floor(Math.random()*10));
		}
		
		codes[i]=code;
	}
	
	return {actionData:codes.join('|'), actionNum:codes.length};
}
*/
//}}}


//{{{签到
function indexSign(err, data){
	$('#sign').css('display','none');
	if(err){
		AlertDialog(err);
	}else{
		reloadMemberInfo();
		AlertDialog(data);
	}
}
//}}}


