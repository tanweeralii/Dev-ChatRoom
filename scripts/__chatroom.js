$(document).ready(function(){
  const request = new XMLHttpRequest;
  request.onload = () => {
    let responseObject = null;

    try{
      responseObject = JSON.parse(request.responseText);
    }
    catch(e){
      console.error('could not parse JSON!');
    }

    if(responseObject){
      handleresponse(responseObject);
      
    }
  }
  request.open('post', 'chatroom_uname.php');
  request.send();
})
function handleresponse(responseObject){
  var uname = sessionStorage.getItem('uname');
  for(var i = 0; i<responseObject.count; i++){
    if(uname != responseObject.users[i][0]){
      $('#users_name').prepend('<button type="button" class="button5 pl-2" id="'+i+'" onclick="tanweer('+i+')"><image class="img-rounded image2" src="images/user.png" style="width:40px;height:40px;"><text class="pl-2 text-white font-weight-bold" id="hello'+i+'">'+responseObject.users[i][0]+'</text><img src="images/green.png" class="img-circle image10 pl-2" style="width:30px; height:15px;"></button>');
    }
  } 
}
function tanweer(num){
  var chat_with_user = document.getElementById(num).innerHTML;
  var chat_with = document.getElementById("hello"+num).innerHTML;
  sessionStorage.setItem('u2_name', chat_with);
  $.get('load1.php',{
    chat_with_user: chat_with_user
  }, function(data, status){
    $("#left").html(data);
  })
  const logout = document.getElementById("logout2");
  logout.addEventListener("click", function(){
    sessionStorage.clear();
    localStorage.clear();
    window.location = "Login.html";
  })
}
$(document).ready(function(){
  $("#search").keyup(function(){
    var search = $(this).val();
    var search1 = search.toLowerCase();
          
    const buttons = document.querySelector('.users_name');
    const users = buttons.getElementsByTagName('button');
    Array.from(users).forEach(function(button){
      const button1 = button.textContent;
      if(button1.toLowerCase().indexOf(search1) != -1){
        button.style.display = 'block';
      }   
      else{
        button.style.display = 'none';
      }
    })
  })
  var u_name = sessionStorage.getItem('uname');
  $("#this_user").html(u_name);
})


