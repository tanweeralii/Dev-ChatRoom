function dropdown() {
  document.getElementById("myDropdown").classList.toggle("show");
}
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
	    var os = navigator.platfor
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
        let responseObject = nul
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
        	