<?php
require('../global.php');
//参数
$touserid=(int)$_REQUEST["touserid"];
$id=(int)$_GET['id'];
$Action=$_POST['Action'];

$classid=(int)$_POST["classid"];
$title=trim($_POST["title"]);
$content=$_POST["content"];
$realname=trim($_POST["realname"]);
$tel=trim($_POST["tel"]);
$mobile=trim($_POST["mobile"]);
$fax=trim($_POST["fax"]);
$company=trim($_POST["company"]);
$address=trim($_POST["address"]);
$postcode=trim($_POST["postcode"]);
$email=trim($_POST["email"]);

//初始化
$act='add';

$touserid=(empty($touserid))?1:$touserid; //管理员
$classid=(empty($classid))?1:$classid; //在线咨询
function init(){
global $title,$content,$realname,$mobile,$email;
if($_POST['checkcode']!=$_SESSION['checkcode']){htmlendjs("验证码错误$_SESSION[checkcode]","");}
if(empty($title)){ htmlendjs("主题不能为空",""); }
if(empty($content)){ htmlendjs("内容不能为空",""); }
if(empty($realname)){ htmlendjs("姓名不能为空",""); }
if(empty($mobile)){ htmlendjs("手机不能为空",""); }
if(empty($email)){ htmlendjs("邮箱不能为空",""); }
}

//操作
if($Action=='add'){
    init();
    $db->query("INSERT INTO g_zixun(userid,touserid,classid,title,content,realname,tel,mobile,fax,company,address,postcode,email,ip,states,addtime) VALUES($_SESSION[userid],$touserid,$classid,'$title','$content','$realname','$tel','$mobile','$fax','$company','$address','$postcode','$email','$_SERVER[REMOTE_ADDR]',0,now())");	
    htmlendjs('添加成功','dialog-open');
}
if($Action=='edit'){
    init();
    $db->query("update g_zixun set classid=$classid,title='$title',content='$content',realname='$realname',tel='$tel',mobile='$mobile',fax='$fax',company='$company',address='$address',postcode='$postcode',email='$email',addtime=now() where id=$id");	
    htmlendjs('修改成功','dialog-open');
}
//赋值
if(!empty($id)){
    $query=$db->query("select * from g_zixun where id=$id");
    $row = $db -> fetch_array($query);
    if($row){
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
    $act='edit';
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
<script type="text/javascript" src="../../Include/validator.js"></script>
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
	if (Validator.Validate(form1,3)==false){
		return false;
	}
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
        <td><img src="../images/tb.gif" width="16" height="16" align="absmiddle" />&nbsp;你当前的位置：在线咨询(发送至<?php echo getUserName($touserid) ?>)</td>
        <td align="right">&nbsp;</td>
        <td width="16"><img src="../images/tab_07.gif" width="16" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" background="../images/tab_12.gif">&nbsp;</td>
        <td><form name="form1" method="post" action="zx_add.php?id=<?php echo $id ?>" onSubmit="return chkform()">
          <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#DEF2FF">
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF" width="80">主题</td>
              <td colspan="3" bgcolor="#FFFFFF">
			  <?php echo selectBox("g_nclass_zx","select","classid",0,$classid) ?><input name="title" type="text" id="title" size="60" datatype="Require" msg="主题不能为空" value="<?php echo $title ?>" /></td>
              </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">姓名</td>
              <td bgcolor="#FFFFFF"><input type="text" name="realname" id="realname"  datatype="Require" msg="必填" value="<?php echo $realname ?>"/></td>
              <td align="center" bgcolor="#FFFFFF" width="80">电话</td>
              <td bgcolor="#FFFFFF"><input type="text" name="tel" id="tel" value="<?php echo $tel ?>"/></td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">手机</td>
              <td bgcolor="#FFFFFF"><input type="text" name="mobile" id="mobile" datatype="Require" msg="必填"  value="<?php echo $mobile ?>"/></td>
              <td align="center" bgcolor="#FFFFFF">传真</td>
              <td bgcolor="#FFFFFF"><input type="text" name="fax" id="fax" value="<?php echo $fax ?>"/></td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">单位</td>
              <td bgcolor="#FFFFFF"><input type="text" name="company" id="company"   value="<?php echo $company ?>"/></td>
              <td align="center" bgcolor="#FFFFFF">邮编</td>
              <td bgcolor="#FFFFFF"><input type="text" name="postcode" id="postcode"  value="<?php echo $postcode ?>"/></td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">地址</td>
              <td bgcolor="#FFFFFF"><input type="text" name="address" id="address"  value="<?php echo $address ?>"/></td>
              <td align="center" bgcolor="#FFFFFF">E-mail</td>
              <td bgcolor="#FFFFFF"><input type="text" name="email" id="email" datatype="Email" msg="E-mail格式错误"  value="<?php echo $email ?>"/></td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">内容</td>
              <td colspan="3" bgcolor="#FFFFFF"><textarea name="content" style="width:500px;height:200px;"><?php echo $content ?></textarea></td>
              </tr>
            <tr>
              <td height="25" align="center" bgcolor="#FFFFFF">验证码</td>
              <td colspan="3" bgcolor="#FFFFFF"><input name="checkcode" type="text" id="checkcode" datatype="Require"  msg="请输入验证码" />
                <img id="imgcode" src="../../Include/checkcode.php" onclick="this.src='../../include/checkcode.php?tmp='+(new Date().getTime());"/>(点击图片更换)</td>
            </tr>
            <tr>
              <td height="30" colspan="4" align="center" bgcolor="#FFFFFF"><input name="button" type="submit" class="btn" id="button" value=" 提 交 ">
                <input type="hidden" name="touserid" id="touserid" value="<?php echo $touserid ?>"/>
                <input type="hidden" name="Action" id="Action" value="<?php echo $act; ?>"/></td>
              </tr>
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
        <td class="t6"> <img src="../images/sound_16x16.gif" width="16" height="16" align="absmiddle" />本站将自动记录IP地址等信息，请注意您的言行要符合国家相关政策，并自觉承担法律后果。</td>
        <td width="16"><img src="../images/tab_20.gif" width="16" height="35" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>




