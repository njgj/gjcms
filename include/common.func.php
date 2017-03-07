<?php
/*
 * 文件名：common.func.php
 * 功  能：系统公用函数库
 */

/* 防注入函数 */
if (!get_magic_quotes_gpc ()) {
	$_GET = sec ( $_GET );
	$_POST = sec ( $_POST );
	$_COOKIE = sec ( $_COOKIE );
	$_FILES = sec ( $_FILES );
}

function sec(&$array) { 
	//如果是数组，遍历数组，递归调用
	if (is_array ( $array )) {
		foreach ( $array as $k => $v ) {
		$array [$k] = sec ( $v );
		} 
	} else if (is_string ( $array )) {
	//使用addslashes函数来处理
	    $array = addslashes ( $array );	
		$array = stripSql( $array );
	} else if (is_numeric ( $array )) {
	    $array = intval ( $array );
	}
	return $array;
}

/**
 *  过滤SQL关键字函数
 */
function stripSql($str){
	$sqlkey = array(	 //SQL过滤关键字
	    "/\\\'/",
		'/\s*select\s*/i',
		'/\s*delete\s*/i',
		'/\s*update\s*/i',
		'/\s*drop\s*/i',
		'/\s*or(?!der)\s*/i',//排除order
		'/\s*union\s*/i',
		'/\s*outfile\s*/i'
	);
	$replace = array(  //和上面数组内容对应
		'',
		'&nbspselect&nbsp;',
		'&nbsp;delete&nbsp;',
		'&nbsp;update&nbsp;',
		'&nbsp;drop&nbsp;',
		'&nbsp;or&nbsp;',
		'&nbsp;union&nbsp;',
		'&nbsp;outfile&nbsp;'
	);
	if(!is_array($str)){
		//如果不是数组直接替换
		$str = preg_replace($sqlkey,$replace,$str); 
		return $str;
	}else{
		//如果是数组
		$new_str = array();
		foreach($str as $k=>$v){
			//遍历整个数组进行替换
			$new_str[$k] = stripSql($v);
		}
		unset($sqlkey,$replace);
		return $new_str;
	}
}
 
/* 审核状态显示 */  
function chkState($num) {
    if($num==0){$v='<font color=red>未审核</font>';}
	if($num==1){$v='<font color=blue>已审核</font>';}
	if($num==2){$v='<font color=green>已置顶</font>';}
	return $v;
}

/* 咨询状态显示 */  
function chkZxState($num) {	
    if($num==0){$v='<font color=red>未查看</font>';}
	if($num==1){$v='<font color=blue>已查看</font>';}
	if($num==2){$v='<font color=green>已回复</font>';}
	if($num==3){$v='<font color=gray>已查看回复</font>';}
	return $v;
}

/* 审核是否 */  
function chkIsYes($st) {
    if($st==0){$v='<font color=red>否</font>';}
	if($st==1){$v='<font color=blue>是</font>';}
	return $v;	
}

/* 格式化时间 */ 
function formatdate($sj){
    if(!empty($sj)){
	   return @date('Y-m-d',strtotime($sj));
	}
}
 
