<?php
/**
 * Created by VS Code.
 * User: Jedi
 * Date: 04/07/17
 * Time: 00:00
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$result = checkForceQuit();

$admin = $result->username;

if ($admin != "t001"){
    die("Permission Denied!");
}
?>

<html>
<head>
    <title> Add Club </title>
	<script src="/framework/js/jq.js"></script>
</head>
<body>
    <h1>
        Add A Club
    </h1>
    <form>
        <label for="name">Name: </label>
        <input type="text" name="name" id="name" />
        <br />
        <label for="organizer">Organizer: </label>
        <input type="text" name="organizer" id="organizer" />
        <br />
        <label for="introduction">Introduction: </label>
        <br />
        <textarea name="introduction" id="introduction" style="width:500px;height:300px;">
        </textarea>
    </form>
    <button id="submit" onclick="submit();">
        submit
    </button>
</body>
<script>
    function submit(){
        /*
        axios.post('/modules/club/addClub.php', {
            name: document.getElementById("name").value,
            organizer: document.getElementById("organizer").value,
            introduction: document.getElementById("introduction").value
        }).then(function(data){
            alert("Success: " + data.data);
        }).catch(function(error){
            alert("Error: " + error.data);
        });*/
        $.post("/modules/club/addClub.php", {
            name: $("#name").val(),
            organizer: $("#organizer").val(),
            introduction: $("#introduction").val()
        }, function() {})
    }
</script>
</html>
