<?php
require('../global.php');
//参数
$id=(int)$_GET['id'];
$Action=$_POST['Action'];
$title=trim($_POST["title"]);
$classid=(int)$_POST["classid"];
$url=trim($_POST["url"]);
$imgurl=trim($_POST["imgurl"]);
$isnew=(int)$_POST["isnew"];
$states=(int)$_POST["states"];
$orderid=(int)$_POST["orderid"];
$addtime=$_POST["addtime"];
//初始化
$act='add';
function init(){
global $title,$url,$imgurl,$addtime;
if(empty($title)){ htmlendjs("链接名称不能为空",""); }
if(empty($url)){ htmlendjs("URL不能为空",""); }
if(empty($addtime)){ $addtime=date('Y-m-d H:i:s'); }
}
//操作
if($Action=='add'){
    init();
    $db->query("INSERT INTO g_link(title,userid,classid,url,imgurl,isnew,states,orderid,addtime) VALUES('$title',$_SESSION[userid],$classid,'$url','$imgurl',$isnew,$states,$orderid,'$addtime')");	
    htmlendjs('添加成功','dialog-open');
}
if($Action=='edit'){
    init();
    $db->query("update g_link set title='$title',classid=$classid,url='$url',imgurl='$imgurl',isnew=$isnew,states=$states,orderid=$orderid,addtime='$addtime' where id=$id");	
    htmlendjs('修改成功','dialog-open');
}
//赋值
if(!empty($id)){
    $query=$db->query("select * from g_link where id=$id");
    $row = $db -> fetch_array($query);
    if($row){
    $title=$row['title'];
	$classid=$row['classid'];
	$url=$row['url'];
	$imgurl=$row['imgurl'];
	$isnew=$row['isnew'];
	$states=$row['states'];
	$orderid=$row['orderid'];
	$addtime=$row['addtime'];
    $act='edit';
    }
    
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>新增链接</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="../css/css.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="../../Include/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../../include/jquery.validator.js"></script>
<script>
$(function(){
    $("#myform").checkForm({msg:'是否确认提交？'}); 
});
</script>
</HEAD>
<BODY>
<form action="?id=<?php echo $id; ?>" method="post" id="myform">
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="30"><img src="../images/tab_03.gif" width="12" height="30" /></td>
        <td background="../images/tab_05.gif"><img src="../images/tb.gif" width="16" height="16" /><span class="title">新增链接</span></td>
        <td width="16"><img src="../images/tab_07.gif" width="16" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" background="../images/tab_12.gif">&nbsp;</td>
        <td height="150" bgcolor="#D3E7FC"><table width="98%" border=0 align=center cellpadding="0" cellspacing=1 >
          
          <tr>
            <td align="right">标题:</td>
            <td><input type="text" name="title" id="title" datatype="Require" msg="必填" value="<?php echo $title; ?>"/>            </td>
          </tr>
          <tr>
            <td align="right">类别:</td>
            <td><select name="classid" id="classid" datatype="Require" msg="未选择">
            <option value="">- 不限类别 -</option>
            <?php
                $class_arr=getClassArray('g_nclass_link',2);
                echo tree($class_arr,0,$classid);
            ?>
          </select>
            </td>
          </tr>
          <tr>
            <td align="right">URL:</td>
            <td><input type="text" name="url" id="url" datatype="Require" msg="必填" value="<?php echo $url; ?>"/>
              <input name="isnew" type="checkbox" id="isnew" value="1" <?php if($isnew==1){ echo 'checked'; } ?>>
              是否新窗口</td>
          </tr>
          <tr>
            <td align="right">图片:</td>
            <td><input type="text" name="imgurl" id="imgurl" value="<?php echo $imgurl; ?>"/>
            <iframe frameborder="0" scrolling="no" src="../../include/upload.php?path=logo" width="100%" height="25"></iframe>
                        </td>
          </tr>
          <tr>
            <td align="right">排序:</td>
            <td><input type="text" name="orderid" id="orderid" datatype="Number" msg="整数" value="<?php echo $orderid; ?>"/>            </td>
          </tr>
          <tr>
            <td colspan="2" align="center" height='30'><input type="submit" class="btn"  value=" 提交 ">
     <input type="hidden" name="Action" id="Action" value="<?php echo $act; ?>"/></td>
          </tr>
        </table></td>
        <td width="8" background="../images/tab_15.gif">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="29"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="35"><img src="../images/tab_18.gif" width="12" height="35" /></td>
        <td background="../images/tab_19.gif">&nbsp;</td>
        <td width="16"><img src="../images/tab_20.gif" width="16" height="35" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</BODY>
</HTML>

