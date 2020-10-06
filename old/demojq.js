$(document).ready(function(){
    let loginId , pass;
    $("#submit").click(function(){
        loginId = $("#loginId").text();
        pass = $("#pass").text();
        cookie.set("loginId", loginId);
        cookie.set("pass", pass );

    });
});