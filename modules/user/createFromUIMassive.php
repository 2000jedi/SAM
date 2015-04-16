<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/16/15
 * Time: 19:36
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$result = checkForceQuit();

$admin = $result->username;

if ($admin != "t001"){
    die("Permission Denied!");
}else{
    ?>
    <form action='/modules/user/massiveCreateUser.php' method="post">
        <div>
            <label>classprefix</label>
            <input name="classprefix" />
        </div>
        <input type="submit" />
    </form>
<?php
}
?>