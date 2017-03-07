<?php
require("global.php");
$qx=$db -> get_one("select qx from g_user_group where groupid=".$_SESSION['groupid']);
if(empty($qx)){ exit('没有权限'); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>左侧菜单</title>
<link href="../css/iconfont.css" rel="stylesheet" type="text/css">
<style type="text/css">
html { overflow-x: hidden; overflow-y: auto; }
/*定义滚动条高宽及背景 高宽分别对应横竖滚动条的尺寸*/  
::-webkit-scrollbar  
{  
    width: 12px; 
    background-color: #FFF;  
}  
  
/*定义滚动条轨道 内阴影+圆角*/  
::-webkit-scrollbar-track  
{  
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);  
    background-color: #FFF;  
}  
  
/*定义滑块 内阴影+圆角*/  
::-webkit-scrollbar-thumb  
{  
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);  
    background-color:#333;  
}  

ul,h2 { margin:0px; padding:0px; }
body,td,th {
	font-family: "宋体", Arial, Verdana, sans-serif;
	font-size: 12px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	
	_background-image:url(about:blank);
	_background-attachment:fixed;/*防止页面抖动*/
}
img { border:0; }
.fix { position:fixed; _position:absolute; top:0px; _top: expression(documentElement.scrollTop + 0 + "px"); left:0px; z-index:9999;  }

.container { width:200px; height:auto; overflow:hidden; }
.head { width:200px; height:36px; line-height:36px; text-indent:30px; color:#FFF; font-size:16px; font-family:微软雅黑; background:url(Images/leftbg.gif) repeat-x; overflow:hidden;}
.head i { font-size:18px; }
.content { width:200px; position:absolute; top:36px; overflow:hidden; }
.menu h2 { height:36px; line-height:36px; color:#FFF; font-family:微软雅黑; font-size:16px; font-weight:normal;  text-indent:50px; cursor:pointer; background:url(Images/leftbg.gif) repeat-x;}
.menu ul { list-style:none; display:none; padding-top:5px; padding-bottom:5px; }
.menu ul li { border-bottom:1px solid #0390B2; }
.menu ul li a { display:block;  width:200px; padding-left:50px; height:30px; line-height:30px; text-decoration:none;  font-size:14px; color:#111;  overflow:hidden; }
.menu ul li a:hover,.menu ul li.on { font-weight:bold; background:#E2EBFD; color:#000;  }

.chgbg { background:url(Images/leftbg.gif) left bottom !important; }
</style>
<script type="text/javascript" src="../Include/jquery-1.8.3.min.js"></script>   
<script type="text/javascript">
$(document).ready(function(e) {

	$(".head").click(function(){
	    $(".menu > h2").toggleClass('chgbg');
		$(".menu > ul").toggle();
	});

	$(".menu").find("h2").click(function(){
	    $(this).toggleClass('chgbg');
		$(this).parent().find("ul").toggle();
		
	});
	
	$(".menu li").click(function(){
		 $(".menu li").removeClass("on");
	     $(this).addClass("on");
	});
});
</script>

</head>

<body>
<div class="container">
    <div class="head fix"><i class="iconfont">&#xe60e; </i><span>功能菜单</span></div>
    <div class="content">
    <?php  
    $sql="select * from g_user_qx where parentid=0 and classid in ($qx) order by orderid";
    $query=$db -> query($sql);
	$i=0;
	while($row = $db -> fetch_array($query)){
    ?>
        <div class="menu">
            <h2><?php echo $row['classname'] ?></h2>
            <ul>
		   <?php 
            $sql="select * from g_user_qx where parentid=$row[classid] and classid in ($qx) order by orderid";
            $query2 = $db -> query($sql);
            while($row2 = $db -> fetch_array($query2)){	
          ?>
            <li><a href="<?php echo $row2['url'] ?>" style="background:url(../UploadFile/icon/<?php echo $row2['img'] ?>) no-repeat 25px center;" target="main"><span><?php echo $row2['classname'] ?></span></a></li>
            <?php }?>
            </ul>         
        </div>
    <?php 
	$i++;
	}?>   
    </div>
</div>
</body>
</html>