function profileData(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText);
            //document.getElementById("demo").innerHTML = myObj.name;
            document.getElementById("prod-name").innerHTML=myObj.Peter;
            document.getElementById("prod-price").innerHTML=myObj.Ben;
            document.getElementById("prod-sku").innerHTML=myObj.Ben;
        }
    };
    xmlhttp.open("GET", "testapi.php", true);
    xmlhttp.send();

}
