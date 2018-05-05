<?php 
header('Content-type:text/html;charset=utf8');
//连接数据库
$conn = @ mysqli_connect("localhost", "root", "SMYjm!@610") or die("datebase can`t been connected");
mysqli_select_db("danmu", $conn);
mysqli_query("set names 'utf8'"); //

//选择弹幕
$sql="SELECT `danmu` FROM `danmu`";
$query=mysqli_query($sql); 
//echo $danmu;
echo "[";
$first=0;
while($row=mysqli_fetch_array($query)){
	if ($first) {
		echo ",";
		
	}
$first=1;
echo "'".$row['danmu']."'";
}
	echo "]";
?>
