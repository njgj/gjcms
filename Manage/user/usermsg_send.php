<?php
require('../global.php');

$userid=(int)$_REQUEST['userid'];
$Action=$_POST["Action"];

if(empty($userid)) { htmlendjs("参数错误","close"); }


if($Action=="Send"){
    $title=$_POST['title'];
	$content=$_POST['content'];
	if(empty($title)) { htmlendjs("标题不能为空",""); }
	sendUserMsg($_SESSION['userid'],$userid,$title,$content);
	htmlendjs("发送成功","close");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线短信息</title>
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../../editor/themes/default/default.css" />
<script type="text/javascript" src="../../Include/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../../include/jquery.validator.js"></script>
<script charset="utf-8" src="../../editor/kindeditor.js"></script>
<script charset="utf-8" src="../../editor/lang/zh_CN.js"></script>
<script>
var editor;
KindEditor.ready(function(K) {
	editor = K.create('textarea[name="content"]', {
		
		items : [
			'quickformat', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
			'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
			'insertunorderedlist', '|', 'emoticons', 'image', 'link']
	});
});

$(function(){
    $("#myform").checkForm({msg:'是否确认提交？'}); 
});
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" background="../images/tab_05.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="30"><img src="../images/tab_03.gif" width="12" height="30" /></td>
        <td><img src="../images/tb.gif" width="16" height="16" align="absmiddle" />&nbsp;你当前的位置：发送消息</td>
        <td align="right">&nbsp;</td>
        <td width="16"><img src="../images/tab_07.gif" width="16" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" background="../images/tab_15.gif">&nbsp;</td>
        <td><form name="form1" method="post" action="usermsg_send.php" onSubmit="return chkform()">
          <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#b0c4de">
            <tr>
              <td width="12%" height="25" align="right" bgcolor="#FFFFFF">发送人：</td>
              <td width="88%" align="center" bgcolor="#FFFFFF"><?php echo getUserName($_SESSION['userid']) ?></td>
            </tr>
            
            <tr>
              <td height="25" align="right" bgcolor="#FFFFFF">接收人：</td>
              <td align="center" bgcolor="#FFFFFF"><?php echo getUserName($userid) ?></td>
            </tr>
            <tr>
              <td height="25" align="right" bgcolor="#FFFFFF">标题：</td>
              <td bgcolor="#FFFFFF"><input name="title" type="text" id="title" style="width:90%" datatype="Require" msg="必填"/></td>
            </tr>
            <tr>
              <td height="25" align="right" bgcolor="#FFFFFF">内容：</td>
              <td bgcolor="#FFFFFF"><textarea name="content" id="content" style="width:95%;height:220px;"></textarea></td>
            </tr>
            <tr>
              <td height="30" align="right" bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF"><input name="button" type="submit" class="btn" id="button" value=" 提交 ">
                &nbsp;&nbsp;
                <input name="Action" type="hidden" id="Action" value="Send">
                <input type="hidden" name="userid" id="userid" value="<?php echo $userid ?>"/></td>
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