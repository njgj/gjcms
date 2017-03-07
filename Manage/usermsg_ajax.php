<?php 
require('global.php');

//conn.execute "update user_msg set isdisp=0,islooked=0 where isdisp=1 and touserid="&session("userid")
if($_POST['Action']=="Close"){
	$db->query("update g_user_msg set isdisp=1 where isdisp=0 and touserid=".$_SESSION['userid']);
	htmlendjs("您的在线消息可在[个人设置-个人消息]中查看！","close");
}

if($_SESSION['groupid']==1){
	$yy_no=1;
	if($yy_no>0){
	    $msg.="<p><a href='pt/pt_yy_manage.php?states=0' target='main'><font color=red><strong>"&intval($yy_no)&"</strong></font></a></p>";
	}
}

$sql="select * from g_user_msg where isdisp=0 and islooked=0 and touserid=".$_SESSION['userid']." order by addtime desc";
$query=$db -> query($sql);
if($db->num_rows($query)>0){
    while($row=$db->fetch_array($query)){
    $mes.="<p><a href='javascript:void(0);' onclick=newwin('user/usermsg_detail.php?id=".$row['id']."',600,300);>".$row['title']."</a>(".$row['addtime'].")</p>";
    }
   $mes.="<a href='javascript:void(0);' onclick=newwin('usermsg_ajax.php?Action=Close',1,1)  class='close-btn'>关闭显示</a>";
}

if($msg){
?>
<div class="msg-box">
  <div class="hd"><h2>在线提醒</h2>
    <span><a href="javascript:;"  class="remove-btn remenber">╳</a></span>
  </div>  
  <div class="bd"><?php echo $msg; ?></div> 
</div>
<?php
}
if($mes){
?>
<div class="msg-box">
  <div class="hd"><h2>在线消息</h2>
    <span><a href="javascript:;" class="remove-btn">╳</a></span>
  </div>  
  <div class="bd"><?php echo $mes; ?></div> 
</div>
<?php 
}
?>