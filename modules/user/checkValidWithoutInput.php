<?php
/**
 * Created by PhpStorm.
 * User: 2000jedi
 * Date: 2016/12/6
 * Time: 下午8:44
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

if ( isset($_COOKIE['username']) and isset($_COOKIE['password']) ) {
    $check = checkValid($_COOKIE["username"], $_COOKIE["password"]);
    if ( $check == false) {
        echo '0';
    }else{
        echo '1';
    }
}else{
    echo '0';
}