/* 通用alert提示 */  
function htmlendjs($msg,$act,$url='') {
	switch($act){
		case '':
			$str="$.dialog({ icon:'error.gif',width:300,zIndex:9999,title: '在线提示',content:'$msg',ok: function(){ history.back(); } });";
			break;
		case 'close':
		    $str=($msg)?"alert('$msg');":'';
			$str.="window.close();";
			break;
		case 'open':
			$str=($msg)?"window.opener.alert('$msg');":'';
			$str.="if(self == top){ window.opener.location.reload();window.close();}else{window.location='".$_SERVER['HTTP_REFERER']."';}";
			break;
		case 'dialog-open':
		    $str="var w=frameElement.api;if(w.opener!=null){w.opener.location.reload()};if(w.opener.opener!=null){w.opener.opener.location.reload();}w.close();";
		    $str=($msg)?"$.dialog({ icon:'success.gif',width:300,zIndex:9999,title: '在线提示',content:'$msg',ok: function(){ ".$str." } });":'';
			break;
		case 'dialog-close':
		    $str="var w=frameElement.api;w.close();";
		    $str=($msg)?"$.dialog({ icon:'error.gif',width:300,zIndex:9999,title: '在线提示',content:'$msg',ok: function(){ ".$str." } });":'';
			break;
		//ajax方式局部刷新				
		case 'ajax':
			$str="var w; try{ w=frameElement.api; }catch(e){ w=window; }";
			$str.="if(w.opener!=null){ if(typeof(w.opener.ajaxLoad)!='undefined'){w.opener.ajaxLoad('$url');}else{ w.opener.location.reload();  }  }";
			$str.="if(w.opener.opener!=null){ if(typeof(w.opener.opener.ajaxLoad)!='undefined'){w.opener.opener.ajaxLoad('$url');}else{ w.opener.opener.location.reload(); }  }";
			$str.=" w.close();";
			$str=($msg)?"$.dialog({ icon:'success.gif',width:300,zIndex:9999,title: '在线提示',content:'$msg',ok: function(){ ".$str." } });":'';
			break;
		case 'tip':
		    $str="$.dialog.tips('msg',6,'tips.gif');";
			break;
		case 'confirm':
		    $str="$.dialog.confirm('$msg', function(){ self.location=document.referrer; },function(){  window.location='$url'; });";
			break;							
		default:
			$str="$.dialog({ icon:'success.gif',width:300,zIndex:9999,title: '在线提示',content:'$msg',ok: function(){ window.location='$act'; } });";
	}
    $str="<!DOCTYPE html><html><head><meta charset='utf-8'></head><body><script type='text/javascript' src='".ROOT_PATH."lhgdialog/lhgcore.lhgdialog.min.js?skin=iblue&self=true'></script><script>$str</script></body></html>";
	echo $str;
	exit();	
}

//获取nclass表数组(含classid本身)，配合tree树形函数
function getClassArray($tablename,$classid=0){
	global $db;
	$class_arr=array();
	$sql = "select * from $tablename where classid>0";
	$sql.=(!empty($classid))?" and locate(',$classid,',classpath)>0":"";
	//$sql.=" order by locate(','+classid+',',classpath),orderid";
	$sql.=" order by orderid";
	echo $sql;
	$query = $db -> query($sql);
	while($row = $db -> fetch_array($query)){
		$class_arr[] = array($row['classid'],$row['classname'],$row['parentid'],$row['orderid']);
		//$class_arr[] = array($row['classid'],$row['classname'],$row['parentid']);
	}
	return $class_arr;
}

//$class_arr[] = array($row['classid'],$row['classname'],$row['parentid']);
//$parentid:父类ID $classid:当前classid $m:填充长度
function tree($class_arr,$parentid=0,$classid=0,$m=0) {		
	$n = str_pad('',$m,'-',STR_PAD_RIGHT);
	$n = str_replace("-","│",$n);
	for($i=0;$i<count($class_arr);$i++){
	    //从parentid
		if($class_arr[$i][2]==$parentid){
			if($class_arr[$i][0]==$classid){
				$str.="<option value=\"".$class_arr[$i][0]."\" selected=\"selected\">".$n."├ ".$class_arr[$i][1]."</option>\n";
			}else{
				$str.="<option value=\"".$class_arr[$i][0]."\">".$n."├ ".$class_arr[$i][1]."</option>\n";
			}
			$str.=tree($class_arr,$class_arr[$i][0],$classid,$m+1);			
		}		
	}	
	return $str;
} 
 
/*搜索结果加亮 */ 
function replaceKey($key,$text){
	$keys = explode(' ', $key);
	foreach($keys as $v){
		if(preg_match('/'.$v.'/iSU', $text)){
			$text = str_replace($v, '<font color="#FF0000">'.$v.'</font>', $text);
		}
	}
	return $text;
}

