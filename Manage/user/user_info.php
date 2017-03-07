<?php
require('../global.php');
$userid=(int)$_GET['userid'];
if(empty($userid)){ htmlendjs("参数错误","close"); }

$sql = "select * from g_user_info where userid=$userid";
$query = $db -> query($sql);
if($row = $db -> fetch_array($query)){	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>详细信息</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="../css/css.css" type=text/css rel=stylesheet>
</HEAD>
<BODY>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="30"><img src="../images/tab_03.gif" width="12" height="30" /></td>
        <td background="../images/tab_05.gif"><img src="../images/tb.gif" width="16" height="16" /><span class="title">详细信息</span></td>
        <td width="16"><img src="../images/tab_07.gif" width="16" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" background="../images/tab_12.gif">&nbsp;</td>
        <td bgcolor="#FFFFFF"><table width="100%" border=1 cellpadding="2" cellspacing=0  bordercolor="#b0c4de">
          <tr>
            <td width="21%" height="24" align="center" bgcolor="#f1fafa">用户名</td>
            <td width="28%" height="24" align="center"><?php echo $row['username'] ?></td>
            <td width="20%" rowspan="5" align="center" bgcolor="#F1FAFA">头像</td>
            <td width="31%" rowspan="5" align="center"><img src="../../uploadfile/logo/<?php echo $row['imgurl']; ?>" onerror="this.src='../images/no_pic.gif'" id="img" height="90" onclick="window.open(this.src)" style="cursor:hand"/></td>
          </tr>
          <tr>
            <td height="24" align="center" bgcolor="#f1fafa">用户组</td>
            <td height="24" align="center"><?php echo getGroupName($row['groupid']) ?></td>
            </tr>

          <tr>
            <td height="24" align="center" bgcolor="#f1fafa">单位名称</td>
            <td height="24" align="center"><?php echo $row['company'] ?></td>
            </tr>
          <tr>
            <td height="24" align="center" bgcolor="#f1fafa">真实姓名</td>
            <td height="24" align="center"><?php echo $row['realname'] ?></td>
          </tr>
          <tr>
            <td height="24" align="center" bgcolor="#f1fafa">所在地区</td>
            <td height="24" align="center"><?php echo getClassName('g_nclass_city',$row['cityid']) ?></td>
            </tr>
          <tr>
            <td align="center" bgcolor="#f1fafa">电话</td>
            <td height="24" align="center"><?php echo $row['tel'] ?></td>
            <td align="center" bgcolor="#F1FAFA">手机</td>
            <td align="center"><?php echo $row['mobile'] ?></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#f1fafa">Email</td>
            <td height="24" align="center"><?php echo $row['email'] ?></td>
            <td align="center" bgcolor="#F1FAFA">QQ</td>
            <td align="center"><?php echo $row['qq'] ?></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#f1fafa">地址</td>
            <td height="24" align="center"><?php echo $row['address'] ?></td>
            <td align="center" bgcolor="#F1FAFA">网址</td>
            <td align="center"><?php echo $row['homepage'] ?></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#f1fafa">备注</td>
            <td height="24" colspan="3" align="center"><?php echo $row['remark'] ?></td>
            </tr>
          <tr>
            <td height="24" align="center" bgcolor="#f1fafa">最后一次登录时间</td>
            <td height="24" align="center"><?php echo $row['lastlogintime'] ?></td>
            <td align="center" bgcolor="#F1FAFA">最后一次登录IP</td>
            <td align="center"><?php echo $row['lastloginip'] ?></td>
          </tr>
          <tr>
            <td height="24" align="center" bgcolor="#f1fafa">登录次数</td>
            <td height="24" align="center"><?php echo $row['logintimes'] ?></td>
            <td align="center" bgcolor="#F1FAFA">是否在线</td>
            <td align="center"><?php echo chkIsYes($row['online']) ?></td>
          </tr>
          <tr>
            <td height="24" align="center" bgcolor="#f1fafa">添加时间</td>
            <td height="24" align="center"><?php echo $row['addtime'] ?></td>
            <td align="center" bgcolor="#F1FAFA">状态</td>
            <td align="center"><?php echo chkState($row['states']) ?></td>
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
</BODY>
</HTML>
<?php } ?>