$(function (){
    if ($.cookie('loginId') === "" || $.cookie('loginId') == null ){

    }else {
        let loginId = $.cookie('loginId');
        let pass = $.cookie('pass');
        let $form = $('<form/>').append(
            $('<input/>', {name: 'loginId'}).val(loginId),
            $('<input/>', {name: 'pass'}).val(pass)
        );
        getLoginCreds(loginId,pass,$form);
    }
});

function getLoginCreds(loginId,pass,$form) {
    $.ajax({
        type: 'POST',
        //url:'old/api2test.php',
        url: 'v1/loginapi.php',
        async:false,
        contentType: 'application/x-www-form-urlencoded',
        data: $form.serialize(),
        //data: $( this ).serialize(),
        success: function(data) {
            //console.log(data);
            try {
                var res = JSON.parse(data);
                var data = res.data;
                if (data.id != null && res.status=="success"){
                    window.location.replace("http://d890a0cac6.nxcli.net/suraj/profilepage.html");
                }else {
                    alert(data);
                }
            }catch (e){
                alert(e);
            }
        },error:function (){
            alert("failed");
        }
    });
}
$(document).ready(function() {
    $("form").on("submit", function(event) {
        loginId = $("#loginId").val();
        pass = $("#pass").val();
        if (loginId!=="" && pass !=="") {
            $.cookie('loginId', loginId, {expires: 7, path: '/'});
            $.cookie('pass', pass, {expires: 7, path: '/'});
            let form = $(this);
            getLoginCreds(loginId,pass,form);
        }
    });
});
