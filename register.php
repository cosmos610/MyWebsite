<?php
//获取用户输入的信息
$usernames=$_POST['username'];  
$passwords=$_POST['passwd1'];  
$password2s=$_POST['passwd2']; 
$sexs=$_POST['sex'];  
$institutes=$_POST['institute'];  
$phones=$_POST['tel'];  
$condicodes=$_POST['condicode'];  
$emails=$_POST['mail'];  
$link=mysqli_connect('localhost:3306','root','SMYjm!@610','index');
$query=mysqli_query($link,"SELECT username FROM users1 WHERE username = '$usernames'");   
$row=mysqli_num_rows($query);
printf("%u",$row); //调试
//注册，插入数据库防止用户名重复
if(isset($_POST["submit"]) && $_POST["submit"] == "注册")
{   
    if($row==0)
	{   if(mysqli_query($link,"INSERT INTO users1 SET username='$usernames',passwd='$passwords',sex='$sexs',phone='$phones',institute='$institutes',condicode='$condicodes',email='$emails'"))
			 {  
				setcookie("uname",$usernames,time()+7);  
			    echo "<script>alert('success,now you can log in with this username');window.location= 'index1.php';</script>";  
			 }
		      else 
			 {  
				echo "<script>alert('failed!please contact to the admin');</script>";
				printf("Error: %s\n", mysqli_error($link));
				
				
			 }   
	}
	else
	{
	  echo "<script>alert('failed,this name has been used!')</script>";
	}
	
  
}	

include('register.html');
?>