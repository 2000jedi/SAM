<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/15/15
 * Time: 12:30
 */

function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}
function equalFloat($a, $b){
    if (abs(($a-$b)/$b) < 0.00001) {
        return true;
    }else{
        return false;
    }
}

?>