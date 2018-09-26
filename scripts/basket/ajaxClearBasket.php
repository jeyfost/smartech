<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 25.09.2018
 * Time: 20:47
 */

include("../connect.php");

$basketCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_basket WHERE ip = '".real_ip()."'");
$basketCheck = $basketCheckResult->fetch_array(MYSQLI_NUM);

if($basketCheck[0] > 0) {
    if($mysqli->query("DELETE FROM st_basket WHERE ip = '".real_ip()."'")) {
        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "empty";
}