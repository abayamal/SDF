var eye = document.getElementById('eye');
var eyeConfirm = document.getElementById('eyeConfirm');
var password = document.getElementById('password');
var confirmpassword = document.getElementById('confirm_password');
var showPassword = false;

eye.addEventListener("click",function(){
    if(showPassword == false){
        password.setAttribute("type","text");
        eye.classList.remove("fa-eye");
        eye.classList.add("fa-eye-slash");
        showPassword = true;
    } else {
        password.setAttribute("type","password");
        eye.classList.remove("fa-eye-slash");
        eye.classList.add("fa-eye");
        showPassword = false;
    }

});


eyeConfirm.addEventListener("click",function(){
    if(showPassword == false){
        confirmpassword.setAttribute("type","text");
        eyeConfirm.classList.remove("fa-eye");
        eyeConfirm.classList.add("fa-eye-slash");
        showPassword = true;
    } else {
        confirmpassword.setAttribute("type","password");
        eyeConfirm.classList.remove("fa-eye-slash");
        eyeConfirm.classList.add("fa-eye");
        showPassword = false;
    }

});