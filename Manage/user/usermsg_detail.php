<?php
require('../global.php');
$id=(int)$_GET['id'];

$db->query("update g_user_msg set islooked=1 where id=".$id);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线短消息</title>
<link href="../css/css.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30" background="../images/tab_05.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="30"><img src="../images/tab_03.gif" width="12" height="30" /></td>
        <td><img src="../images/tb.gif" width="16" height="16" align="absmiddle" />&nbsp;在线短消息</td>
        <td align="right">&nbsp;</td>
        <td width="16"><img src="../images/tab_07.gif" width="16" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" background="../images/tab_15.gif">&nbsp;</td>
        <td>
     <?php 
                $sql = "select * from g_user_msg where id=".$id;
                $query = $db -> query($sql);
                if($row = $db -> fetch_array($query)){
	 ?>   
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#b0c4de">
          <tr>
            <td width="18%" height="25" align="center" bgcolor="#FFFFFF">标题</td>
            <td width="82%" bgcolor="#FFFFFF"><?php echo $row['title'] ?></td>
          </tr>
          <tr>
            <td height="25" align="center" bgcolor="#FFFFFF">发送人</td>
            <td bgcolor="#FFFFFF"><a href="usermsg_send.asp?userid=<?php echo $row['fromuserid'] ?>"><?php echo getusername($row['fromuserid']); ?></a></td>
          </tr>
          <tr>
            <td height="25" align="center" bgcolor="#FFFFFF">接收人</td>
            <td bgcolor="#FFFFFF"><?php echo getusername($row['touserid']); ?></td>
          </tr>
          <tr>
            <td height="25" align="center" bgcolor="#FFFFFF">发送时间</td>
            <td bgcolor="#FFFFFF"><?php echo $row['addtime'] ?></td>
          </tr>
          <tr>
            <td height="25" align="center" bgcolor="#FFFFFF">内容</td>
            <td height="100" bgcolor="#FFFFFF" class="content"><?php echo $row['content'] ?></td>
          </tr>
        </table>
<?php 
}
?>
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