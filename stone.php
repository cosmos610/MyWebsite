<?php 
//获取弹幕插入数据库
header('Content-type:text/html;charset=utf8');
$conn = mysqli_connect("localhost", "root", "SMYjm!@610") or die("datebase can`t been connected");
mysqli_select_db("danmu", $conn);
mysqli_query("set names 'utf8'"); //

$danmu=$_POST['danmu'];
$sql="INSERT INTO `danmu`(`id`,`danmu`) VALUES ('','".$danmu."')";

echo $sql;
$query=mysqli_query($sql);                             
echo $danmu;

?>
