/**
 * Created by jedi on 16-12-6.
 */

function checkValid() {
    var xmlHttp;
    try{
        xmlHttp = new XMLHttpRequest();
    }
    catch (e){
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlHttp.onreadystatechange = function(){
        if (xmlHttp.readyState == 4){
            if (xmlHttp.responseText == '0')
                window.location.href = '/login.php';
        }
    }

    xmlHttp.open("GET", "/modules/user/checkValidWithoutInput.php", true);
    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlHttp.send();
}

checkValid();
