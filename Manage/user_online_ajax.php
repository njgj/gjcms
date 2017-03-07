<?php 
require('global.php');
$groupid=$_GET['groupid'];

$sql="select * from g_user_info where states=1";
if(empty($groupid)){
    $sql.=" and online=1";
}else{
    $sql.=" and groupid=".(int)$groupid;
}
$sql.=" order by groupid";
$query= $db->query($sql);
while($row=$db->fetch_array($query)){

echo "<div><a href=# onclick=\"newwin('user/usermsg_send.php?userid=".$row['userid']."',600,400)\">";
if($row['online']==1){
echo "<font color=blue>".$row['username']."[".$row['realname']."]</font>";
}else{
echo "<font color=gray>".$row['username']."[".$row['realname']."]</font>";
}
echo "</a></div>";
}
?>