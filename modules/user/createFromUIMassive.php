<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/16/15
 * Time: 19:36
 */


$result = checkForceQuit();

$admin = $result->username;

if ($admin != "t001"){
    die("Permission Denied!");
}else{
    ?>
    <form action='/modules/user/massiveCreateUser.php' method="post" style="margin: 0.5em">
        <div>
            <label>classprefix</label>
            <input name="classprefix" />
        </div>
        <div style="text-align: center; margin: 1em">
            <input type="submit" class="pure-button pure-button-primary" />
        </div>
    </form>
<?php
}
?>