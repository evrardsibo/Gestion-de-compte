let btnmodif = document.querySelector("#btnmodif");
let suppcompte = document.querySelector("#suppcompte");
let btnsupp = document.querySelector("#btnsupp");
let mail = document.querySelector("#mail");
let modifmail = document.querySelector("#modifmail");
let btnsuppcompte = document.querySelector("#btnsuppcompte");

btnmodif.addEventListener("click", function(){
    mail.classList.add("d-none");
    modifmail.classList.remove("d-none");
    
})
btnsuppcompte.addEventListener("click", function(){
    
    suppcompte.classList.remove('d-none');
})