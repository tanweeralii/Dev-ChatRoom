<?php
	$name = $_GET['chat_with_user'];
?>
<html lang="en">
	<head>
		<style type="text/css">
			body{
				background-image:url("images/background3.jpg");
				background-margin:100%;
				height:600px;
				width:900px;
			}
		</style>
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	    <link rel="stylesheet" type="text/css" href="bootstrap.css">
	    <link href="https://fonts.googleapis.com/css?family=Mansalva&display=swap" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
	</head>
	<body>
		<nav class="navbar-expand-md bg-dark navbarleft">
            <p class="text-centered pt-3 text-white font-weight-bold pl-2" id="demo"><?php echo $name; ?></p>
            <ul class="navbar-nav ml-auto">
            	<div class="dropdown1">
				  <button class="button6 bg-transparent ml-1 dropbtn" onclick="dropdown()"><img class="image6" src="images/threedots.png" style="width:25px;height:25px;"></button>
				  <div id="myDropdown" class="dropdown1-content">
				    <button  title="Block User" id="block_" onclick="block()">Block</button>
				  </div>
				</div>   
            </ul>
         </nav>
		<div class="chatarea1" id="chatarea1">
			
		</div>
		<div class="footer1">
			<div class="attach1">
				<input type="file" id="file" hidden="hidden" multiple="multiple" name="file"><button class="button6 bg-transparent" id="notrealfile"><image class="image5" src="images/attachicon.png" style="width:35px;height:35px;"></button>
            </div>
            <div class="attach1 message1 form-group">
              	<textarea id="msg" class=" form-control textarea" rows="1" type="text" placeholder="Type a message" aria-label="Search"></textarea>
            </div>
            <div class="attach1 mic1">
            	<image class="image5" id="mic3" src="images/micicon.png" style="width:25px;height:25px;">
           	</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	    <script src="https://kit.fontawesome.com/d82a99eeb8.js" crossorigin="anonymous"></script>
	    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	    <script type="text/javascript">
	    	function dropdown() {
			  document.getElementById("myDropdown").classList.toggle("show");
			}
			// Close the dropdown menu if the user clicks outside of it
			window.onclick = function(event) {
			  if (!event.target.matches('.dropbtn')) {
			    var dropdowns = document.getElementsByClassName("dropdown-content");
			    var i;
			    for (i = 0; i < dropdowns.length; i++) {
			      var openDropdown = dropdowns[i];
			      if (openDropdown.classList.contains('show')) {
			        openDropdown.classList.remove('show');
			      }
			    }
			  }
			} 
	    	var real = document.getElementById("file");
	    	const custom = document.getElementById("notrealfile");

	    	custom.addEventListener("click", function(){
	    		real.click();
	    	})
	    </script>
	    <script type="text/javascript">
	        var socket = new WebSocket('ws://ip_of_socket_server/server1.php');
          	socket.onopen = function(event) {
	    		console.log("Connection Established");
	    	}
			function submitOnEnter(event){
				if(event.which === 32 && event.target.value === ""){
					event.preventDefault();
        			event.target.value = "";
				}else if(event.which === 13 && event.target.value === ""){
					event.preventDefault();
        			event.target.value = "";
				}else if(event.which  === 13){
	       			var text1 = event.target.value;
	       			var text = text1.replace(/  +/g, ' ');
	       			var sender = sessionStorage.getItem('uname');
	       			var receiver = sessionStorage.getItem('u2_name');
	       			var text2 = "text";
	       			$.getJSON('https://api.ipgeolocation.io/ipgeo?apiKey=', function(data) {
	  					sessionStorage.setItem('ipaddr', data["ip"]);
					});
	       			var ip = sessionStorage.getItem('ipaddr');					
	       			var os = navigator.platform;

	       			$.post("chatroom_insert.php", {text: text, sender: sender, receiver: receiver, ip: ip, os: os}, function(data, status){
	  				});
	  				event.preventDefault();
	        		event.target.value = "";
	        		var json_data = {'message':text,'sender':sender,'receiver':receiver,'type':text2, 'status':'0'};
          			var json_data1 = JSON.stringify(json_data);
          			socket.send(json_data1);
	       		}	
    		}
			$(document).ready(function(){
				load();		
      		})
      		function load(){
      			var params = {
					uname1: sessionStorage.getItem('uname'),
					uname2: sessionStorage.getItem('u2_name')
				};
				var request = new XMLHttpRequest;
        		request.onload = () => {
          			let responseObject = null;

          			try{
            			responseObject = JSON.parse(request.responseText);
         			}
         			 catch(e){
            			console.error('could not parse JSON!');
          			}

          			if(responseObject){
            			handleresponse1(responseObject);
          			}
        		}
          		request.open('post', 'chatroom_text.php');
          		request.send(JSON.stringify(params));
      		}
      		function handleresponse1(responseObject){
      		    if(responseObject.count==0){
      		        alert("You had no conversation!");
      		    }
      		    else{
      		        for(var i = 1; i<=responseObject.count; i++){
        			if(responseObject.type[responseObject.count-i]=="file"){
        				if(responseObject.sender[responseObject.count-i]==sessionStorage.getItem('uname')){
        					$('#chatarea1').prepend('<div class="message-row you-message"><div class="message-text"><a href="http://thenewbieprojects.com/getfile.php?u='+responseObject.text[responseObject.count-i]+'" target="_blank">'+responseObject.text[responseObject.count-i]+'</a></div><div class="message-time text-muted">'+responseObject.time[responseObject.count-i]+'</div><div class="message-date text-muted">'+responseObject.date[responseObject.count-i]+'</div></div>');
        				}
        				else{
        					$('#chatarea1').prepend('<div class="message-row other-message"><div class="message-text"><a href="http://thenewbieprojects.com/getfile.php?u='+responseObject.text[responseObject.count-i]+'" target="_blank">'+responseObject.text[responseObject.count-i]+'</a></div><div class=message-time text-muted">'+responseObject.time[responseObject.count-i]+'</div><div class="message-date text-muted">'+responseObject.date[responseObject.count-i]+'</div></div>');
        				}
        			}
        			else{
        				if(responseObject.sender[responseObject.count-i]==sessionStorage.getItem('uname')){
        					$('#chatarea1').prepend('<div class="message-row you-message"><div class="message-text text-white">'+responseObject.text[responseObject.count-i]+'</div><div class="message-time text-muted">'+responseObject.time[responseObject.count-i]+'</div><div class="message-date text-muted">'+responseObject.date[responseObject.count-i]+'</div></div>');
        				}
        				else{
        					$('#chatarea1').prepend('<div class="message-row other-message"><div class="message-text text-white">'+responseObject.text[responseObject.count-i]+'</div><div class="message-time text-muted">'+responseObject.time[responseObject.count-i]+'</div><div class="message-date text-muted">'+responseObject.date[responseObject.count-i]+'</div></div>');
        				}
        			}
        			
        			var chatarea = document.getElementById("chatarea1");
					chatarea.scrollTop = chatarea.scrollHeight - chatarea.clientHeight;
          		    }
      		    }
          		document.getElementById("msg").addEventListener("keypress", submitOnEnter);
          		check_block();
        	}
	    		socket.onmessage = function(event){
				   	var response = JSON.parse(event.data);
					if(response.status=="1"){
						if(response.block_status=="block"){
							if(response.sender==sessionStorage.getItem('u2_name') && response.receiver== sessionStorage.getItem('uname')){
						   		$('#chatarea1').append('<div><p class="mb-1 text-centered text-white" style="text-align:center">'+'You are Blocked by '+response.sender+'</p></div>');
						   		document.getElementById("msg").disabled = true;
			       				document.getElementById("file").disabled = true;
			       				document.getElementById("mic3").disabled = true;
			       				document.getElementById("block_").disabled = true;
						   	}
						}
						else if(response.block_status=="unblock"){
							if(response.sender==sessionStorage.getItem('u2_name') && response.receiver== sessionStorage.getItem('uname')){
						   		$('#chatarea1').append('<div><p class="mb-1 text-centered text-white" style="text-align:center">'+'You are Unblocked by '+response.sender+'</p></div>');
						   		document.getElementById("msg").disabled = false;
			       				document.getElementById("file").disabled = false;
			       				document.getElementById("mic3").disabled = false;
			       				document.getElementById("block_").disabled = false;
						   	}
						}
					}
					else if(response.status=="0"){
						if(response.type=="file"){
					   		if(response.sender==sessionStorage.getItem('uname') && response.receiver==sessionStorage.getItem('u2_name')){
								$('#chatarea1').append('<div class="message-row you-message"><div class="message-text"><a href="http://thenewbieprojects.com/getfile.php?u='+response.message+'" target="_blank">'+response.message+'</a></div><div class="message-time text-muted">'+response.time+'</div><div class="message-date text-muted">'+response.date+'</div></div>');
			    			}
		    				else if(response.sender==sessionStorage.getItem('u2_name') && response.receiver== sessionStorage.getItem('uname')){
						   		$('#chatarea1').append('<div class="message-row other-message"><div class="message-text"><a href="http://thenewbieprojects.com/getfile.php?u='+response.message+'" target="_blank">'+response.message+'</a></div><div class="message-time text-muted">'+response.time+'</div><div class="message-date text-muted">'+response.date+'</div></div>');
						   	}
					   	}
					   	else {
						   	if(response.sender==sessionStorage.getItem('uname') && response.receiver==sessionStorage.getItem('u2_name')){
						   		$('#chatarea1').append('<div class="message-row you-message"><div class="message-text text-white">'+response.text+'</div><div class="message-time text-muted">'+response.time+'</div><div class="message-date text-muted">'+response.date+'</div></div>');
			    			}
		    				else if(response.sender==sessionStorage.getItem('u2_name') && response.receiver== sessionStorage.getItem('uname')){
						   		$('#chatarea1').append('<div class="message-row other-message"><div class="message-text text-white">'+response.text+'</div><div class="message-time text-muted">'+response.time+'</div><div class="message-date text-muted">'+response.date+'</div></div>');
						   	}
					   	}
					}
	    			var chatarea = document.getElementById("chatarea1");
					chatarea.scrollTop = chatarea.scrollHeight - chatarea.clientHeight;    
				};
				$(document).on('change','#file',function(){
					var property = document.getElementById("file").files[0];
					var sender = sessionStorage.getItem('uname');
	       			var receiver = sessionStorage.getItem('u2_name');
					var ip = sessionStorage.getItem('ipaddr');					
	       			var os = navigator.platform;
	  				var form_data = new FormData();
	  				$.getJSON('https://api.ipgeolocation.io/ipgeo?apiKey=ae96a7f2429e46a19be617ee21b662d2', function(data) {
	  					sessionStorage.setItem('ipaddr', data["ip"]);
					});
	  				form_data.append("file", property);
	  				form_data.append("sender", sender);
	  				form_data.append("receiver", receiver);
	  				form_data.append("ip", ip);
	  				form_data.append("os", os);
	  				$.ajax({
	  					url:"chatroom_upload.php",
	  					method:"POST",
	  					data: form_data,
	  					contentType: false,
	  					processData: false,
	  					cache: false,
	  					success:function(data){
	  						var json_data2 = {'message':data,'sender':sender,'receiver':receiver,'type':'file','status':'0'};
          					var json_data3 = JSON.stringify(json_data2);
          					if(data!=0 || data!="failure"){
          					    socket.send(json_data3);
          					}
	  					}
	  				});
				});
        	function block(){
        		var user1 = sessionStorage.getItem('uname');
	       		var user2 = sessionStorage.getItem('u2_name');
	       		if(document.getElementById("block_").innerHTML=="Block"){
	       			$.post("chatroom_block.php", {user1: user1, user2: user2}, function(data, status){
	       				if(data=="1"){
	       					document.getElementById("block_").innerHTML = "Unblock";
	       					document.getElementById("msg").disabled = true;
	       					document.getElementById("file").disabled = true;
	       					document.getElementById("mic3").disabled = true;
	       					$('#chatarea1').append('<div><p class="mb-1 text-centered text-white" style="text-align:center">'+'You Blocked '+user2+'</p></div>');
	       					var chatarea = document.getElementById("chatarea1");
							chatarea.scrollTop = chatarea.scrollHeight - chatarea.clientHeight;
							var json_data4 = {'status':'1','sender':user1,'receiver':user2,'block_status':'block'};
          					var json_data5 = JSON.stringify(json_data4);
          					socket.send(json_data5);
	       				}
	  				});
	       		}
	       		else if(document.getElementById("block_").innerHTML=="Unblock"){
	       			$.post("chatroom_unblock.php", {user1: user1, user2: user2}, function(data, status){
	       				if(data=="1"){
	       					document.getElementById("block_").innerHTML = "Block";
	       					document.getElementById("msg").disabled = false;
	       					document.getElementById("file").disabled = false;
	       					document.getElementById("mic3").disabled = false;
	       					$('#chatarea1').append('<div><p class="mb-1 text-centered text-white" style="text-align:center">'+'You Unblocked '+user2+'</p></div>');
	       					var chatarea = document.getElementById("chatarea1");
							chatarea.scrollTop = chatarea.scrollHeight - chatarea.clientHeight;
							var json_data4 = {'status':'1','sender':user1,'receiver':user2,'block_status':'unblock'};
          					var json_data5 = JSON.stringify(json_data4);
          					socket.send(json_data5);
	       				}
	  				});
	       		}	
        	}
        	function check_block(){
        		var user1 = sessionStorage.getItem('uname');
	       		var user2 = sessionStorage.getItem('u2_name');
	       		$.post("chatroom_block_touch.php", {user1: user1, user2: user2}, function(data, status){
	       			if(data=="1"){
	       				document.getElementById("block_").innerHTML = "Unblock";
	       				$('#chatarea1').append('<div><p class="mb-1 text-centered text-white" style="text-align:center">'+'You Blocked '+user2+'</p></div>');
	       				document.getElementById("msg").disabled = true;
	       				document.getElementById("file").disabled = true;
	       				document.getElementById("mic3").disabled = true;
	       			}
	       			if(data=="2"){
	       				$('#chatarea1').append('<div><p class="mb-1 text-centered text-white" style="text-align:center">'+'You have been Blocked by '+user2+'</p></div>');
	       				document.getElementById("msg").disabled = true;
	       				document.getElementById("file").disabled = true;
	       				document.getElementById("mic3").disabled = true;
	       				document.getElementById("block_").disabled = true;
	       			}
	       			var chatarea = document.getElementById("chatarea1");
					chatarea.scrollTop = chatarea.scrollHeight - chatarea.clientHeight;
	  			});
        	}
        	
		</script>
	</body>
</html>