/* 搜索获取纯文本 */
function html2text($str){
	$str = strip_tags($str);
	$str = str_replace('&nbsp', '', $str);
	$str = str_replace(' ','',$str);
	return $str;
}


/**
 * 将实体<br>转换为\n
 */
function htmldecode($str){
	$str = str_replace('<br />',"\n",$str);
	$str = str_replace('<br>',"\n",$str);
	$str = str_replace('&nbsp;'," ",$str);
	$str = str_replace('&lt','<',$str);
	$str = str_replace('&gt','>',$str);
	return $str;

}

/*
 * 转换HTML标签
 */
function htmlcode($str){
	if(!is_array($str)){
		$str = str_replace(' ', '&nbsp;', $str);
		$str = str_replace('<', '&lt', $str);
		$str = str_replace('>', '&gt', $str);
		$str = str_replace("\n", '<br />', $str);
		return $str;
	}else{
		foreach($str as $k=>$v){
			$new_str[$k] = stripHtml($v);
		}
		return $new_str;
	}
}

/**
 * 字符串截取
 */
function gottopic($String, $Length,$act = true) {
	//if (mb_strwidth($String, 'UTF8') <= $Length) {
      if (mb_strwidth($String) <= $Length) {
		return $String;
	} else {
		$I = 0;
		$len_word = 0;
		while ($len_word < $Length) {
			$StringTMP = substr($String, $I, 1);
			if (ord($StringTMP) >= 224) {
				$StringTMP = substr($String, $I, 3);
				$I = $I +3;
				$len_word = $len_word +2;
			}
			elseif (ord($StringTMP) >= 192) {
				$StringTMP = substr($String, $I, 2);
				$I = $I +2;
				$len_word = $len_word +2;
			} else {
				$I = $I +1;
				$len_word = $len_word +1;
			}
			$StringLast[] = $StringTMP;
		}
		/* raywang edit it for dirk for (es/index.php)*/
		if (is_array($StringLast) && !empty ($StringLast)) {
			$StringLast = implode("", $StringLast);
			if($act){
				$StringLast .= "...";
			}
		}
		return $StringLast;
	}
}

/**
 * 新闻列表显示
 */
function NewsClass($classid,$num=8,$len,$istime=1){
	global $db;	
	if($classid){
		$str='<ul class="list">';
		$sql="select id,title,addtime from g_news where states>0 and classid=$classid order by states desc,id desc limit $num";
		$rs = $db -> query($sql);
		while ($row=$db->fetch_array($rs)) {
			$str.="<li><a href='article-$row[id].html'>".gottopic($row['title'],$len)."</a>";
			if ($istime) {
				$str.='<span>['.formatdate($row['addtime']).']</span>';
			}
			$str.='</li>';
		}
		$str.='</ul>';
		return $str;
	}
	else{
	    return '';	
	}
}

//默认页面变量
$page = $_GET['page'];

