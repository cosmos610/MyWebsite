<?php
$flag=0;  
//var_dump($_GET);  
if(isset($_GET["out"])){  
    if($_GET["out"]){  
        setcookie('uname','',time()-1);  
        $flag=1;//防止服务器接收到getout操作时已经认为该用户有cookie，然后下面的COOKIE[NAME]已经有了，服务器返回给他的才是空的  
    }  
}    
if($flag!=1){  
    $link=mysqli_connect('localhost:3306','root','SMYjm!@610','index');  
    if(isset($_COOKIE['uname']))
	{  
        $name=$_COOKIE['uname'];  
        $query=mysqli_query($link,"SELECT username FROM users1 WHERE username = '$name'");   
		$row=mysqli_num_rows($query);    //了解有多少
        if (!$query) 
		        {
				printf("Error:%s\n",mysqli_error($link));
				exit();
				}         //调试错误
		  if($row==1){  
            echo "Welcome ".$_COOKIE['uname']."";  
            echo '    ';  
            echo '<a href="index.php?out=1">logout</a>';//用户logout  
            echo  '<br/><a href="index.php">click here to the main page</a>';           
					  }    //欢迎界面
    }else{  
        echo  '<a href="login.html">login</a>';  
        echo  '    ';  
        echo  '<a href="register.html">register</a>';   //登陆注册
    }  
}  
else{  
    echo  '<a href="login.html">login</a>';  
    echo  '';  
    echo  '<a href="register.html">register</a>';  
	  //存在cookie
}?>  