<?php require('global.php');?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>江苏省苏南国家自主创新示范区·南京高新区建设促进服务中心</title>
<script type="text/javascript" src="../Include/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../Include/jquery.cookie.js"></script>
<script language="javascript">
/*window.onbeforeunload = function(){ 
	alert('禁止刷新，请重新登录！');  
	window.location='loginout.php';
} */

function exit(){
	if(confirm('确定要退出系统吗？')){
		//window.onbeforeunload = null;
		$.cookie('isClose',null);
		window.location='loginout.php';
	}
}

$(document).ready(function(){ 
    $("#switchmenu").click(function(){
	     $(this).toggleClass("off");
		 $("#switchtd").toggle();	
	});
	
	$(".remove-btn").live("click",function(){
	     $(this).parent().parent().parent().remove();
	});
	
	$(".remenber").live("click",function(){
		 $.cookie('isClose','yes');
		 //alert($.cookie('isClose'));
	});
	
	GetData();
	window.setInterval('GetData()',1000*8); //在线短消息
	window.setInterval('UpdateTime()',1000*10); //更新在线时间
	window.setInterval('UpdateOnline()',1000*60); //更新在线状态
});

function GetData(){
    //alert($.cookie('isClose'));
	if(	$.cookie('isClose')!='yes'){
		  $.ajax({
			 type: "POST",
			 url: "usermsg_ajax.php",
			 data: "timeStamp=" + new Date().getTime(),
			 success: function(msg){
			   $("#message").css({"position":"absolute","z-index":100, "bottom":24, "right":0,"width":300,"max-height":400,"overflow-y":"auto"});
			   $("#message").prepend(msg);
			   $("#message").html(msg);
			 }
		  }); 
	}
}
function UpdateTime(){
	$.ajax({
	   type: "POST",
	   url: "online_ajax.php",
	   data: "Action=UpdateTime&timeStamp=" + new Date().getTime()
	}); 
}
function UpdateOnline(){
	$.ajax({
	   type: "POST",
	   url: "online_ajax.php",
	   data: "Action=UpdateOnline&timeStamp=" + new Date().getTime()
	}); 
}
</script>
<?php echo openwin("false"); ?>
<link href="../css/iconfont.css" rel="stylesheet" type="text/css">
<style type="text/css">
*{ margin:0; padding:0}
ul { list-style:none; }
body, html{ height:100%; width:100%; overflow:hidden;} /*这个高度很重要*/
body,td,th {
	font-family:宋体, Verdana, Geneva, sans-serif;
	font-size: 12px;
	background:url(Images/bg.jpg) no-repeat left top #025F54;
}
a { color:#00F; }
a:hover { color:#C00;  }

#frametable .header{ height:70px; line-height:70px; border-bottom:2px solid #333; color:#FFF; }
#frametable .header .logo { float:left; height:70px; width:400px; position:relative;  }
#frametable .header .logo h1 { position:absolute; top:5px; left:15px; height:30px; line-height:30px; font:normal 24px/1.5 "微软雅黑"; }
#frametable .header .logo h2 { position:absolute; top:40px; left:35px;  height:22px;  line-height:22px; font-size:16px;  font-family:微软雅黑; font-style:normal; }
#frametable .header span { float:right; font-size:14px; margin-right:30px; }
#frametable .leftmenu { width:200px; height:100%; border-right:1px solid #0B4380; }
#frametable .footer{ height:24px; line-height:24px; color:#FFF; background:#025F54; }
#frametable .footer span {  }
#switchmenu { display:block; height:50px; width:10px; background:url(Images/open.gif); position:absolute; top:40%; left:0;}
#switchmenu.off { background:url(Images/open.gif) 10px top; }

.topmenu { float:right; }
.topmenu ul li { float:left; }
.topmenu ul li a { display:block; color:#E9F7FC; text-decoration:none; width:70px; height:70px; text-align:center; overflow:hidden; position:relative; }
.topmenu ul li a i { font-size:24px; display:block; height:24px; width:70px; position:absolute; left:0; top:-10px; }
.topmenu ul li a div { position:absolute; width:70px; left:0; top:20px; text-align:center; }
.topmenu ul li a.on,.topmenu ul li a:hover { background:#0498A6; color:#FFF !important; }

.msg-box { width:286px; background:#FFF; border:2px solid #06544B;}
.msg-box .hd { height:30px; line-height:30px; overflow:hidden;}
.msg-box .hd h2 { float:left; font-size:16px; padding:0 10px; color:#06544B;  }
.msg-box .hd span { float:right;   }
.msg-box .hd span a { display:block; width:30px; height:30px; line-height:30px; text-align:center; background:#06544B; color:#FFF; font-size:12px; text-decoration:none; }
.msg-box .hd span a:hover { background:#C00; }
.msg-box .bd { padding:10px; }
.msg-box .bd  p { margin-bottom:10px;  }
.msg-box .bd  a.close-btn { display:block; background:#CCC; text-align:center; width:100%; height:30px; line-height:30px; color:#000; text-decoration:none;   }
.msg-box .bd  a.close-btn:hover { background:#F60; color:#FFF; }
</style>
</head>

<body>
<table id="frametable" cellpadding="0" cellspacing="0" width="100%" height="100%" style="width: 100%;">
    <tr>
        <td height="70" colspan="2"><div class="header">
                <div class="logo">
                <img src="Images/logo2.png">
                </div>
                <div class="topmenu">
                <ul>
                <li><a href="welcome.php" target="main"><i class="iconfont">&#xe643; </i><div>欢迎界面</div></a></li>
                <li><a href="../index.php" target="top" class="on"><i class="iconfont">&#xe616; </i><div>返回首页</div></a></li>
                <li><a href="user/user_my_edit.php" target="main"><i class="iconfont">&#xe60b; </i><div>个人信息</div></a></li>
                <li><a href="user/user_pwd.php" target="main"><i class="iconfont">&#xe610; </i><div>修改密码</div></a></li>
                <li><a href="javascript:;" onClick="main.location.reload()"><i class="iconfont">&#xe625; </i><div>刷新</div></a></li>
                <!--<li><a href="javascript:;" onClick="main.history.back(-1);"><i class="iconfont">&#xe698; </i><div>返回</div></a></li>-->
                <li><a href="#" onClick="exit();"><i class="iconfont">&#xe628; </i><div>退出</div></a></li>
                </ul>
                </div>
                <span>欢迎您，<a href=# onClick="newdialog('在线短消息','user_online.php',180,300);"><font color="#FFFFFF"><?php echo $_SESSION['username'] ?></font></a>[<?php echo getGroupName($_SESSION['groupid']) ?>]</span>
            </div>
      </td>
    </tr>
    <tr>
        <td width="200" height="100%" valign="top" id="switchtd"> <!--这个高度很重要-->
        <div class="leftmenu">
        <iframe id="menu" name="menu" scrolling="yes" frameborder="0" width="200" src="left.php"  height="100%" allowTransparency="true" style="overflow:visible;">浏览器不支持嵌入式框架，或被配置为不显示嵌入式框架。</iframe></div>
        </td>
        <td valign="top" width="100%" height="100%" style="position:relative;" bgcolor="#FFFFFF"> <!--这个高度很重要-->
        <a id="switchmenu" href="javascript:;"></a>
        <iframe id="main" name="main" scrolling="yes" frameborder="0" width="100%" src="welcome.php"  height="100%" style="overflow:visible;">浏览器不支持嵌入式框架，或被配置为不显示嵌入式框架。</iframe>
      </td>
    </tr>
    <tr>
        <td height="25" colspan="2" align="center">
        <div class="footer"></div>
        </td>
  </tr>    
</table>
<div id="tip"></div>
<div id="message"></div>
</body>
</html>