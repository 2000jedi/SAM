/* Settings Module */
function changePassword(){
    var oldPass = $('#oldPass').val();
    var newPass1 = $('#newPass1').val();
    var newPass2 = $('#newPass2').val();

    if (newPass1 != newPass2){
        alert("Two passwords do not match.");
    }else if (newPass1.length < 6){
        alert("The new password is too short.");
    }else{
        $.post("/modules/user/changePassword.php",{oldPass: oldPass, newPass: newPass1}, function(data){
            if (data == "success"){
                alert("You have successfully changed your password.");
                $('#oldPass').val("");
                $('#newPass1').val("");
                $('#newPass2').val("");
            }else{
                alert(data);
            }
        });
    }
}
function changeEmail(){
    function validateEmail(email){
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
    var email = $('#newEmail').val();
    if (!validateEmail(email)){
        alert("Not a valid email.");
    }else{
        $.post("/modules/user/changeEmail.php",{email: email}, function(data){
            if (data == "success"){
                alert("You have successfully changed your email.");
                $('#newEmail').val("");
            }else{
                alert(data);
            }
        });
    }
}

function signOut(){
    function eraseCookie(name) {
        document.cookie = name + '=; Max-Age=0';
    }
    eraseCookie('username');
    eraseCookie('password');
    window.location.href = "/login.php";
}