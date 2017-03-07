<?php 
require('../global.php');
//参数
$id=(int)$_GET['id'];
$Action=$_POST['Action'];
$ggname=trim($_POST["ggname"]);
$classid=(int)$_POST["classid"];
$posid=(int)$_POST["posid"];
$xgid=(int)$_POST["xgid"];
$width=(float)$_POST["width"];
$height=(float)$_POST["height"];
$url=trim($_POST["url"]);
$code=trim($_POST["code"]);
$remark=trim($_POST["remark"]);
$hits=(int)$_POST["hits"];
$orderid=(int)$_POST["orderid"];
$states=(int)$_POST["states"];
//Init
$act='add';
function init(){
global $ggname,$url,$code,$remark,$addtime;
if(empty($ggname)){ htmlendjs("广告名称不能为空",""); }
if(empty($url)){ htmlendjs("URL不能为空",""); }
}
//操作
if($Action=='add'){
    init();
    $db->query("INSERT INTO g_gg(ggname,userid,classid,posid,xgid,width,height,url,code,remark,hits,orderid,addtime) VALUES('$ggname',$_SESSION[userid],$classid,$posid,$xgid,width=$width,height=$height,'$url','$code','$remark',$hits,$orderid,now())");	
    htmlendjs('添加成功','dialog-open');
}
if($Action=='edit'){
    init();
    $db->query("update g_gg set ggname='$ggname',classid=$classid,posid=$posid,xgid=$xgid,width=$width,height=$height,url='$url',code='$code',remark='$remark',hits=$hits,orderid=$orderid,addtime=now() where id=$id");	
    htmlendjs('修改成功','dialog-open');
}
//赋值
if(!empty($id)){
    $query=$db->query("select * from g_gg where id=$id");
    $row = $db -> fetch_array($query);
    if($row){
    $ggname=$row['ggname'];
	$classid=$row['classid'];
	$posid=$row['posid'];
	$xgid=$row['xgid'];
	$width=$row['width'];
	$height=$row['height'];
	$url=$row['url'];
	$code=$row['code'];
	$remark=$row['remark'];
	$hits=$row['hits'];
	$orderid=$row['orderid'];
	$states=$row['states'];
	$addtime=$row['addtime'];
    $act='edit';
    }
    
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>发布广告</title>
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../Include/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../../include/jquery.validator.js"></script>
<script type="text/javascript">
$(function(){
	var uppic='<iframe frameborder="0" scrolling="no" src="../../include/upload.php?path=logo&inputid=code" width="100%" height="25"></iframe>';
	var upflash='<iframe frameborder="0" scrolling="no" src="../../include/upload.php?type=media&path=logo&inputid=code" width="100%" height="25"></iframe>';
	
	<?php if($classid==6){ ?>
	$("#show").html(uppic);
	<?php } 
	if($classid==7){ ?>
	$("#show").html(upflash);
	<?php } ?>
	
   $(":input[name=classid]").change(function(){
		if($(this).val()==6){
            $("#show").html(uppic);
		}
		if($(this).val()==7){
            $("#show").html(upflash);
		}
		if($(this).val()==8){
            $("#show").html('');
			$("#width,#height").val(0);
		} 
   });
   
   $("#myform").checkForm(); 
});
</script>

</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" background="../images/tab_05.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="30"><img src="../images/tab_03.gif" width="12" height="30" /></td>
        <td><img src="../images/tb.gif" width="16" height="16" align="absmiddle" />&nbsp;你当前的位置：发布广告</td>
        <td align="right">&nbsp;</td>
        <td width="16"><img src="../images/tab_07.gif" width="16" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" background="../images/tab_12.gif">&nbsp;</td>
        <td><form name="form1" method="post" action="?id=<?php echo $id; ?>" id="myform">
          <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#DEF2FF">
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">广告名称</td>
              <td bgcolor="#FFFFFF"><input name="ggname" type="text" id="ggname" size="50" datatype="Require" msg="必填" value="<?php echo  $ggname ?>"/></td>
              </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">广告类型</td>
              <td bgcolor="#FFFFFF"><?php echo  selectBox("g_nclass_link","select","classid",3,$classid) ?></td>
              </tr>
            
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">广告位置</td>
              <td bgcolor="#FFFFFF"><select name="posid" id="posid" datatype="Require" msg="未选择">
                <option value="">- 未选择 -</option>
                <?php
                $class_arr=getClassArray('g_nclass_link',5);
                echo tree($class_arr,0,$posid);
            ?>
              </select></td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">广告效果</td>
              <td bgcolor="#FFFFFF"><?php echo  selectBox("g_nclass_link","radio","xgid",4,$xgid) ?></td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">广告大小</td>
              <td bgcolor="#FFFFFF">宽
                <input name="width" type="text" id="width" size="10" value="<?php echo  $width ?>"  datatype="Double" msg="数字"/>
                x高
                  <input name="height" type="text" id="height" size="10" value="<?php echo  $height ?>"  datatype="Double" msg="数字"/>
                  (单位:像素)</td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">URL</td>
              <td bgcolor="#FFFFFF"><input name="url" type="text" id="url" size="50" value="<?php echo  $url ?>"/>
                (只支持图片类型)</td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">广告代码</td>
              <td bgcolor="#FFFFFF"><textarea name="code" id="code" style="width:500px;height:90px;"><?php echo  $code ?></textarea>
              <div id="show"></div>              </td>
              </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">备注</td>
              <td bgcolor="#FFFFFF"><textarea name="remark" id="remark" style="width:500px;height:90px;"><?php echo  $remark ?></textarea></td>
            </tr>
            <tr>
              <td height="25" align="right" bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF"><input type="submit" name="button" id="button" value="提交" class="btn">
                <input type="hidden" name="Action" id="Action" value="<?php echo $act; ?>"/></td>
              </tr>
          </table>
                </form>
        </td>
        <td width="8" background="../images/tab_15.gif">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="35" background="../images/tab_19.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="35"><img src="../images/tab_18.gif" width="12" height="35" /></td>
        <td>&nbsp;</td>
        <td width="16"><img src="../images/tab_20.gif" width="16" height="35" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>