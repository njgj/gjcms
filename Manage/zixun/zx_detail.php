<?php
require('../global.php');
//赋值
$id=(int)$_GET['id'];

if(!empty($id)){
	if($_POST['Action']=='edit'){
		$db->query("update g_zixun set reply='".$_POST['content']."',states=2 where id=$id");
		htmlendjs("回复成功！","open");
	}	
	
    $query=$db->query("select * from g_zixun where id=$id");
    if($row= $db -> fetch_array($query)){
    $userid=$row['userid'];
	$touserid=$row['touserid'];
	$classid=$row['classid'];
	$title=$row['title'];
	$content=$row['content'];
	$realname=$row['realname'];
	$tel=$row['tel'];
	$mobile=$row['mobile'];
	$fax=$row['fax'];
	$company=$row['company'];
	$address=$row['address'];
	$postcode=$row['postcode'];
	$email=$row['email'];
	$reply=$row['reply'];
	$ip=$row['ip'];
	$states=$row['states'];
	$addtime=$row['addtime'];
    }
	
	if($_SESSION['userid']==$touserid) {
	    $db->query("update g_zixun set states=1 where states=0 and id=$id");
	}
 	if($_SESSION['userid']==$userid) {
	    $db->query("update g_zixun set states=3 where states=2 and id=$id");
	}   
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线咨询</title>
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../../editor/themes/default/default.css" />
<script charset="utf-8" src="../../editor/kindeditor.js"></script>
<script charset="utf-8" src="../../editor/lang/zh_CN.js"></script>
<script>
var editor;
KindEditor.ready(function(K) {
	editor = K.create('textarea[name="content"]', {
		allowFileManager : false,
		items : [
			'quickformat', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
			'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
			'insertunorderedlist', '|', 'emoticons', 'image', 'link', 'unlink']
	});
});

function chkform(){
	if (editor.text()==""){
		alert("内容不能为空！");
		return false;
	}
	return true;
}
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" background="../images/tab_05.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="30"><img src="../images/tab_03.gif" width="12" height="30" /></td>
        <td><img src="../images/tb.gif" width="16" height="16" align="absmiddle" />&nbsp;你当前的位置：在线咨询</td>
        <td align="right">&nbsp;</td>
        <td width="16"><img src="../images/tab_07.gif" width="16" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" background="../images/tab_12.gif">&nbsp;</td>
        <td><form id="form1" name="form1" method="post" action="zx_detail.php?id=<?php echo $id; ?>" onSubmit="return chkform()">
          <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#DEF2FF" style="table-layout:fixed; word-break:break-all">
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">主题</td>
              <td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;<?php echo $title ?></td>
              </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">类别</td>
              <td align="center" bgcolor="#FFFFFF"><?php echo getClassName("g_nclass_zx",$classid) ?></td>
              <td align="center" bgcolor="#FFFFFF">发送者</td>
              <td align="center" bgcolor="#FFFFFF"><a href="javascript:void(0);" onClick="newwin('../user/user_detail.php?userid=<?php echo $userid ?>',500,480)"><?php echo getUserName($userid) ?></a></td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">姓名</td>
              <td align="center" bgcolor="#FFFFFF"><?php echo $realname ?></td>
              <td align="center" bgcolor="#FFFFFF">接收者</td>
              <td align="center" bgcolor="#FFFFFF"><?php echo getUserName($touserid) ?></td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">电话</td>
              <td align="center" bgcolor="#FFFFFF"><?php echo $tel ?></td>
              <td align="center" bgcolor="#FFFFFF">手机</td>
              <td align="center" bgcolor="#FFFFFF"><?php echo $mobile ?></td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">单位</td>
              <td align="center" bgcolor="#FFFFFF"><?php echo $company ?></td>
              <td align="center" bgcolor="#FFFFFF">传真</td>
              <td align="center" bgcolor="#FFFFFF"><?php echo $fax ?></td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">地址</td>
              <td align="center" bgcolor="#FFFFFF"><?php echo $address ?></td>
              <td align="center" bgcolor="#FFFFFF">邮编</td>
              <td align="center" bgcolor="#FFFFFF"><?php echo $postcode ?></td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">E-mail</td>
              <td align="center" bgcolor="#FFFFFF"><?php echo $email ?></td>
              <td align="center" bgcolor="#FFFFFF">时间</td>
              <td align="center" bgcolor="#FFFFFF"><?php echo $addtime ?></td>
            </tr>
            
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">内容</td>
              <td colspan="3" bgcolor="#FFFFFF"><?php echo $content ?></td>
              </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">回复</td>
              <td colspan="3" bgcolor="#FFFFFF"><?php echo $reply ?></td>
              </tr>
            <?php if($_SESSION['userid']==$touserid){ ?>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">回复</td>
              <td colspan="3" bgcolor="#FFFFFF"><textarea name="content" style="width:500px;height:200px;"><?php echo $reply ?></textarea></td>
              </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">&nbsp;</td>
              <td colspan="3" bgcolor="#FFFFFF"><input type="submit" name="button" id="button" value="提交">
                <input name="Action" type="hidden" id="Action" value="edit"></td>
              </tr>
            <?php } ?>
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




