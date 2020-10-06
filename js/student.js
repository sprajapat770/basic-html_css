$(document).ready(function (){
    let res,i,length;
    getAllData();
    function getAllData(){
        let email,id,roll_no,fname;
        res = queryServer("GET",$(this));
        length = (res['data']).length;
        $('#tbody').empty();
        for(i=0;i<length;i++){
            let edtBtn = $('<button>Edit</button>').attr("id", "edt"+ i).attr("class","edtBtn");
            let delBtn = $('<button>Delete</button>').attr("id", "del"+i ).attr("class","delBtn");
            let t = $('<tr></tr>').attr("id","row"+i);

            id = res['data'][i]['id']==""? "": res['data'][i]['id'];
            roll_no = res['data'][i]['roll_no']==""? "": res['data'][i]['roll_no'];
            fname = res['data'][i]['fname']==""? "": res['data'][i]['fname'];
            email = res['data'][i]['email_id']==""? "": res['data'][i]['email_id'];
            $('#tbody').append(t[0].outerHTML);
            $("#row"+i).append("<td>" + roll_no + "</td><td>" + fname + "</td><td>" + email+ "</td><td>"+ edtBtn[0].outerHTML + "</td><td>"+ delBtn[0].outerHTML +"</td>");
        }
    }

    /*<td style='visibility: hidden;'>"+ res['data'][i]['id']+"</td>*/

    $(document).on("click",".edtBtn",function (){
        i = Number(this.id.slice(3));
        $(".popup-overlay.update-content").addClass("active");
        console.log($("#row"+i).children(0)[1].innerText);
        $("#uroll_no").val($("#row"+i).children(0)[0].innerText);
        $("#ufname").val($("#row"+i).children(0)[1].innerText);
        $("#uemail").val($("#row"+i).children(0)[2].innerText);
    });

    $(document).on("click",".delBtn",function (){
        i = Number(this.id.slice(3));
        $(".popup-overlay.delete-content").addClass("active");
    });

    $(".update-content  #upConfirm ").on("click", function() {
        let ok=1,k;
        for(k=0;k<length;k++){
            if (($("#uroll_no").val())==($("#row"+k).children(0)[0].innerText) && i != k) {
                ok=0;
                alert("duplicate roll no");
            }
            if (($("#uemail").val())==($("#row"+k).children(0)[2].innerText) && i != k){
                ok=0;
                alert("duplicate email id");
            }
        }

        if (ok==1){
            queryServer("PUT","#uform");
            getAllData();
        }
        $(".popup-overlay.update-content").removeClass("active");
    });

    $(".update-content  #upCancel").on("click", function() {
        $(".popup-overlay.update-content").removeClass("active");
    });

    $(" .delete-content  #delConfirm").on("click", function() {
        let form = $('<form/>').append(
            $('<input/>', {name: 'delroll_no'}).val($("#row"+i).children(0)[0].innerText)
        );
        let respo = queryServer("DELETE",form);
        getAllData();
        $(".popup-overlay.delete-content").removeClass("active");
    });

    $(".delete-content  #delCancel").on("click", function() {
        $(".popup-overlay.delete-content").removeClass("active");
    });

    $(" .buttons .insert ").on("click", function() {
        $(".popup-overlay.insert-content").addClass("active");
    });

    $(".insert-content #insConfirm ").on("click", function() {
        let ok=1,k;
        for(k=0;k<length;k++){
            if (($("#iroll_no").val())==($("#row"+k).children(0)[0].innerText) && i != k) {
                ok=0;
                alert("duplicate roll no");
            }
            if (($("#iemail").val())==($("#row"+k).children(0)[2].innerText) && i != k){
                ok=0;
                alert("duplicate email id");
            }

        }
        if (ok==1){
            console.log("entered");
            $('#insform').append(
                $('<input/>', {name: 'insert',type:"hidden"}).val("1")
            );

            queryServer("POST","#insform");
            getAllData();
        }
        $(".popup-overlay.insert-content").removeClass("active");
    });
    $(".insert-content #insCancel").on("click", function() {
        $(".popup-overlay.insert-content").removeClass("active");
    });

    function queryServer(method,form){
        let url="v1/studentapi.php";
        let res;
        $.ajax({
            url:url,
            async:false,
            type:method,
            contentType: 'application/x-www-form-urlencoded',
            data: $(form).serialize(),
            success:function (response){
                try{
                    res = JSON.parse(response);
                    console.log(res);
                }catch (e) {
                    alert(e);
                }
            },
            error:function (){
                alert("connection error");
            }
        });
        return res;
    }
});


