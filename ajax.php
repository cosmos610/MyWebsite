<?php
    if(isset($_POST['content'])){
        session_start();
        $filename = date("Ymd",time()).".txt";         //开启session，创建聊天记录文件，带时间
        if(file_exists($filename)){
            $content = file_get_contents($filename);          
            $data = json_decode($content,true);        
            $con['username'] = $_SESSION["username"];
            $con['content'] = $_POST["content"];
            $data[] = $con;
            $file = fopen($filename,"w");       //写入模式
            fwrite($file,json_encode($data));       
            fclose($file);                               //写入每次发送的话
        }else{
            $file = fopen($filename,"w");
            $con['username'] = $_SESSION["username"];
            $con['content'] = $_POST["content"];
            $data[] = $con;
            fwrite($file,json_encode($data));
            fclose($file);                          //依然写入
        }
            
    }
?>
