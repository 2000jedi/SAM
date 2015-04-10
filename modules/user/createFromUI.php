<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/14/15
 * Time: 21:25
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$result = checkForceQuit();

$admin = $result->username;

if ($admin != "t001"){
    die("Permission Denied!");
}else{
    ?>
    <form action='/modules/user/create.php' method="post">
        <div>
            <label>username</label>
            <input name="username" />
        </div>
        <div>
            <label>type</label>
            <input name="type" />
        </div>
        <div>
            <label>subject</label>
            <input name="subject" />
        </div>
        <input type="submit" />
    </form>
<?php
}
?>