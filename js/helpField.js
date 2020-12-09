let userFields = document.getElementsByClassName("userLogin");
let helpFields = document.getElementsByClassName("helpField");
let ActivedField = -1;
for(let i = 0;i < userFields.length;i++){
    userFields[i].addEventListener("focus", function(){ ShowHelp(i); }, false);
    userFields[i].addEventListener("blur", function(){ hideFieldElements(); }, false);
}

function ShowHelp(id){
    helpFields[id].classList.remove("invisible");
    ActivedField = id;
}

function hideFieldElements(){
    if(ActivedField > -1){
        helpFields[ActivedField].classList.add("invisible");
    }
}