// JavaScript Document
//formname 表单名称 | textid 文本框ID | codeid 返回ID | ID 分类ID 0:不限 | isdx 是否多选:1 | flag 是否限制选择(单选):1
var absurl=window.location.pathname.substring(0,location.pathname.lastIndexOf('/')+1);

function opentree(tablename,textid,codeid,id,isdx,flag){
	$.dialog({
		id: 'tree-win',
        title: '请选择...',
        content:'url:/tree.php?tablename='+tablename+'&textid='+textid+'&codeid='+codeid+'&id='+id+'&isdx='+isdx+'&flag='+flag,
		fixed:true,
		lock:false,
		width:250,
		height:380,
		max:false,
		min:false,
		zIndex:9998        
	});
}

function newdialog(title,url,w,h){
	absurl=(url.toLowerCase().indexOf('http://')>-1)?'':absurl;
	var s=(url.toLowerCase().indexOf('?')>-1)?'&':'?';
	$.dialog({
        id: 'win',
        title: title,
        content:'url:'+absurl+url+s+'timeStamp='+ new Date().getTime(),
		fixed:true,
		lock:true,
		cache:false,
		width:w,
		height:h    
	});
}

function showDialog(tit,url,w,h){
	    var api = frameElement.api, W = api.opener;
		absurl=(url.toLowerCase().indexOf('http://')>-1)?'':absurl;
		var s=(url.toLowerCase().indexOf('?')>-1)?'&':'?';
		//api.hide();
		W.$.dialog({ 
		title: tit,
        content:'url:'+absurl+url+s+'timeStamp='+ new Date().getTime(),
		fixed:true,
		lock:true,
		cache:false,
		width:w,
		height:h,
		parent:api
		});	
		//api.close();
}

function newwin(url,width,height){
   var top,left;
   if(width==1 && height==1){  
       top=0; left=0;
   }else{
	   top=(screen.height-height)/2-30; left=(screen.width-width)/2;
	   //alert((screen.height-height)/2); 
   }
   window.open(url,'','width='+width+',height='+height+', top='+top+', left='+left+', toolbar=no, menubar=no, scrollbars=yes, resizable=yes,location=no, status=no');
}