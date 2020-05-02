$(document).ready(function(){
   	$(window).scroll(function(){
   	  if($(window).scrollTop() > 100){
   	      $(".navbar").css({"background-color":"grey"});   
   	  }
   	  else{
   	      $(".navbar").css({"background-color":"transparent"});
   	  }
   	})
})
function myfunction(){
	var x = document.getElementById("password");
	var y = document.getElementById("confirm_password");
	if (x.type === "password" && y.type=="password") {
	  x.type = "text";
	  y.type = "text";
	  document.getElementById("img").src = "images/unlocked.png";
	} else {
	  x.type = "password";
	  y.type = "password"
	  document.getElementById("img").src = "images/locked.png";
	}
}
const form = {
    first_name: document.getElementById('first_name'),
    last_name: document.getElementById('last_name'),
    email: document.getElementById('email'),
    password: document.getElementById('password'),
    confirm_password: document.getElementById('confirm_password'),
    message: document.getElementById('internal-error'),
    submit: document.getElementById('register')
};
form.submit.addEventListener('click', () => {
    const request = new XMLHttpRequest();

    var u_namee = form.email.value.split('@');
    sessionStorage.setItem('uname', u_namee[0] );

    request.onload = () => {
      	let responseObject = null;

       	try{
         	responseObject = JSON.parse(request.responseText);
       	}catch(e){
         	console.error('Could not parse JSON!');
       	}

        if(responseObject){
          handleResponse(responseObject);
        }
    }
    const requestData = `first_name=${form.first_name.value}&last_name=${form.last_name.value}&email=${form.email.value}&password=${form.password.value}&confirm_password=${form.confirm_password.value}`;
    request.open('post', 'chatroom_register.php');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);
})
function handleResponse(responseObject){
    if(responseObject.ok){
      location.href = 'chatroom.html';
    }
    else{
      	while(form.message.firstChild){
        	form.message.removeChild(form.message.firstChild);
      	}

      	responseObject.message.forEach((message) => {
            const li = document.createElement('li');
            li.textContent = message;
            form.message.appendChild(li);
        })
        form.message.style.display = "block";
    }
}
