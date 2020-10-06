function userLogin() {
    let user = document.forms["loginFrom"]["loginId"].value;
    let pass = document.forms["loginFrom"]["pass"].value;
    localStorage.setItem("loginId", user);
    localStorage.setItem("pass", pass);
}

function userLogout(){
    localStorage.clear();
    window.location.replace("http://d890a0cac6.nxcli.net/suraj/index.html");
}
function redirectToProfilePage(){
    if(localStorage.getItem('loginId')== null || localStorage.getItem('loginId') == ""){
     /*   window.location.replace("http://d890a0cac6.nxcli.net/suraj/index.html");*/
    }else {
        window.location.replace("http://d890a0cac6.nxcli.net/suraj/profile.html");
    }
}
function redirectToLoginPage() {
    if (localStorage.getItem('loginId') == null || localStorage.getItem('loginId') == "") {
        window.location.replace("http://d890a0cac6.nxcli.net/suraj/index.html");
    }
}
function getProfileData(){
            let user =  localStorage.getItem("loginId");
            let pass=  localStorage.getItem("pass");
            document.getElementById("ploginId").innerHTML=user;
            document.getElementById("ppass").innerHTML=pass;
}