//$totle：信息总数；
//$pagesize：每页显示信息数，这里设置为默认是20；
//$url：分页导航中的链接参数(除page)
function TurnPage($totle,$pagesize=20,$url='auto',$halfPer=5){
	
	global $page,$offset,$pagenav;	
	//$GLOBALS["pagesize"]=$pagesize;
	
	$totalpage=ceil($totle/$pagesize); //最后页，也是总页数
	//$page=min($totalpage,$page);
	if(!isset($page)||$page<1) $page=1;
	
	$prepage=$page-1; //上一页
	$nextpage=$page+1; //下一页
	$offset=($page-1)*$pagesize;//偏移量
	if($totalpage<=1) return false;
	
	//自动获取GET变量
	if($url=='auto'){
		foreach($_GET as $k=>$v){
			if($k!='page'){
				if($v!='') $str.=$k.'='.$v."&";
			} 
		}
		$url=$str;
	}
	
	//获取当前文件名
	$filename = end(explode('/',$_SERVER['PHP_SELF']));   
	
	//开始分页导航条代码：
	$pagenav="显示第 <B>".max($offset+1,1)."</B>-<B>".min($offset+$pagesize,$totle)."</B> 条记录，共 <B>$totle</B> 条记录";
	
	$pagenav.=" <a href=$filename?$url"."page=1>首页</a> ";
	if($prepage>0) $pagenav.=" <a href=$filename?$url"."page=$prepage>上页</a> "; 
	
	for ( $i = $page - $halfPer,$i > 0 || $i = 1 , $j = $page + $halfPer, $j <= $totalpage || $j = $totalpage;$i <= $j ;$i++ )
	{
		$pagenav .= $i == $page 
			? " <span class='current'>$i</span>" 
			: " <a href=$filename?$url"."page=$i>$i</a>";
	}
	
	if($nextpage<$totalpage) $pagenav.=" <a href=$filename?$url"."page=$nextpage>下页</a> "; 
	$pagenav.=" <a href=$filename?$url"."page=$totalpage>尾页</a> ";
	
	//下拉跳转列表，循环列出所有页码：
	$pagenav.="　到第 <select name='topage' size='1' onchange='window.location=\"$filename?$url"."page=\"+this.value'>\n";
	for($i=1;$i<=$totalpage;$i++){
	  if($i==$page){
		  $pagenav.="<option value='$i' selected>$i</option>\n";}
	  else{
		  $pagenav.="<option value='$i'>$i</option>\n"; 
	   } 
	}
	$pagenav.="</select> 页，共 <B>$totalpage</B> 页";
}

/**
 * 建立请求，以表单HTML形式构造（默认）
 * @param $para 请求参数数组
 * @param $method 提交方式。两个值可选：post、get
 * @return 提交表单HTML文本
 */
function buildRequestForm($action,$para,$method) {		
	$sHtml = "<form id='autosubmit' name='autosubmit' action='".$action."' method='".$method."'>";
	while (list ($key, $val) = each ($para)) {
		$sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
	}
	$sHtml = $sHtml."</form>";
	
	$sHtml = $sHtml."<script>document.forms['autosubmit'].submit();</script>";
	return $sHtml;	
}

function file_get_contents_post($url, $post) {  
    $options = array(  
        'http' => array(  
            'method' => 'POST',  
            // 'content' => 'name=gongjun&email=hmgj940@sohu.com',  
            'content' => http_build_query($post),  
        ),  
    ); 
    $result = file_get_contents($url, false, stream_context_create($options));  
    return $result;  
}

 
/* 获得当前classid的上级父id */  
function getParentId($tablename,$classid) {
	global $db;
	$v=false;
	if(!empty($classid)){
		 $v=$db->get_one("select parentid from $tablename where classid=$classid");
	}
	return $v;
}

/* 获得当前classid的类别名称 */  
function getClassName($tablename,$classid) {
	global $db;
	$v=false;
	if(!empty($classid)){	
		 $v=$db->get_one("select classname from $tablename where classid=$classid");
	}
	return $v;
}	

/* 获得用户名 */  
function getUserName($userid) {
    global $db;
	$str='';
	if(!empty($userid)){	
		 $str=$db->get_one("select username from g_user_info where userid=$userid");
	}
	return $str;
}

/* 获得用户组名称 */  
function getGroupName($groupid) {
    global $db;
	$str='';
	if(!empty($groupid)){	
		 $str=$db->get_one("select groupname from g_user_group where groupid=$groupid");
	}
	return $str;
}


