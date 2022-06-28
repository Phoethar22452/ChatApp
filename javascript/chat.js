const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
incoming_id = form.querySelector(".incoming_id").value,
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e)=>{
    e.preventDefault();
}

sendBtn.onclick = ()=>{
     //start AJAX
     let xhr = new XMLHttpRequest(0);
     xhr.open("POST","php/insert-chat.php",true);
     xhr.onload = ()=>{
         if(xhr.readyState === XMLHttpRequest.DONE){
             if(xhr.status === 200){
                inputField.value = "";
             }
         }
     }
     //WE Have to send the form data through ajax to php
     let formData = new FormData(form);
     xhr.send(formData);
}


chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
  }
  chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
  }
  
setInterval(()=>{
    //start AJAX
    let xhr = new XMLHttpRequest(0);
    xhr.open("POST","php/get-chat.php",true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                chatBox.innerHTML = data;
                if(!chatBox.classList.contains("active")){
                    scrollToBottom();
                  }
            }
        }
    }
     //WE Have to send the form data through ajax to php
     let formData = new FormData(form);
     xhr.send(formData);
    },500);//this function will frequently run after every 500ms

    function scrollToBottom(){
        chatBox.scrollTop = chatBox.scrollHeight;
      }