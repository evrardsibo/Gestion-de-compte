const newpassword = document.querySelector('#newpassword')
const confirmpassword = document.querySelector('#confirmpassword')
const alert = document.querySelector('#alert')



newpassword.addEventListener("keyup", function(){
    verificationpassword()
})

confirmpassword.addEventListener("keyup", function(){
    verificationpassword()
})

function verificationpassword(){
    if(newpassword.value === confirmpassword.value){
        document.querySelector('#btn').disabled = false;
        alert.classList.add("d-none");
        
    }else{
        document.querySelector('#btn').disabled = true;
        alert.classList.remove("d-none");
    }
}