/*'inputType:radio/checkbox/select 
'inputName:控件名称 
'id:所属大类id
'defaultID:默认ID(多值用","分隔)
'返回classid*/
function selectBox($tableName,$inputType,$inputName,$id,$defaultID){
    global $db;
	$classname=getClassName($tableName,$id);
	$sql="select classid,classname from $tableName where parentid=$id order by orderid";
	$query=$db->query($sql);
	$j=1;
	$totals=$db->num_rows($query);
	while($row=$db->fetch_array($query)){
	    if(strtolower($inputType)=='radio' || strtolower($inputType)=='checkbox'){
			$flag=false;
			$arr=explode(',',$defaultID);
			foreach($arr as $v){
			    if(!empty($v)){
				    if($v==$row['classid']){
					     $flag=true;
						 break;
					}
				}
			}
			$ctr=(strtolower($inputType)=='checkbox')?'[]':'';
			$mstr=($flag==true)?' checked':'';
			$nstr=($j==$totals)?" dataType='Group' msg='未选择$classname'.$j":'';
		    $str.="<input type='".strtolower($inputType)."' name='".$inputName.$ctr."' id='".$inputName.$j."' value='".$row['classid']."'$mstr$nstr/><label for='".$inputName.$j."'>".$row['classname']."</label>&nbsp;";
		}
	    if(strtolower($inputType)=='select'){
			if(!empty($defaultID)){
			   if($row['classid']==(int)$defaultID){
			      $mstr=' selected';
			   }
			}
		    $str.="<option value='".$row['classid']."'$mstr>".$row['classname']."</option>";
		}
		$ctr=$mstr=$nstr='';
		$j++;
	}
	
	if(strtolower($inputType)=="select"){
	     $str2="<select name='".$inputName."' dataType='Require' msg='未选择$classname'><option value=''>— 请选择 —</option>".$str."</select>";
	}else{
	     $str2=$str;
	}
	return $str2;
}


/*'inputType:radio/checkbox/select 
'inputName:控件名称 
'id:所属大类id
'defaultName:默认值(多值用","分隔)
'返回classname*/
function selectBoxName($tableName,$inputType,$inputName,$id,$defaultName){
    global $db;
	$classname=getClassName($tableName,$id);
	$sql="select classid,classname from $tableName where parentid=$id order by orderid";
	$query=$db->query($sql);
	$j=1;
	$totals=$db->num_rows($query);
	while($row=$db->fetch_array($query)){
	    if(strtolower($inputType)=='radio' || strtolower($inputType)=='checkbox'){
			$flag=false;
			$arr=explode(',',$defaultName);
			foreach($arr as $v){
			    if(!empty($v)){
				    if($v==$row['classname']){
					     $flag=true;
						 break;
					}
				}
			}
			$ctr=(strtolower($inputType)=='checkbox')?'[]':'';
			$mstr=($flag==true)?' checked':'';
			$nstr=($j==$totals)?" dataType='Group' msg='未选择$classname'.$j":'';
		    $str.="<input type='".strtolower($inputType)."' name='".$inputName.$ctr."' id='".$inputName.$j."' value='".$row['classname']."'$mstr$nstr/><label for='".$inputName.$j."'>".$row['classname']."</label>&nbsp;";
		}
	    if(strtolower($inputType)=='select'){
			if(!empty($defaultName)){
			   if($row['classname']==$defaultName){
			      $mstr=' selected';
			   }
			}
		    $str.="<option value='".$row['classname']."'$mstr>".$row['classname']."</option>";
		}
		$ctr=$mstr=$nstr='';
		$j++;
	}
	
	if(strtolower($inputType)=="select"){
	     $str2="<select name='".$inputName."' dataType='Require' msg='未选择$classname'><option value=''>— 请选择 —</option>".$str."</select>";
	}else{
	     $str2=$str;
	}
	return $str2;
}


/*'id:所属大类id
'defaultID:默认ID(多值用","分隔)*/
function readCheckBox($tableName,$id,$defaultID){
    global $db;
	$sql="select classid,classname from $tableName where parentid=$id order by orderid";
	$query=$db->query($sql);
	while($row=$db->fetch_array($query)){
			$flag=false;
			$arr=explode(',',$defaultID);
			foreach($arr as $v){
			    if(!empty($v)){
				    if($v==$row['classid']){
					     $flag=true;
						 break;
					}
				}
			}
			$mstr=($flag==true)?'checked':'';
			$str.="<input type=checkbox name=s value='".$row['classid']."' $mstr onclick='return false'/>".$row['classname']."&nbsp;";
	}
	return $str;
}


