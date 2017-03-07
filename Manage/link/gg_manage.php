<?php
require('../global.php');
//管理
$Action=$_GET['Action'];
$id=(int)$_GET['id'];
$states=(int)$_GET['states'];
$classid=(int)$_GET['classid'];
$xgid=(int)$_GET['xgid'];
$posid=(int)$_GET['posid'];
$ggname=trim($_GET['ggname']);
$username=trim($_GET['username']);

if($Action=='chk' && chk_user('g_gg',$id)){
	$db->query("update g_gg set states=$states where id=$id");
	htmlendjs("操作成功","open");
}
if($Action=='del' && chk_user('g_gg',$id)){	
	$db->query("DELETE FROM g_gg WHERE id =$id LIMIT 1");
	htmlendjs("删除成功","open");
}
if($Action=='order' && chk_user('g_gg',$id)){	
	$db->query("update g_gg set orderid=$_POST[orderid] where id=$id");
	htmlendjs("排序成功","open");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广告管理</title>
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<?php echo openwin("false"); ?>
</head>

<body>
<form id="form1" name="form1" method="get" action="gg_manage.php">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="30" background="../images/tab_05.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="12" height="30"><img src="../images/tab_03.gif" width="12" height="30" /></td>
            <td width="838"><img src="../images/tb.gif" width="16" height="16" align="absmiddle" />&nbsp;你当前的位置：广告管理</td>
            <td width="219" align="right"><a href="javascript:void(0);" onClick="newdialog('发布广告','gg_add.php',660,500)"><img src="../Images/see.gif" width="16" height="16" align="absmiddle" />发布广告</a></td>
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
                  <td align="center" bgcolor="#FFFFFF">广告名称</td>
                  <td bgcolor="#FFFFFF"><input type="text" name="ggname" id="ggname" /></td>
                  <td height="25" align="center" bgcolor="#FFFFFF">广告类型</td>
                  <td bgcolor="#FFFFFF"><?php echo selectBox("g_nclass_link","select","classid",3,$classid) ?>&nbsp;</td>
                  <td align="center" bgcolor="#FFFFFF">广告效果</td>
                  <td bgcolor="#FFFFFF"><?php echo selectBox("g_nclass_link","select","xgid",4,$xgid) ?>&nbsp;</td>
                </tr>
                <tr>
                  <td height="25" align="center" bgcolor="#FFFFFF">用户名</td>
                  <td bgcolor="#FFFFFF"><input type="text" name="username" id="username" /></td>
                  <td align="center" bgcolor="#FFFFFF">广告位置</td>
                  <td bgcolor="#FFFFFF"><select name="posid">
                <option value="">- 不限 -</option>
                <?php
                $class_arr=getClassArray('g_nclass_link');
                echo tree($class_arr,5);
            ?>
              </select></td>
                  <td align="center" bgcolor="#FFFFFF">审核状态</td>
                  <td bgcolor="#FFFFFF"><select name="states" id="states">
                    <option value="">- 不限 -</option>
                    <option value="0">未审核</option>
                    <option value="1">已审核</option>
                    <option value="2">已推荐</option>
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
            <td align="center"><input type="submit" value="查 询" />

            &nbsp;&nbsp;&nbsp;
            <input type="reset" value="重 置" /></td>
            <td width="16"><img src="../images/tab_20.gif" width="16" height="35" /></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#b5d6e6">
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#c1ebff'"  onmouseout="this.style.backgroundColor='#FFFFFF'">
    <td height="22" align="center" background="../images/bg.gif" bgcolor="#FFFFFF">ID</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">广告名称</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">广告类型</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">广告位置</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">广告效果</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">点击率</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">备注</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">更新时间</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">用户名</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">当前状态</td>
    <td align="center" background="../images/bg.gif" bgcolor="#FFFFFF">排序</td>
    <td height="22" align="center" background="../images/bg.gif" bgcolor="#FFFFFF">基本操作</td>
  </tr>
  <?php
            
			$sql="select * from g_gg where id>0";
			$sql.=($ggname)?" and ggname like '%$ggname%'":"";
			$sql.=($username)?" and userid in(select userid from g_user_info where username like '%$username%')":"";
			$sql.=($xgid)?" and xgid=$xgid":"";
			$sql.=($posid)?" and posid=$xgid":"";
			$sql.=($states)?" and states=$states":"";
			$sql.=($classid)?" and classid in (select classid from g_nclass_link where locate(',$classid,',classpath)>0)":'';
				
			$total = $db->num_rows($db->query($sql));
			
			turnpage($total, $pagesize);
			$sql.=" order by id desc limit $offset,$pagesize";
			//echo $sql;
			
			$query = $db->query($sql);
			while ($row = $db->fetch_array($query)) { 
			?>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#c1ebff'"  onmouseout="this.style.backgroundColor='#FFFFFF'">
    <td height="20" align="center"><?php echo $row['id'] ?></td>
    <td align="center"><a href="javascript:void(0);" onClick="newwin('gg_detail.php?id=<?php echo $row['id'] ?>',660,420)"><?php echo $row['ggname'] ?></a></td>
    <td align="center"><?php echo getClassName("g_nclass_link",$row['classid']) ?></td>
    <td align="center"><?php echo getClassName("g_nclass_link",$row['posid']) ?></td>
    <td align="center"><?php echo getClassName("g_nclass_link",$row['xgid']) ?></td>
    <td align="center"><?php echo $row['hits'] ?></td>
    <td align="center" title="<?php echo $row['remark'] ?>"><?php echo gottopic($row['remark'],30) ?></td>
    <td align="center"><?php echo $row['addtime'] ?></td>
    <td align="center"><?php echo getUserName($row['userid']) ?></td>
    <td align="center"><?php echo chkState($row['states']) ?></td>
    <td align="center"><form action="gg_manage.php?Action=order&id=<?php echo $row['id'] ?>" method="post" target="_blank"><input type="text"  name="orderid" size="4" value="<?php echo $row['orderid'] ?>"/><input type="submit" value="更改"/></form></td>
    <td height="20" align="center"><img src="../images/edt.gif" width="16" height="16" /><a href="javascript:void(0);" onClick="newdialog('修改广告','gg_add.php?id=<?php echo $row['id'] ?>',660,500)">编辑</a>&nbsp;&nbsp;<img src="../images/del.gif" width="16" height="16" /><a href="javascript:void(0);" onClick="return confirm('删除《<?php echo $row['ggname'] ?>》，是否确定？')?newwin('gg_manage.php?Action=del&id=<?php echo $row['id'] ?>',1,1):false">删除</a><select name="states" onchange="newwin('?Action=chk&amp;id=<?php echo $row['id']?>&amp;states='+this.options[selectedIndex].value,1,1);">
        <option selected="selected">-审核-</option>
        <option value="1">已审核</option>
        <option value="2">已置顶</option>
        <option value="0">未审核</option>
      </select></td>
  </tr>
  <?php } ?>
</table>
<p class="fenye"><?php echo $pagenav;?></p>
</body>
</html>
