<?php 
require('global.php');

//即时刷新在线状态
if($_POST['Action']=="UpdateTime"){
    $db->query("update g_user_info set onlinetime=now() where online=1 and userid=".$_SESSION['userid']);
} 

if($_POST['Action']=="UpdateOnline"){
    $db->query( "update g_user_info set online=0 where online=1 and  TIMESTAMPDIFF(SECOND ,onlinetime,now())>60");
} 
?>