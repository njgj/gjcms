//jQuery�������֤��� 
//made by gongjun 20160526
;(function($){
   $.fn.validator=function(options){ 
	  var defaults = {
		  'msg': ''
	  };	  
	  var settings = $.extend(defaults, options); 
	  var obj=$("input,textarea,select",this);  

	  obj.bind("blur change",function(){
		  check($(this));
	  });	  

	 //checkbox,radio 
	 obj.each(function(){
	     if($(this).attr('datatype')=='Group'){
		     $('input[name='+$(this).attr('name')+']').attr('datatype','Group').unbind('blur');	
	     }
	 });
	 obj.parent().append("<span></span>");//��ʼ��span
		  	  	    
	  this.submit(function(){
		  var errno=0;
		  obj.each(function(index, element) {
			  if(check($(this))){ errno++; };
		  });
		  if(errno==0){
		     if(options){
				 if(confirm(settings.msg)==false){
					 return false;
				 }
		     }
		  }else{
		     return false; 
		  }
		  return true;
	  });
   }
})(jQuery);

function showMsg(obj,fn){
	var founderror=false;
	var msg=obj.attr('msg')||'';
	if(obj.attr('type')=='radio'||obj.attr('type')=='checkbox'||obj.is('select')){
		msg=$('input[name='+obj.attr('name')+']:last').attr('msg')||'';
		msg=(msg=='')?'δѡ��':msg;
		obj=obj.parent();//�ϼ�Ԫ��
		if(!fn){
			founderror=true;
			obj.children('span').html('<span class=errorTip>'+msg+'</span>');
		}else{
			obj.children('span').html('');
		}
	}else{
	    //fn����falseʱ
		if(!fn){
			obj.css({'border':'1px solid #C00'});
			founderror=true;
			if(msg){
			obj.next('span').html('<span class=errorTip>'+msg+'</span>');
			}
		}else{
			obj.css({'border':'1px solid #CCC'});
			obj.next('span').html('');
		}
	}
	return founderror;
}
		
function check(obj){
	var founderror=false;
	var datatype=obj.attr("datatype");
	var v=obj.val();
	
	switch(datatype){
	case 'Require':
        founderror=showMsg(obj,/.+/.test(v));
		break;
   case 'Number':
        founderror=showMsg(obj,/^\d+$/.test(v));
		break;	
	case 'Double':
	    founderror=showMsg(obj,/^[-\+]?\d+(\.\d+)?$/.test(v));
		break;
    case 'Username':
	    founderror=showMsg(obj,/^[a-zA-Z\u4e00-\u9fa5][\u0391-\uFFE5\w]{1,}$/.test(v));
		break;	
	case 'Limit':
	    var maxval=obj.attr("max")||Number.MAX_VALUE;
		var minval=obj.attr("min")||Number.MIN_VALUE;
		founderror=(minval<= v.length && v.length<=maxval);
		founderror=showMsg(obj,founderror);
		break;	
	case 'Group':
	    v=$('input[name='+obj.attr('name')+']:checked').val();
		founderror=showMsg(obj,v);
		break;	
	}	
	return founderror;
}	