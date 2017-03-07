<?php 
require('../global.php');  

$username=$_POST['username'];
$userpwd=$_POST['userpwd'];

if(empty($username) || empty($userpwd)){
   htmlendjs("用户名或密码错误","");
}

$sql="select * from g_user_info where username='".$username."'";
$query=$db->query($sql);
if(!$row=$db ->fetch_array($query)){
   htmlendjs("用户名不存在，请先注册","");
}else{
   if($row['userpwd']!=md5($userpwd)){
       htmlendjs("密码错误","");
   }
 
   if($row['states']==0){
       htmlendjs("当前账户审核还未通过","");
   } 
   
   $db->query("update g_user_info set online=1,onlinetime=now(),logintimes=logintimes+1,lastlogintime=now(),lastloginip='".$_SERVER['REMOTE_ADDR']."' where userid=".$row['userid']);
   
   $_SESSION['userid']=$row['userid'];
   $_SESSION['groupid']=$row['groupid'];
   $_SESSION['username']=$row['username'];
   $_SESSION['cityid']=$row['cityid'];
   header('location:index.php');
}
?>