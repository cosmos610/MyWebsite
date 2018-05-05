<!DOCTYPE html>
<html lang="en">  <!-- -->
<head>
  <meta charset="utf-8"> 
  <title>Webcam Live From LYL</title>

<!--调用模块--> 
  <script src="jquery-3.2.1.min.js"></script>
  <script src="jquery.danmu.min.js"></script>
  <script src="http://vjs.zencdn.net/5.20.1/video.js"></script>
  <link href="http://vjs.zencdn.net/5.20.1/video-js.css" rel="stylesheet">
  <script src="http://vjs.zencdn.net/5.20.1/videojs-ie8.min.js"></script>	
       <!--调用video.js以及jquery和jquery的弹幕部分 -->
<!--聊天函数部分，头里面-->  
  <script>     
	$(function(){
    $("#post").click(function(){
        
    var content=$("#content").val();
    if(!$.trim(content)){
       alert('请填写内容');
       return false;
    }
    $("#content").val("");

    $.post("ajax.php", {content:content});});
	}
	)                               <!--拒绝空内容，如果有内容发到ajax发送 -->
    
    function getData(msg){
        if(msg == undefined)
        {
            msg = '';    
        }
        $.post("get.php",{"msg":msg},function(data){
            //var myjson = eval("("+data+")");
            if(data){
                var chatcontent = '';
                var obj = eval('('+data+')');
                $.each(obj,function(key,val){
                    chatcontent += "<div class='username'>"+val['username']+" 说:</div>";
                    chatcontent += "<div class='content'>"+val['content']+"</div>";
                })
                $("#chatshow").html(chatcontent);
            }
            
            getData();    
        })    
    }
	getData("one");
