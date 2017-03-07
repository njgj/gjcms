<?php
require('../global.php');
chk_admin('1');

$Action=$_GET['Action'];
$key=$_GET['key'];
$groupid=$_GET['groupid'];

if($Action=='chk'){
	$db->query("update g_user_info set states=$_GET[states] where userid=$_GET[userid]");
	htmlendjs("操作成功","open");
}
if($Action=='del'){
	$db->query("DELETE FROM g_user_info WHERE userid =$_GET[userid] LIMIT 1");
	htmlendjs("删除成功","open");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE>后台管理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="../css/css.css" type=text/css rel=stylesheet>
<?php echo openwin("false"); ?>
</HEAD>
<BODY>
<form id="form1" name="form1" method="get" action="">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="30"><img src="../images/tab_03.gif" width="12" height="30" /></td>
        <td width="115" background="../images/tab_05.gif"><img src="../images/tb.gif" width="16" height="16" /><span class="title">用户管理</span></td>
        <td align="right" background="../images/tab_05.gif">
           <img src="../images/add.gif" width="14" height="14" />&nbsp;<a href="javascript:void(0);" onclick="newwin('user_add.php',620,360);">新增用户</a>
        </td>
        <td width="16"><img src="../images/tab_07.gif" width="16" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" background="../images/tab_12.gif">&nbsp;</td>
        <td bgcolor="#FFFFFF"><table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#b0c4de">
          <tr>
            <td height="30" align="center"><span class="STYLE1">用户名</span></td>
            <td height="30"><input type="text" name="key" id="key" /></td>
            <td height="30" align="center">类别</td>
            <td height="30"><select name="groupid">
              <option value="">- 不限类别 -</option>
                <?php
                $sql = "select * from g_user_group order by orderid";
                $query = $db -> query($sql);
                while($row = $db -> fetch_array($query)){
                    echo "<option value='$row[groupid]'>$row[groupname]</option>";
                }
            ?>
            </select></td>
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
        <td align="center" background="../images/tab_19.gif"><input type="submit" value="查询" /></td>
        <td width="16"><img src="../images/tab_20.gif" width="16" height="35" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#b0c4de">
  <tr>
    <td width="8%" height="26" align="center" background="../images/bg.gif" class="STYLE1">ID</td>
    <td width="22%" height="26" align="center" background="../images/bg.gif" class="STYLE1">用户名</td>
    <td width="20%" height="26" align="center" background="../images/bg.gif" class="STYLE1">用户组</td>
    <td width="18%" height="26" align="center" background="../images/bg.gif" class="STYLE1">最后一次登录时间</td>
    <td width="12%" align="center" background="../images/bg.gif" class="STYLE1">当前状态</td>
    <td width="20%" height="26" align="center" background="../images/bg.gif" class="STYLE1">操作</td>
  </tr>
  <?php
            
			$sql="select * from g_user_info where userid>0";
			$sql.=($key)?" and username like '%$key%'":"";
			$sql.=($groupid)?" and groupid=$groupid":"";
				
			$total = $db->num_rows($db->query($sql));
			
			TurnPage($total, $pagesize,"&key=$key&groupid=$groupid");
			$sql.=" order by userid desc limit $offset,$pagesize";
			//echo $sql;exit();
			
			$query = $db->query($sql);
			while ($row = $db->fetch_array($query)) { 
			?>
  <tr bgcolor="#FFFFFF" onmousemove="this.style.backgroundColor='#F0F8FF'" onmouseout="this.style.backgroundColor='#FFFFFF'">
    <td height="22" align="center"><?php echo $row['userid'] ?></td>
    <td height="22" align="center"><a href="javascript:void(0);" onclick="newwin('user_info.php?userid=<?php echo $row['userid'] ?>',620,360);"><?php echo $row['username']?></a></td>
    <td height="22" align="center"><?php echo getGroupName($row['groupid']) ?></td>
    <td height="22" align="center"><?php echo $row['lastlogintime']?></td>
    <td align="center"><?php echo chkState($row['states']) ?></td>
    <td height="22" align="center"><img src="../images/write.gif" width="9" height="9" />[<a href="javascript:void(0);" onclick="newwin('user_add.php?userid=<?php echo $row['userid'] ?>',620,360);">编辑</a>] <img src="../images/del.gif" width="9" height="9" /> [<a href="javascript:void(0);" onclick="return confirm('删除《<?php echo $row['username'] ?>》，是否确定？')?newwin('?Action=del&amp;userid=<?php echo $row['userid']?>',1,1):false">删除</a>]
      <select name="states" onchange="newwin('?Action=chk&amp;userid=<?php echo $row['userid']?>&amp;states='+this.options[selectedIndex].value,1,1);">
        <option selected="selected">-审核-</option>
        <option value="1">已审核</option>
        <option value="0">未审核</option>
      </select></td>
  </tr>
  <?php } ?>
</table>
<p class="fenye"><?php echo $pagenav;?></p>
</BODY>
</HTML>
