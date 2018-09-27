<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 27.09.2018
 * Time: 12:16
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$orderCheckResult = $mysqli->query("SELECT * FROM st_orders WHERE id = '".$id."'");
if($orderCheckResult->num_rows > 0) {
    $orderCheck = $orderCheckResult->fetch_assoc();

    if($orderCheck['accepted'] == 0) {
        if($mysqli->query("UPDATE st_orders SET accepted = '1' WHERE id = '".$id."'")) {
            echo "ok";
        } else {
            echo "failed";
        }
    } else {
        echo "accepted";
    }
} else {
    echo "id";
}