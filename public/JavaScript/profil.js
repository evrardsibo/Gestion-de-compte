let btnmodif = document.querySelector("#btnmodif");
let btnmodif1 = document.querySelector("#btnmodif1");
let mail = document.querySelector("#mail");
let modifmail = document.querySelector("#modifmail");
btnmodif.addEventListener("click", function(){
    mail.classList.add("d-none");
    modifmail.classList.remove("d-none");
})