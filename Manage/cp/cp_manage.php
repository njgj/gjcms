<?php
require('../global.php');
//管理
$Action=$_GET['Action'];
$id=(int)$_GET['id'];
$states=(int)$_GET['states'];
$classid=(int)$_GET['classid'];
$key=trim($_GET['key']);

if($Action=='chk'){
	$db->query("update g_cp set states=$states where id=$id");
	htmlendjs("操作成功","open");
}
if($Action=='del'){	
	$db->query("DELETE FROM g_cp WHERE id =$id LIMIT 1");
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
        <td width="115" background="../images/tab_05.gif"><img src="../images/tb.gif" width="16" height="16" /><span class="title">产品管理</span></td>
        <td align="right" background="../images/tab_05.gif">&nbsp;</td>
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
            <td height="30" align="center"><span class="STYLE1">产品名称</span></td>
            <td height="30"><input type="text" name="key" id="key" /></td>
            <td height="30" align="center">类别</td>
            <td height="30"><select name="classid">
              <option value="">- 不限类别 -</option>
              <?php
                $class_arr=getClassArray('g_nclass_cp');
                echo tree($class_arr,0);
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
    <td width="5%" height="26" align="center" background="../images/bg.gif" class="STYLE1">ID</td>
    <td width="34%" height="26" align="center" background="../images/bg.gif" class="STYLE1">产品名称</td>
    <td width="10%" height="26" align="center" background="../images/bg.gif" class="STYLE1">类别</td>
    <td width="11%" height="26" align="center" background="../images/bg.gif" class="STYLE1">厂家/品牌</td>
    <td width="12%" height="26" align="center" background="../images/bg.gif" class="STYLE1">时间</td>
    <td width="8%" align="center" background="../images/bg.gif" class="STYLE1">当前状态</td>
    <td width="20%" height="26" align="center" background="../images/bg.gif" class="STYLE1">操作</td>
  </tr>
  <?php
            
			$sql="select * from g_cp where id>0";
			$sql.=($key)?" and cpname like '%$key%'":"";
			$sql.=($classid)?" and classid in (select classid from g_nclass_cp where locate(',$classid,',classpath)>0)":'';
				
			$total = $db->num_rows($db->query($sql));
			
			turnpage($total, $pagesize);
			$sql.=" order by id desc limit $offset,$pagesize";
			//echo $sql;
			
			$query = $db->query($sql);
			while ($row = $db->fetch_array($query)) { 
			?>
  <tr bgcolor="#FFFFFF" onmousemove="this.style.backgroundColor='#F0F8FF'" onmouseout="this.style.backgroundColor='#FFFFFF'">
    <td height="22" align="center"><?php echo $row['id'] ?></td>
    <td height="22"><a href="../../cp_show.php?id=<?php echo $row[id]?>" target="_blank"><?php echo $row['cpname']?></a></td>
    <td height="22" align="center"><?php echo getclassname('g_nclass_cp',$row['classid']) ?></td>
    <td height="22" align="center"><?php echo $row['source']?></td>
    <td height="22" align="center"><?php echo $row['addtime']?></td>
    <td align="center"><?php echo chkState($row['states']) ?></td>
    <td height="22" align="center"><img src="../images/write.gif" width="9" height="9" />[<a href="javascript:;" onclick="newwin('cp_add.php?id=<?php echo $row['id']?>',800,500);">编辑</a>]&nbsp;&nbsp;<img src="../images/del.gif" width="9" height="9" /> [<a href="javascript:void(0);" onclick="return confirm('删除《<?php echo $row['cpname'] ?>》，是否确定？')?newwin('?Action=del&amp;id=<?php echo $row['id']?>',1,1):false">删除</a>]
      <select name="states" onchange="newwin('?Action=chk&amp;id=<?php echo $row['id']?>&amp;states='+this.options[selectedIndex].value,1,1);">
        <option selected="selected">-审核-</option>
        <option value="1">已审核</option>
        <option value="2">已置顶</option>
        <option value="0">未审核</option>
      </select></td>
  </tr>
  <?php } ?>
</table>
<p class="fenye"><?php echo $pagenav;?></p>
</BODY>
</HTML>