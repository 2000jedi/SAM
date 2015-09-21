<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/14/15
 * Time: 21:25
 */


$result = checkForceQuit();

$admin = $result->username;

if ($admin != "t001"){
    die("Permission Denied!");
}else{
    ?>
    <form action='/modules/user/create.php' method="post" style="margin: 0.5em">
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
        <div style="text-align: center; margin: 1em">
            <input type="submit" class="pure-button pure-button-primary" />
        </div>
    </form>
<?php
}
?>