</script>
<!--聊天界面格式 -->
	<style>
	#chat{margin:0 auto;}
	#chatshow{width:500px;height:400px;overflow:auto;border:1px solid #ccc;float:left;}
	#userlist{width:100px;height:400px;overflow:auto;border:1px solid #ccc;float:left;margin-right:2px;}
	#userlist p{color:#0F0; cursor:pointer;}
	.clearboth{clear:both;}
	.username{font-weight:bold;color:#00F;font-size:12px;margin-bottom:3px;margin-top:8px;}
	</style>
</head>           
<!--主界面 -->
<body >
	<h1 style="text-align:center" id="s1">欢迎来到我的直播网站！</h1>
	<button type="button" onclick="window.open('login.html')">登陆</button>
	<input type=button onclick="window.open('register.html')" value="注册">
     <!--基本按钮，登陆注册 -->
<!--cookie区块-->    
	<script>
	   function get_cookie(cookieName){
		//判断cookie是否存在
		if (document.cookie.length>0){
			pos=document.cookie.indexOf(cookieName + "=")
			if (pos!=-1){ 
				pos=pos + cookieName.length+1 
				last=document.cookie.indexOf(";",pos)
				if (last==-1) last=document.cookie.length
				return unescape(document.cookie.substring(pos,last))
			} 
		}
		return "cookie不存在!";
	}
		username=get_cookie("uname");
		document.write("欢迎你!"+username+"，这里是LYL的直播网站"); <!--欢迎样式 -->
	</script>

	<hr> 

<!--弹幕显示的位置-->
    <div id="danmu"  style="margin-top:110px;" >
	</div> 
<!--视频直播部分-->
	<video id="example_video" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="1280" height="720"
	poster=""
	data-setup='{ "html5" : { "nativeTextTracks" : false } }' autoplay="autoplay">
	<source src="rtmp://10.61.0.10/live/test" type="rtmp/flv" />
	<p class="vjs-no-js">
	To view this video please enable JavaScript, and consider upgrading to a web browser
	that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
	</p>
	</video>          <!--video.js的调用方法-->

<!--弹幕控制区-->
	<div class="ctr"   >
	<br>
	  <button type="button"  onclick="resumer() ">弹幕开始/继续</button>&nbsp;&nbsp;&nbsp;&nbsp;
	  <button type="button"  onclick="pauser()">弹幕暂停</button>  &nbsp;&nbsp;&nbsp;&nbsp;
	  显示弹幕:<input type='checkbox' checked='checked' id='ishide' value='is' onchange='changehide()'> &nbsp;&nbsp;&nbsp;&nbsp;
	  弹幕透明度:
	  <input type="range" name="op" id="op" onchange="op()" value="100"> <br>
	  当前弹幕运行时间(秒)：<span id="time"></span>&nbsp;&nbsp;
	  设置当前弹幕时间(秒)： <input type="text" id="set_time" max=20 />
	  <button type="button"  onclick="settime()">设置</button>
	  <br>
	  发弹幕:
	  <select  name="color" id="color" >
		<option value="white">白色</option>
		<option value="red">红色</option>
		<option value="green">绿色</option>
		<option value="blue">蓝色</option>
		<option value="yellow">黄色</option>
	  </select>
	  <select name="size" id="text_size" >
		<option value="1">大文字</option>
		<option value="0">小文字</option>
	  </select>
	  <select name="position" id="position"   >
		<option value="0">滚动</option>
		<option value="1">顶端</option>
		<option value="2">底端</option>
	  </select>
	  <input type="textarea" id="text" max=300 />
	  <button type="button"  onclick="send()">发送</button>
	</div>
<!--弹幕函数区块-->	
	<script>
	  //初始化弹幕大小位置等等
	  $("#danmu").danmu({
		left:0,
		top:0,
		height:"100%",
		width:"100%",
		speed:10000,
		opacity:1,
		font_size_small:16,
		font_size_big:24,
		top_botton_danmu_time:6000
	  });
	  query();//  从后端获取弹幕并添加

	 
	  $("#danmu").danmu("addDanmu",[
		{ text:"这是滚动弹幕" ,color:"white",size:1,position:0,time:2}
		,{ text:"这是顶部弹幕" ,color:"yellow" ,size:1,position:1,time:2}
		,{ text:"这是底部弹幕" , color:"red" ,size:1,position:2,time:2}
	  ]);   //再添加三个初始弹幕
	   
	  function timedCount(){
		$("#time").text($('#danmu').data("nowTime"));

		t=setTimeout("timedCount()",50)

	  }   //一个定时器，监视弹幕时间并更新到页面上
	  timedCount();



	  function starter(){
		$('#danmu').danmu('danmuStart');
	  }
	  function pauser(){
		$('#danmu').danmu('danmuPause');
	  }
	  function resumer(){
		$('#danmu').danmu('danmuResume');
	  }
	  function stoper(){
		$('#danmu').danmu('danmuStop');
	  }
	  function getime(){
		alert($('#danmu').data("nowTime"));
	  }
	  function getpaused(){
		alert($('#danmu').data("paused"));
	  }
	  
	  function add() {
		var newd =
		{"text": "new2", "color": "green", "size": "1", "position": "0", "time": 60};
		$('#danmu').danmu("addDanmu", newd);
	  }  //添加弹幕测试  这个函数没有调用
	  
	  function insert(){
		var newd= { "text":"new2" , "color":"green" ,"size":"1","position":"0","time":50};
		str_newd=JSON.stringify(newd);
		$.post("stone.php",{danmu:str_newd},function(data,status){alert(data)});
	  }  //向后端添加弹幕测试  这个函数没有调用
	  
	  function query() {
		$.get("query.php",function(data,status){
		  var danmu_from_sql=eval(data);
		  for (var i=0;i<danmu_from_sql.length;i++){
			var danmu_ls=eval('('+danmu_from_sql[i]+')');
			$('#danmu').danmu("addDanmu",danmu_ls);
		  }
		});
	  }  //从后端获取到弹幕并添加
	  
	  function send(){
		var text = document.getElementById('text').value;
		var color = document.getElementById('color').value;
		var position = document.getElementById('position').value;
		var time = $('#danmu').data("nowTime")+1;
		var size =document.getElementById('text_size').value;
		var text_obj='{ "text":"'+text+'","color":"'+color+'","size":"'+size+'","position":"'+position+'","time":'+time+'}';
		$.post("stone.php",{danmu:text_obj});
		var text_obj='{ "text":"'+text+'","color":"'+color+'","size":"'+size+'","position":"'+position+'","time":'+time+',"isnew":""}';
		var new_obj=eval('('+text_obj+')');
		$('#danmu').danmu("addDanmu",new_obj);
		document.getElementById('text').value='';
	  }  //发送弹幕，使用了文档README.md中的方法
	  
	  function op(){
		var op=document.getElementById('op').value;
		$('#danmu').danmu("setOpacity",op/100);
	  }    //调整透明度函数

	  
	  function changehide() {
		var op = document.getElementById('op').value;
		op = op / 100;
		if (document.getElementById("ishide").checked) {
		  $("#danmu").danmu("setOpacity",1)
		} else {
		  $("#danmu").danmu("setOpacity",0)

		}
	  } //调隐藏 显示

	  
	  function settime(){
		var t=document.getElementById("set_time").value;
		t=parseInt(t)
		$('#danmu').danmu("setTime",t);
	  }      //设置弹幕时间
	</script>
<!--聊天框区域-->	
	<div id="chat">
		<div id="userlist">
			<div style="font-size:12px;font-weight:bold;">在线用户列表</div>
				<div class="userlist">
					<?php 
						// $dsn = "mysql:host=localhost;dbname=test;charset=utf8'";
					 //    $db = new PDO($dsn, 'root', 'root');
						$db = new PDO('mysql:dbname=index;host=localhost;charset=utf8', 'root', 'SMYjm!@610');
						$rs = $db->prepare("select * from users1 where islog = '1'");
						$rs->execute();
						while($row = $rs->fetch()){
							echo '<p>'.$row["username"].'</p>';    
						}
					?>
				</div>
			</div>
		<div id="chatshow"></div>
	</div>        <!--php数据库调取在线用户列表 -->
	<div class="clearboth"></div>
		<div>
			<textarea name="content" id="content" style="width:600px;height:100px"></textarea>
			<input type='button' name='tj' id="post" value='发布' >
		</div>
	</div> 	            <!--聊天按钮 -->
</body>
</html>