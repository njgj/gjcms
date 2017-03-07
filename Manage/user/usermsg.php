<?php
require('../global.php');

$Action=$_GET['Action'];
$tid=(int)$_GET['tid'];
$title=$_GET['title'];

if($Action=='del'){
	$db->query("DELETE FROM g_user_msg WHERE id =$_GET[id] LIMIT 1");
	htmlendjs("删除成功","open");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>个人消息</title>
<link href="../css/css.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="get" action="usermsg.php">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="30" background="../images/tab_05.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="12" height="30"><img src="../images/tab_03.gif" width="12" height="30" /></td>
            <td><img src="../images/tb.gif" width="16" height="16" align="absmiddle" />&nbsp;你当前的位置：个人消息</td>
            <td align="right">&nbsp;</td>
            <td width="16"><img src="../images/tab_07.gif" width="16" height="30" /></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="9" background="../images/tab_12.gif">&nbsp;</td>
            <td align="center"><select name="tid" id="tid">
              <option value="0" <?php echo ($tid==0)?'selected':'' ?>>我收到的消息</option>
              <option value="1" <?php echo ($tid==1)?'selected':'' ?>>我发出的消息</option>
            </select>
              <input name="title" type="text" id="title" size="30" /></td>
            <td width="8" background="../images/tab_15.gif">&nbsp;</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="35" background="../images/tab_19.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="12" height="35"><img src="../images/tab_18.gif" width="12" height="35" /></td>
            <td align="center">&nbsp;&nbsp;
            <input type="submit" value="查询" /></td>
            <td width="16"><img src="../images/tab_20.gif" width="16" height="35" /></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#b0c4de">
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#c1ebff'"  onmouseout="this.style.backgroundColor='#FFFFFF'">
    <td width="5%" height="22" align="center" background="../images/bg.gif" bgcolor="#FFFFFF">ID</td>
    <td width="36%" height="22" align="center" background="../images/bg.gif" bgcolor="#FFFFFF">信息标题</td>
    <td width="14%" height="22" align="center" background="../images/bg.gif" bgcolor="#FFFFFF">发送人</td>
    <td width="17%" align="center" background="../images/bg.gif" bgcolor="#FFFFFF">创建时间</td>
    <td width="10%" height="22" align="center" background="../images/bg.gif" bgcolor="#FFFFFF">状态</td>
    <td width="18%" height="22" align="center" background="../images/bg.gif" bgcolor="#FFFFFF">操作</td>
  </tr>
          	<?php
            
			$sql="select * from g_user_msg where id>0";
			$sql.=($tid==0)?' and touserid='.$_SESSION['userid']:'';
			$sql.=($tid==1)?' and fromuserid='.$_SESSION['userid']:'';
			$sql.=($title)?" and title like '%$title%'":"";
				
			$total = $db->num_rows($db->query($sql));
			
			TurnPage($total, $pagesize);
			$sql.=" order by addtime desc,id desc limit $offset,$pagesize";
			//echo $sql;exit();
			
			$query = $db->query($sql);
			while ($row = $db->fetch_array($query)) { 
			?>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#c1ebff'"  onmouseout="this.style.backgroundColor='#FFFFFF'">
    <td height="20" align="center"><?php echo $row['id'] ?></td>
    <td height="20"><a href="javascript:void(0);" onClick="newwin('usermsg_detail.asp?id=<?php echo $row['id'] ?>',500,280)"><?php echo $row['title'] ?></a>&nbsp;</td>
    <td height="20" align="center"><?php echo getUserName($row['fromuserid']) ?></td>
    <td height="20" align="center"><?php echo $row['addtime'] ?></td>
    <td height="20" align="center"><?php
	if($row['islooked']==0){
	    echo "<font color=red>未查看</font>";
	}elseif($row['islooked']==1){
	    echo "<font color=blue>已查看</font>";
	}
	?></td>
    <td height="20" align="center">&nbsp;<img src="../images/del.gif"/><a href="javascript:void(0);" onClick="return confirm('删除《<?php echo $row['title'] ?>》，是否确定？')?newwin('usermsg_del.asp?Action=del&id=<?php echo $row['id'] ?>',1,1):false">删除</a>&nbsp;&nbsp;</td>
  </tr>
<?php } ?>
</table>
<p class="fenye"><?php echo $pagenav;?></p>
</body>
</html>
