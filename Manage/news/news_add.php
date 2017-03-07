<?php
require('../global.php');
//参数
$id=(int)$_GET['id'];
$Action=$_POST['Action'];
$classid=(int)$_POST["classid"];
$title=trim($_POST["title"]);
$author=trim($_POST["author"]);
$source=trim($_POST["source"]);
$content=$_POST["content"];
$imgurl=trim($_POST["imgurl"]);
$keyword=trim($_POST["keyword"]);
$hits=(int)$_POST["hits"];
$states=(int)$_POST["states"];
$addtime=$_POST["addtime"];
//初始化
$act='add';
function init(){
global $title,$author,$source,$content,$imgurl,$keyword,$addtime;
if(empty($title)){ htmlendjs("标题不能为空",""); }
if(empty($content)){ htmlendjs("内容不能为空",""); }
if(empty($addtime)){ $addtime=date('Y-m-d'); }
}
//操作
if($Action=='add'){
    init();
    $db->query("INSERT INTO g_news(classid,title,author,source,content,imgurl,keyword,hits,states,addtime) VALUES($classid,'$title','$author','$source','$content','$imgurl','$keyword',$hits,$states,'$addtime')");	
    htmlendjs('添加成功','news_add.php');
}
if($Action=='edit'){
    init();
    $db->query("update g_news set classid=$classid,title='$title',author='$author',source='$source',content='$content',imgurl='$imgurl',keyword='$keyword',hits=$hits,states=$states,addtime='$addtime' where id=$id");	
    htmlendjs('修改成功','open');
}
//赋值
if(!empty($id)){
    $query=$db->query("select * from g_news where id=$id");
    $row = $db -> fetch_array($query);
    if($row){
    $classid=$row['classid'];
$title=$row['title'];
$author=$row['author'];
$source=$row['source'];
$content=$row['content'];
$imgurl=$row['imgurl'];
$keyword=$row['keyword'];
$hits=$row['hits'];
$states=$row['states'];
$addtime=$row['addtime'];
    $act='edit';
    }
    
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE>后台管理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="../css/css.css" type=text/css rel=stylesheet>
<link rel="stylesheet" href="../../editor/themes/default/default.css" />
<script type="text/javascript" src="../../My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="../../Include/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../../include/jquery.validator.js"></script>
<?php echo openwin("false"); ?>
<script charset="utf-8" src="../../editor/kindeditor.js"></script>
<script charset="utf-8" src="../../editor/lang/zh_CN.js"></script>
<script type="text/javascript">
var editor;
KindEditor.ready(function(K) {
	editor = K.create('textarea[name="content"]', {
		allowFileManager : true
	});
	K('input[name=insertNext]').click(function(e) {
		editor.insertHtml('[NextPage]');
	});
	$("#myform").checkForm({msg:'是否确认提交？'}); 
});
</script>
</HEAD>
<BODY>
<BR>
<form action="?id=<?php echo $id; ?>" method="post" id="myform">
	<table width="800" border=1 align=center cellpadding="0" cellspacing="0" bordercolor="#b0c4de">
<tr>
		<th height="25" colspan="3" background="../images/bg.gif">添加新闻</th>
	</tr>
	
    <tr>
   <td width=92 height="30" align="center">新闻标题</td>
  <td height="30" bgcolor="#FFFFFF"><input type="text" name="title" size=50 datatype="Require" msg="必填" value="<?php echo $title; ?>"/></td>
  <td width="364" rowspan="6" align="center" bgcolor="#FFFFFF"><img src="../../uploadfile/images/<?php echo $imgurl; ?>" onerror="this.src='../images/no_pic.gif'" id="img" height="120" onclick="window.open(this.src)" style="cursor:hand"/>
    <input type="hidden" name="imgurl" id="imgurl" value="<?php echo $imgurl; ?>"/>
    <iframe frameborder="0" scrolling="no" src="../../include/upload.php?path=images" width="100%" height="25"></iframe></td>
    </tr>
   <tr>
   <td width=92 height="30" align="center">新闻分类</td>
  <td height="30" bgcolor="#FFFFFF">
    <select name="classid" datatype="Require" msg="请选择类别">
    <option value="">- 请选择类别 -</option>
    <?php
		$class_arr=getClassArray('g_nclass');
		echo tree($class_arr,0,$classid);
    ?>
  </select></td>
    </tr>
       <tr>
         <td height="30" align="center">作者</td>
         <td height="30" bgcolor="#FFFFFF"><input type="text" name="author" value="<?php echo $author; ?>"/></td>
       </tr>
       <tr>
         <td height="30" align="center">来自</td>
         <td height="30" bgcolor="#FFFFFF"><input type="text" name="source" id="source" value="<?php echo $source; ?>"/></td>
       </tr>
       <tr>
   <td width=92 height="30" align="center">关键字</td>
  <td width="340" height="30" bgcolor="#FFFFFF"><input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>"/></td>
    </tr>
       <tr>
         <td height="30" align="center">时间</td>
         <td height="30" bgcolor="#FFFFFF"><input name="addtime" type="text" id="addtime" value="<?php 
		  if(empty($addtime)){ $addtime=date('Y-m-d'); }
		  echo formatdate($addtime);
		  ?>" class="inputbg" onFocus="WdatePicker()" readonly/></td>
       </tr>
       <tr>
   <td height="30" colspan="3" align="center">
     <textarea name="content" style="width:98%;height:280px;"><?php echo $content; ?></textarea>   </td>
  </tr>
    <tr>
   <td height="50" colspan="3" align="center">
     <input type="submit" class="btn"  value=" 提交 ">
     <input type="hidden" name="Action" id="Action" value="<?php echo $act; ?>"/></td>
  </tr>
    
	</table>
</form>
<p>&nbsp;</p>
</BODY></HTML>
