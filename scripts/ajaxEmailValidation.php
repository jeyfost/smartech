<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 30.01.2018
 * Time: 13:51
 */

include("connect.php");

$email = $mysqli->real_escape_string($_POST['email']);

if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "ok";
} else {
    echo "failed";
}