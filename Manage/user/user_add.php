<?php
require('../global.php');
chk_admin('1');

//参数
$userid=(int)$_GET['userid'];
$Action=$_POST['Action'];
$cityid=(int)$_POST["cityid"];
$groupid=(int)$_POST["groupid"];
$username=trim($_POST["username"]);
$imgurl=trim($_POST["imgurl"]);
$company=trim($_POST["company"]);
$realname=trim($_POST["realname"]);
$tel=trim($_POST["tel"]);
$mobile=trim($_POST["mobile"]);
$email=trim($_POST["email"]);
$qq=trim($_POST["qq"]);
$address=trim($_POST["address"]);
$homepage=trim($_POST["homepage"]);
$remark=trim($_POST["remark"]);

//初始化
$act='add';
function init(){
global $username,$realname;
if(empty($username)){ htmlendjs("用户名不能为空",""); }

if(empty($realname)){ htmlendjs("真实姓名不能为空",""); }
}
//操作
if($Action=='add'){
    init();
	
	if($db->get_one("select username from g_user_info where username='$username'")){
	htmlendjs("用户名已存在","");
	}
	
    $db->query("INSERT INTO g_user_info(cityid,groupid,username,userpwd,imgurl,company,realname,tel,mobile,email,qq,address,homepage,remark,addtime,lastloginip,states) VALUES($cityid,$groupid,'$username','".md5('666666')."','$imgurl','$company','$realname','$tel','$mobile','$email','$qq','$address','$homepage','$remark',now(),'$_SERVER[REMOTE_ADDR]',0)");	
    htmlendjs('添加成功','open');
}
if($Action=='edit'){
    init();
	
	if($_POST['oldusername']!=$username){
		if($db->get_one("select username from g_user_info where username='$username'")){
		htmlendjs("用户名已存在","");
		}
	}
	
    $db->query("update g_user_info set cityid=$cityid,groupid=$groupid,username='$username',imgurl='$imgurl',company='$company',realname='$realname',tel='$tel',mobile='$mobile',email='$email',qq='$qq',address='$address',homepage='$homepage',remark='$remark',addtime=now() where userid=$userid");	
    htmlendjs('修改成功','open');
}
//赋值
if(!empty($userid)){
    $query=$db->query("select * from g_user_info where userid=$userid");
    if($row= $db -> fetch_array($query)){
$groupid=$row['groupid'];
$cityid=$row['cityid'];
$username=$row['username'];
$imgurl=$row['imgurl'];
$company=$row['company'];
$realname=$row['realname'];
$tel=$row['tel'];
$mobile=$row['mobile'];
$email=$row['email'];
$qq=$row['qq'];
$address=$row['address'];
$homepage=$row['homepage'];
$remark=$row['remark'];
    $act='edit';
    }
    
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>用户增改</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="../css/css.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="../../Include/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../../include/jquery.validator.js"></script>
<script>
$(function(){
    $("#myform").checkForm({msg:'是否确认提交？'}); 
	
	<?php if($groupid==3){ ?>
	$('#company').attr('datatype','Require');
	<?php }?>
	$('#groupid').change(function(){
	     var v=$(this).val();
		 //alert(v);
		 if(v==3){
		     $('#company').attr('datatype','Require');
		 }else{
		     $('#company').next('span').remove().end().removeAttr('datatype');
		 }
	});
});
</script>
</HEAD>
<BODY>
<form action="user_add.php?userid=<?php echo $userid; ?>" method="post" id="myform">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="30"><img src="../images/tab_03.gif" width="12" height="30" /></td>
        <td background="../images/tab_05.gif"><img src="../images/tb.gif" width="16" height="16" /><span class="title">用户增改</span></td>
        <td width="16"><img src="../images/tab_07.gif" width="16" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" background="../images/tab_12.gif">&nbsp;</td>
        <td height="150" bgcolor="#D3E7FC"><table width="100%" border=0 cellpadding="2" cellspacing=0 >
          
          <tr>
            <td width="15%" align="right">用户名:</td>
            <td width="35%"><input type="text" name="username" id="username" value="<?php echo $username ?>" <?php 
			if($act=='add'){ ?>datatype="LimitB|Ajax"  min=4  msg="用户名至少4位|用户名已存在" url="../../ajaxCheck.php?tb=g_user_info"<?php }else{ echo 'datatype="LimitB"  min=4  msg="用户名至少4位"'; } ?>/>            </td>
            <td width="13%" rowspan="5" align="right">头像:</td>
            <td width="37%" rowspan="5"><img src="../../uploadfile/logo/<?php echo $imgurl; ?>" onerror="this.src='../images/no_pic.gif'" id="img" height="90" onclick="window.open(this.src)" style="cursor:hand"/>
    <input type="hidden" name="imgurl" id="imgurl" value="<?php echo $imgurl; ?>"/>
    <iframe frameborder="0" scrolling="no" src="../../include/upload.php?path=logo" width="100%" height="25"></iframe></td>
          </tr>
          <tr>
            <td align="right">用户组:</td>
            <td><select name="groupid" id="groupid" datatype="Require" msg="未选择用户组">
              <option value="">- 请选择 -</option>
              <?php 
            $sql = "select * from g_user_group order by orderid";
            $query = $db -> query($sql);
            while($row = $db -> fetch_array($query)){	
          ?>
              <option value="<?php echo $row['groupid'] ?>"  <?php if($row['groupid']==$groupid) { echo 'selected'; } ?>><?php echo $row['groupname'] ?></option>
              <?php }?>
              </select>
            </td>
            </tr>
          <tr>
            <td align="right">单位名称:</td>
            <td><input type="text" name="company" id="company" value="<?php echo $company ?>" msg="必填"/></td>
            </tr>
          <tr>
            <td align="right">真实姓名:</td>
            <td><input type="text" name="realname" id="realname" value="<?php echo $realname ?>" datatype="Require" msg="必填"/></td>
          </tr>
          <tr>
            <td align="right">所在地区:</td>
            <td><select name="cityid" datatype="Require" msg="未选择">
    <option value="">- 请选择 -</option>
    <?php
		$class_arr=getClassArray('g_nclass_city');
		echo tree($class_arr,1,$cityid);
    ?>
  </select></td>
            </tr>
          <tr>
            <td align="right">电话:</td>
            <td><input type="text" name="tel" id="tel" value="<?php echo $tel ?>"/></td>
            <td align="right">手机:</td>
            <td><input type="text" name="mobile" id="mobile" value="<?php echo $mobile ?>"/></td>
          </tr>
          <tr>
            <td align="right">Email:</td>
            <td><input type="text" name="email" id="email" value="<?php echo $email ?>"/></td>
            <td align="right">QQ:</td>
            <td><input type="text" name="qq" id="qq" value="<?php echo $qq ?>"/></td>
          </tr>
          <tr>
            <td align="right">地址:</td>
            <td><input type="text" name="address" id="address" value="<?php echo $address ?>"/></td>
            <td align="right">网址:</td>
            <td><input type="text" name="homepage" id="homepage" value="<?php echo $homepage ?>"/></td>
          </tr>
          <tr>
            <td align="right">备注:</td>
            <td colspan="3"><input name="remark" type="text" id="remark" size="60"  value="<?php echo $remark ?>"/></td>
            </tr>
          <tr>
            <td colspan="4" align="center" height='30'><input type="submit" class="btn" value=" 确定 "/>
            <input type="hidden" name="Action" id="Action" value="<?php echo $act; ?>"/>
             <input type="hidden" name="oldusername" id="oldusername" value="<?php echo $username; ?>"/>
            </td>
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
</form>
</BODY>
</HTML>

