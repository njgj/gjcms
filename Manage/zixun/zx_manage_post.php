<?php
require('../global.php');

$Action=$_GET['Action'];
$id=(int)$_GET['id'];
$states=(int)$_GET['states'];
$classid=(int)$_GET['classid'];
$title=trim($_GET['title']);
$tousername=trim($_GET['tousername']);

if($Action=='del' && chk_user('g_zixun',$id)){	
	$db->query("DELETE FROM g_zixun WHERE id =$id LIMIT 1");
	htmlendjs("删除成功","open");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>咨询管理</title>
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<?php echo openwin("false") ?>
</head>

<body>
<form id="form1" name="form1" method="get" action="zx_manage_post.php">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="30" background="../images/tab_05.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="12" height="30"><img src="../images/tab_03.gif" width="12" height="30" /></td>
            <td width="838"><img src="../images/tb.gif" width="16" height="16" align="absmiddle" />&nbsp;你当前的位置：我发出的咨询</td>
            <td width="219" align="right"><img src="../images/22.gif" width="14" height="14" align="absmiddle" />&nbsp;<a href="javascript:void(0);" onClick="newdialog('在线咨询','zx_add.php',760,480)">我要咨询</a>
</td>
            <td width="16"><img src="../images/tab_07.gif" width="16" height="30" /></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="8" background="../images/tab_12.gif">&nbsp;</td>
            <td><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CDEAFB">
                <tr>
                  <td height="25" align="center" bgcolor="#FFFFFF">主题</td>
                  <td bgcolor="#FFFFFF"><input type="text" name="title" id="title" /></td>
                  <td align="center" bgcolor="#FFFFFF">咨询类别</td>
                  <td bgcolor="#FFFFFF">
                  <?php echo selectBox("g_nclass_zx","select","classid",0,$classid) ?>&nbsp;</td>
                </tr>
                <tr>
                  <td width="9%" height="25" align="center" bgcolor="#FFFFFF">接收用户</td>
                  <td width="22%" bgcolor="#FFFFFF"><input type="text" name="tousername" id="tousername" /></td>
                  <td width="11%" align="center" bgcolor="#FFFFFF">状态</td>
                  <td width="23%" bgcolor="#FFFFFF"><select name="states" id="states">
                    <option value="">- 不限 -</option>
                    <option value="0">未查看</option>
                    <option value="1">已查看</option>
                    <option value="2">已回复</option>
                    <option value="3">已查看回复</option>
                  </select></td>
                </tr>
            </table></td>
            <td width="8" background="../images/tab_15.gif">&nbsp;</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="35" background="../images/tab_19.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="12" height="35"><img src="../images/tab_18.gif" width="12" height="35" /></td>
            <td align="center"><input type="submit" value="查 询" /></td>
            <td width="16"><img src="../images/tab_20.gif" width="16" height="35" /></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#b5d6e6">
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#c1ebff'"  onmouseout="this.style.backgroundColor='#FFFFFF'">
    <td height="22" align="center" background="../images/bg.gif" bgcolor="#FFFFFF">ID</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">主题</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">类别</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">接收用户</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">更新时间</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">当前状态</td>
    <td height="22" align="center" background="../images/bg.gif" bgcolor="#FFFFFF">基本操作</td>
  </tr>
  <?php
			$sql="select * from g_zixun where userid=".$_SESSION['userid'];
			$sql.=($tousername)?" and touserid in(select userid from g_user_info where username like '%$tousername%')":"";
			$sql.=($title)?" and title like '%$title%'":"";
			$sql.=($states)?" and states=$states":"";
			$sql.=($classid)?" and classid=$classid":"";
				
			$total = $db->num_rows($db->query($sql));
			
			turnpage($total, $pagesize);
			$sql.=" order by id desc limit $offset,$pagesize";
			//echo $sql;
			
			$query = $db->query($sql);
			while ($row = $db->fetch_array($query)) {   
  ?>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#c1ebff'"  onmouseout="this.style.backgroundColor='#FFFFFF'">
    <td height="20" align="center"><?php echo $row['id'] ?></td>
    <td align="center"><a href="javascript:void(0);" onClick="newwin('zx_detail.php?id=<?php echo $row['id'] ?>',760,480)"><?php echo $row['title'] ?></a></td>
    <td align="center"><?php echo getClassName("g_nclass_zx",$row['classid']) ?></td>
    <td align="center"><a href="javascript:void(0);" onClick="newwin('../user/user_detail.php?userid=<?php echo $row['touserid'] ?>',500,480)"><?php echo getUserName($row['touserid']) ?></a></td>
    <td align="center"><?php echo $row['addtime'] ?></td>
    <td align="center"><?php echo chkZxState($row['states']) ?></td>
    <td height="20" align="center"><img src="../Images/see.gif" width="10" height="10" /><a href="javascript:void(0);" onClick="newwin('zx_detail.php?id=<?php echo $row['id'] ?>',760,480)">查看</a>&nbsp;&nbsp;<img src="../images/edt.gif" width="16" height="16" /><a href="javascript:void(0);" onClick="newdialog('在线咨询','zx_add.php?id=<?php echo $row['id'] ?>',760,480)">编辑</a>&nbsp;&nbsp;<img src="../images/del.gif" width="16" height="16" /><a href="javascript:void(0);" onClick="return confirm('删除《<?php echo $row['title'] ?>》，是否确定？')?newwin('zx_manage.php?Action=del&id=<?php echo $row['id'] ?>',1,1):false">删除</a></td>
  </tr>
  <?php  
}
  ?>
</table>
<p class="fenye"><?php echo $pagenav;?></p>
</body>
</html>