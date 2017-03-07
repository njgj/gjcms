<?php
require('../global.php');
$id=(int)$_GET['id'];
$sql="select * from g_gg where id=".$id;
$query=$db->query($sql);
if($row=$db->fetch_array($query)){
    $posid=$row['posid'];
	$xgid=$row['xgid'];
	$width=$row['width'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广告</title>
<link href="../../css/style.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="../../Include/jquery-1.8.3.min.js"></script>
</head>

<body style="height:800px;">
<?php echo myAd(800,$posid,$xgid,0) ?>
</body>
</html>