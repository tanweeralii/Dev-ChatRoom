$(document).ready(function(){
  $(window).scroll(function(){
    if($(window).scrollTop() > 100){
        $(".navbar").css({"background-color":"grey"});   
    }
    else{
        $(".navbar").css({"background-color":"transparent"});
    }
  });
  var checkbox = document.querySelector('input[name=myCheckbox]');
  checkbox.addEventListener( 'change', function(event) {
    if(checkbox.checked) {
        sessionStorage.setItem('set',1);
    }
    else{
      sessionStorage.setItem('set',0);
    }
  });
})
const form = {
  email: document.getElementById('email'),
  password: document.getElementById('password'),
  message: document.getElementById('internal-error'),
  submit: document.getElementById('login')
};
form.submit.addEventListener('click', () => {
  const request = new XMLHttpRequest();

  var u_name = form.email.value.split('@');
  sessionStorage.setItem('uname', u_name[0]);

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
  const requestData = `email=${form.email.value}&password=${form.password.value}`;
        

  request.open('post', 'chatroom_login.php');
  request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  request.send(requestData);
})
function handleResponse(responseObject,uname){
  if(responseObject.ok){
    if(sessionStorage.getItem('set')==1){
      var uname2 = sessionStorage.getItem('uname');
      localStorage.setItem('uname', uname2);
    }
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