//广告位显示
function myAd($width,$posid,$xgid,$states=1){
	global $db;
	$sql="select * from g_gg where posid=$posid and xgid=$xgid";
	$sql.=($states)?' and states>0':'';
	$sql.=" order by states desc,orderid,id";
	$query=$db->query($sql);
	if($db->num_rows($query)>0){
		$str=($width>0)?"<div style='width:".$width."px' id='ad".$posid."_".$xgid."' class='{class}'><ul>":'';
		while($row=$db->fetch_array($query)){
			if($row['classid']==6){
				$str.="<li>";
				if(!empty($row['url'])){
					$str.="<a href='".ROOT_PATH."ad.php?id=".$row['id']."' target='_blank'><img src='".ROOT_PATH."uploadfile/logo/".$row['code']."' width='".$row['width']."' height='".$row['height']."' border=0/></a>";
				}else{
					$str.="<img src='".ROOT_PATH."uploadfile/logo/".$row['code']."' width='".$row['width']."' height='".$row['height']."' border=0/>";
				}
				$str.="</li>";
			}
		
			if($row['classid']==7){
				$str.="<li><object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0' width='".$row['width']."' height='".$row['height']."'><param name='movie' value='".ROOT_PATH."uploadfile/ad/".$row['code']."' /><param name='quality' value='high'/><embed src='".ROOT_PATH."uploadfile/ad/".$row['code']."' quality='high' pluginspage='http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' width='".$row['width']."' height='".$row['height']."'></embed></object></li>";
			}
			
			if($row['classid']==8){ $str.=$row['code']; }				
		}		
		$str.="</ul><p><a href=# onclick=\"$('#ad".$posid."_".$xgid."').remove()\">关闭</a></p></div>";
	}
	//占位
	if($xgid==9){ $str=str_replace("{class}","ad",$str);}
	//左联
	if($xgid==10){ $str=str_replace("{class}","ad ad-left",$str);}
	//右联
	if($xgid==11){ $str=str_replace("{class}","ad ad-right",$str);}
	//漂浮
	if($xgid==12){ $str=str_replace("{class}","ad",$str)&"<script src='".ROOT_PATH."include/floatAd.js' type='text/javascript'></script><script>$('#ad".$posid."_".$xgid."').floatAd({top:30,left:20});</script>";}	
	return $str;			
}

//发送在线消息
function sendUserMsg($fromuserid,$touserid,$title,$content){
	global $db;
	return $db->query("insert into g_user_msg(fromuserid,touserid,title,content,isdisp,islooked,addtime) values($fromuserid,$touserid,'$title','$content',0,0,now())");
}

/*
调用lhgdialog弹出插件
self:如果不写此参数或值为false时则窗口跨框架弹出在框架最顶层页面，如果值为true则不跨框架，而在当前面页弹出*/
function openwin($v){

    $str.="<script type='text/javascript' src='".ROOT_PATH."/lhgdialog/lhgcore.lhgdialog.min.js?self=".$v."&skin=blue' charset=utf-8></script>";
	$str.="<script type='text/javascript' src='".ROOT_PATH."/include/dialog.js'></script>";
	return $str;
}

//用户组验证 groupid:'1,2,3'
function chk_admin($groupid){
    if(strpos(','.$groupid.',' , ','.$_SESSION['groupid'].',')===false){
	    echo "没有权限";
	    exit();
	}
}

//验证用户操作ID权限(对应表含userid)
function chk_user($tablename,$id,$user_zdname='userid',$id_zdname='id'){
   global $db;
   $flag=false;
   //不限制管理员
   if($_SESSION['groupid']==1){
       $flag=true;
   }else{
	   $sql="select * from $tablename where $user_zdname=".$_SESSION['userid']." and $id_zdname=".(int)$id;
	   $query=$db->query($sql);
	   if($db->num_rows($query)>0){
		   $flag=true;
	   }
   }
   return $flag;
}
?>