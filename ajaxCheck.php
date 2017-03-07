<?php
require('global.php');
$tb=str_replace("'","",$_POST['tb']);
$zd=str_replace("'","",$_POST['zd']);
$data=str_replace("'","",$_POST['data']);
if(empty($tb) || empty($zd)) { die('参数错误'); }

$sql="select $zd from $tb where $zd='$data'";
$query=$db->query($sql);
if($row=$db->fetch_array($query)){
   echo 'error';
}else{
   echo 'success';
}
?>