<?php
require('../global.php');

if($_POST['add']){
	if(empty($_POST['olduserpwd'])){
		htmlendjs('原密码不能为空！','');
	}
	if(empty($_POST['userpwd'])){
		htmlendjs('新密码不能为空！','');
	}
	if($_POST['olduserpwd']==$_POST['userpwd']){
	    htmlendjs('新密码不能与原密码一样！','');
	}
	if(!$db->get_one("select * from g_user_info where userid='".$_SESSION['userid']."' and userpwd='".md5($_POST['olduserpwd'])."'")){
	    htmlendjs('原密码错误！','');
	}
    $db->query("update g_user_info set userpwd='".md5($_POST['userpwd'])."' where userid=".$_SESSION['userid']);	
	htmlendjs("密码修改成功","open");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>修改密码</TITLE>
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
<form action="user_pwd.php" method="post" id="myform">
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="30"><img src="../images/tab_03.gif" width="12" height="30" /></td>
        <td background="../images/tab_05.gif"><img src="../images/tb.gif" width="16" height="16" /><span class="title">修改密码</span></td>
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
            <td align="right">原密码:</td>
            <td><input type="password" name="olduserpwd" id="olduserpwd" datatype="Require" msg="原密码不能为空"/>            </td>
          </tr>
          <tr>
            <td align="right">新密码:</td>
            <td><input type="password" name="userpwd" id="userpwd" datatype="Limit" min=6 msg="新密码不能为空且至少6位"/>            </td>
          </tr>
          <tr>
            <td align="right">确认新密码:</td>
            <td><input type="password" name="userpwd2" id="userpwd2" datatype="Repeat" to="userpwd" msg="两次输入的密码不一致"/>            </td>
          </tr>
          <tr>
            <td colspan="2" align="center" height='30'><input name="add" type="submit" class="btn" value=" 确定 "/>            </td>
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

