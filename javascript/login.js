//console.log("Hello");
const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input");
errorText = form.querySelector(".error-txt");

form.onsubmit = (e)=>{
    e.preventDefault();
}

continueBtn.onclick = ()=>{
    //start AJAX
    let xhr = new XMLHttpRequest(0);
    xhr.open("POST","php/login.php",true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(data == "success"){
                    location.href = "users.php";
                }else{
                    errorText.style.display = "block";
                    errorText.textContent = data;
                }
            }
        }
    }
    //WE Have to send the form data through ajax to php
    let formData = new FormData(form);
    xhr.send(formData);
}