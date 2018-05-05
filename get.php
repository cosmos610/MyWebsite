
<?php 
set_time_limit(0);       //执行到程序结束
$filename = date("Ymd",time()).".txt";
if(file_exists($filename)){
    $content = file_get_contents($filename);
    $data = json_decode($content,true);        
    $count = count($data);
    if($_POST['msg'] == "one"){
        exit(json_encode($data));    
    }               //读取聊天记录显示到屏幕上
    
    while(true){
        
        $contents = file_get_contents($filename);
        $datas = json_decode($contents,true);
        $counts = count($datas);    
        if($counts>$count){
            echo json_encode($datas);
            break;
        }
        usleep(3);      //刷新信息，间断休息0.003秒
    }      
}else{
    $file = fopen($filename,"w");
    $con['username'] = "系统消息";
    $con['content'] = "欢迎来到LYL直播聊天室";
    $data[] = $con;
    fwrite($file,json_encode($data));
    fclose($file);
    
    exit(json_encode($data));      //最初消息
    
}

?>