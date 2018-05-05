<?php
header("content-type:text/html;charset=utf-8");
$link = mysqli_connect('localhost:3306','root','SMYjm!@610','index'); //连接数据量
$usernames=$_POST['username'];  
$passwords=$_POST['passwd1'];  //获得账号密码
$query=mysqli_query($link,"select username,passwd from users1 where username='$usernames'");
$row = mysqli_fetch_array($query,MYSQLI_BOTH);     //获得账号密码  
if (!$query) {
 printf("Error: %s\n", mysqli_error($link));
 exit();
}       //调试



if($link)
{
	echo "<script>alert('successful connection!')</script>";
}
else
{
	echo "<script>alert('failed,please get contact with admin')</script>";
}
  //调试

if($_POST['submit']="登陆"){      
    if($row['username']==$usernames && $row['passwd']==$passwords){  
        setcookie("uname",$usernames,time()+7200);   //判断账号密码 设置cookie
        echo "<script>alert('successfully login!');window.location= 'index1.php';</script>"; 
		$query1=mysqli_query($link,"UPDATE users1 SET islog='1' where username='$usernames'"); //确认登陆状态
    }  
    else echo "<script>alert('failed!');history.go(-1)</script>";//返回之前的页面  
}    
include('login.html');
?>