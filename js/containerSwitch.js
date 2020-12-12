let divContainer =
{
    "login": document.getElementById("c-login"),
    "register": document.getElementById("c-register")
}
document.getElementById("login-switch").addEventListener("click", function(){ switchToContainer("login") }, false);
document.getElementById("register-switch").addEventListener("click", function(){ switchToContainer("register") }, false);

function switchToContainer(container){
    if(container === "login")
        divContainer['register'].classList.add("display-none")
    else
        divContainer['login'].classList.add("display-none")
    
    divContainer[container].classList.remove("display-none")
}