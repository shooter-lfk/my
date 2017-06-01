/**
 * ajax 基本类
 * 依赖 jquery
 * 
 * 开发日期 2008-5-27
 * 开发者 qfjk
 */
function Jajax(){
	/**
	 * 服务器响应所返回的数据
	 * 
	 * @var string 
	 */
	this.responseXMLObj;

	/**
	 * ajax 请求的类型 ("POST" 或 "GET"), 默认是 "POST"
	 * 
	 * @var string 
	 */
	this.type = 'POST';

	/**
	 * ajax 要将请求发送到的URL地址
	 * 
	 * @var string 
	 */
	this.url = null;

	/**
	 * ajax 期望从服务器端返回的数据类型。无默认值：如果服务器返回XML，
	 * 就将responseXML传递到回调函数，否则将resposeText传递到回调函数
	 * 
	 * @var string 
	 */
	this.dataType = null;
	
	/**
	 * 只有响应自上次请求后被修改过才承认是成功的请求。是通过检查头部的Last-Modified值实现的。
	 * 默认值为false，即忽略 对部分的检查
	 * 
	 * @var boolean
	 */
	this.ifModified = null;

	/**
	 * 覆盖全局延迟的局部延迟，例如，在其他所有延迟经过1秒钟后，启动一个较长延迟的单独请求。
	 * 
	 * @var int
	 */
	this.timeout = null;
	
	/**
	 * 是否为当前的请求触发全局AJAX事件处理函数，默认值为true。
	 * 设置为false可以防止触发像ajaxStart或ajaxStop这样的全局事件处理函数。
	 * 
	 * @var boolean
	 */
	this.global = null;
	
	/**
	 * jqurey 当请求失败时调用的函数。这个函数会得到三个参数：XMLHttpRequest对象、
	 * 一个描述所发生的错误类型的字符串和一个可选异常对象（如果有）
	 * 
	 * function
	 */
	this.error =  function(){
//		alert('AJAX error');
	}
	
	/**
	 * jqurey 当请求成功时调用的函数。这个函数会得到一个参数：从服务器返回的数据
	 * （根据“dataType”进行了格式化）。
	 * 
	 * function
	 */
	this.success =  function(){
//		alert('AJAX success');
	}

	/**
	 * jqurey 当请求完成时调用的函数。这个函数会得到两个参数：XMLHttpRequest对象和
	 * 一个描述请求成功的类型的字符串。
	 * 
	 * function
	 */
	this.complete = function() {
//		alert('AJAX complete');
	}
	
	/**
	 * 在默认的情况下，所有请求都是以异步的方式发送的（值为true）。
	 * 如果要使用同步方式，需要将此项设置为false。
	 * 
	 * @var boolean
	 */
	this.async = false;
	
	/**
	 * data - 要发送到服务器的数据。如果还不是一个字符串，就自动轮换为一个查询字符串。
	 * 即附加到GET请求的url后面的字符串。要防止自动处理见processData选项。
	 * 
	 * @var string 
	 */
	this.data = null;
	
	/**
	 * 发送 请求
	 * @return void
	 */
	this.sendAjax = function (){
		var sendQuery = 'this.responseXMLObj = $.ajax({'; 
		if(this.type != null){
			sendQuery = sendQuery + 'type: this.type,';
		}
		if(this.data != null){
			sendQuery = sendQuery + 'data: this.data,';
		}
		if(this.url != null){
			sendQuery = sendQuery + 'url: this.url,';
		}
		if(this.dataType != null){
			sendQuery = sendQuery + 'dataType: this.dataType,';
		}
		if(this.ifModified != null){
			sendQuery = sendQuery + 'ifModified: this.ifModified,';
		}
		if(this.timeout != null){
			sendQuery = sendQuery + 'timeout: this.timeout,';
		}
		if(this.global != null){
			sendQuery = sendQuery + 'global: this.global,';
		}
		if(this.error != null){
			sendQuery = sendQuery + 'error: this.error,';
		}
		if(this.success != null){
			sendQuery = sendQuery + 'success: this.success,';
		}
		if(this.complete != null){
			sendQuery = sendQuery + 'complete: this.complete,';
		}
		if(this.async != null){
			sendQuery = sendQuery + 'async: this.async';
		}
		sendQuery += '});';
		
		
	//	document.writeln("<textarea>"+sendQuery+"</textarea>");
		
		
		eval(sendQuery);
		if(this.responseXMLObj.responseXML != null){
			this.resolverXmlData(this.responseXMLObj.responseXML);
		}else if(this.responseXMLObj.responseText != ''){
			this.resolverTextData(this.responseXMLObj.responseText);
		}
	}
	
	/**
	 * 解析请求 xml 数据
	 * 
	 * @param responseXML xml
	 * @return void
	 */
	this.resolverXmlData = function (xml){
		for(var k = 0; k < xml.childNodes.length; k++){
			if (xml.childNodes[k].nodeName == "ajaxdom"){
				for (var i = 0; i < xml.childNodes[k].childNodes.length; i++){
					var cmdFnName;
					var cmdFnParam;
					var cmdFnParamString = '';
					var xmlFnData;
					
					if (xml.childNodes[k].childNodes[i].nodeName == "cmditem"){
						for (var j = 0; j < xml.childNodes[k].childNodes[i].attributes.length; j++) {//解析命令
							if (xml.childNodes[k].childNodes[i].attributes[j].name == "ajaxCmd") {
								cmdFnName = xml.childNodes[k].childNodes[i].attributes[j].value;
							}else if (xml.childNodes[k].childNodes[i].attributes[j].name == "cmdParam") {
								cmdFnParam = xml.childNodes[k].childNodes[i].attributes[j].value;
								cmdFnParams = cmdFnParam.split('|');
								for(var f = 0; f < cmdFnParams.length ; f++){
									cmdFnParamString += ",'" + cmdFnParams[f] +"'"
								}//end for f
							}
						}//end for j
						
						if(xml.childNodes[k].childNodes[i].hasChildNodes() != false){
							xmlFnData = xml.childNodes[k].childNodes[i].firstChild.data;
						}else{
							xmlFnData = null;
						}
						eval("this."+cmdFnName+"('" + xmlFnData + "'" + cmdFnParamString + ")");
					}//end if

					delete cmdFnName;
					delete cmdFnParam;
					delete cmdFnParamString;
					delete xmlFnData;
				}//end for i
			}//end if 
		}//end for k
	}
	
	/**
	 * 解析请求 Text 数据
	 * 
	 * @param responseText text
	 * @return void
	 */
	this.resolverTextData = function (text){
		AlertDialog('返回错误信息');
	}
	/**
	 * 获取form 表单的值
	 * 
	 * @param string|Object formItem
	 * @return string
	 */
	this.getFormValues = function(formItem){
		var objForm;
		var submitDisabledElements = false;
		if (arguments.length > 1 && arguments[1] == true){
			submitDisabledElements = true;
		}
		var prefix="";
		if(arguments.length > 2){
			prefix = arguments[2];
		}
		if (typeof(formItem) == "string"){
			objForm = document.getElementById(formItem);
		}else{
			objForm = formItem;
		}
		var sXml = "";
		if (objForm && objForm.tagName.toUpperCase() == 'FORM')
		{
			var formElements = objForm.elements;
			for( var i=0; i < formElements.length; i++){
				if (!formElements[i].name) {
					continue;
				}
				if (formElements[i].name.substring(0, prefix.length) != prefix) {
					continue;
				}
				if (formElements[i].type && (formElements[i].type == 'radio' || formElements[i].type == 'checkbox') && formElements[i].checked == false){
					continue;
				}
				if (formElements[i].disabled && formElements[i].disabled == true && submitDisabledElements == false) {
					continue;
				}
				var name = formElements[i].name;
				if (name)
				{
					sXml += '&';
					if(formElements[i].type=='select-multiple'){
						for (var j = 0; j < formElements[i].length; j++)
						{
							if (formElements[i].options[j].selected == true) {
								sXml += name + "=" + encodeURIComponent(formElements[i].options[j].value) + "&";
							}
						}
					}else{
						sXml += name+"="+encodeURIComponent(formElements[i].value);
					}
				} 
			}
		}
		return sXml;
	}

	/**
	 * 还原默认属性 方法不在这里还原
	 * 
	 * @return void
	 */
	this.restoreAttribute = function(){
		this.responseXMLObj = null;
		this.type = 'POST';
		this.url = null;
		this.dataType = null;
		this.ifModified = null;
		this.timeout = null;
		this.global = null;
		this.async = false;
		this.data = null;
	}

	/**
	 * 显示提示框
	 *
	 * @param string data
	 * @return void
	 */
	this.Jalert = function (data){
		//arguments[1]
		//alert(data);
		

		
		AlertDialogyes(data);
		//art.dialog({
        //  id: 'testID2',
        // content: data
        // });
		//art.dialog({id: 'testID2'}).title('提示').time(3);


		
		//showmsg(data,0);
	}
	
	/**
	 * 插入数据 
	 * 
	 * @param string       data
	 * @param string|obj   obj
	 * @return void
	 */
	this.Jinsert = function (data,obj,type){
		switch (type){
			case 'id':		eval('$("#'+ obj +'").html(data)'); 	break;
			case 'obj': 	eval('$('+ obj +').html(data)');		break;
			case 'string':	eval('$("'+ obj +'").html(data)'); 		break;
			default:	break;
		}
	}
	
	/**
	 * 显示提示框
	 *
	 * @param string data
	 * @return void
	 */
	this.Jeval = function (data){
		eval(data);
	}
	
	/**
	 * 跳转
	 *
	 * @param string data
	 * @return void
	 */
	this.JwinOpen = function (data){
		if(data=="/user/mymoy.aspx"){
		  clearOrder();
		  $('#orderList88888').css('display','');
		  location.href= "/user/cp.aspx?cp=ssc";
		}
		else{
		  clearOrder();
		  $('#orderList88888').css('display','');
			
			}
	}
	
	/**
	 * pop
	 *
	 * @param string data
	 * @return void
	 */
	this.Jpop = function (data,width,title,direction){
		var menu = '<li>';
		menu += data;
		menu += '</li>';
		return overlib('<ul>'+menu+'</ul>',CSSCLASS,TEXTFONTCLASS,'fontClass',FGCLASS,'fgClass',BGCLASS,'bgClass',STICKY,CAPTIONFONTCLASS,'capfontClass', CLOSEFONTCLASS, 'capfontClass', CAPTION,'<b>'+title+':</b>',WIDTH, width,HAUTO,VAUTO,direction,CELLPAD,10,10,CLOSECLICK);
	}
}



function urls(url){
  location.href= url;  
  //jls1s();
}


