<?php 
require('global.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线短消息</title>
<link href="css/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../include/jquery-1.8.3.min.js"></script>    
<script type="text/javascript">    
$(document).ready(function(){ 
    $("#user_list").load("user_online_ajax.php?timeStamp="+new Date().getTime());
	$("#groupid").change(function(){
	    ajaxLoad();
	});
	setInterval("ajaxLoad()",1000*8);
}) 
function ajaxLoad(){
	$("#user_list").load("user_online_ajax.php?timeStamp="+new Date().getTime()+"&groupid="+$("#groupid").val());
}
</script>
<?php echo openwin("false"); ?>
</head>

<body>
<table width="180" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30" background="images/tab_05.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" height="30"><img src="images/tab_03.gif" width="12" height="30" /></td>
        <td><img src="images/tb.gif" width="16" height="16" align="absmiddle" />&nbsp;在线短消息</td>
        <td width="14"><img src="images/tab_07.gif" width="16" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="9" background="images/tab_12.gif">&nbsp;</td>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><select name="groupid" id="groupid"  style="text-align:center;width:100%;">
      <option value="">在线用户</option>      
     <?php  
    $sql="select * from g_user_group order by orderid";
    $query=$db -> query($sql);
	while($row = $db -> fetch_array($query)){
    ?>     
      <option value="<?php echo $row['groupid'] ?>"><?php echo $row['groupname'] ?></option>
      <?php 
	}
	  ?>
      </select></td>
          </tr>
          <tr>
            <td height="200" align="center" id="user_list">&nbsp;</td>
          </tr>
          
        </table></td>
        <td width="8" background="images/tab_15.gif">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="35" background="images/tab_19.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12"><img src="images/tab_18.gif" width="12" height="35" /></td>
        <td background="images/tab_19.gif">&nbsp;</td>
        <td width="16"><img src="images/tab_20.gif" width="16" height="35" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>