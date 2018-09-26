<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 25.09.2018
 * Time: 20:40
 */

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$goodCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_basket WHERE good_id = '".$id."' AND ip = '".real_ip()."'");
$goodCheck = $goodCheckResult->fetch_array(MYSQLI_NUM);

if($goodCheck[0] > 0) {
    if($mysqli->query("DELETE FROM st_basket WHERE good_id = '".$id."' AND ip = '".real_ip()."'")) {
        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "id";
}