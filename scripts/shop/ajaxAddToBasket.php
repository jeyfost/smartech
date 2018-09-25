<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 24.09.2018
 * Time: 15:00
 */

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$ip = real_ip();

$goodCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_shop WHERE id = '".$id."'");
$goodCheck = $goodCheckResult->fetch_array(MYSQLI_NUM);

if($goodCheck[0] > 0) {
    $goodCountResult = $mysqli->query("SELECT quantity FROM st_basket WHERE good_id = '".$id."' AND ip = '".$ip."'");
    $goodCount = $goodCountResult->fetch_array(MYSQLI_NUM);

    if($goodCount[0] > 0) {
        $quantity = $goodCount[0] + 1;

        if($mysqli->query("UPDATE st_basket SET quantity = '".$quantity."' WHERE good_id = '".$id."' AND ip = '".$ip."'")) {
            echo "ok update";
        } else {
            echo "failed";
        }
    } else {
        if($mysqli->query("INSERT INTO st_basket (ip, good_id, quantity) VALUES ('".$ip."', '".$id."', '1')")) {
            echo "ok insert";
        } else {
            echo "failed";
        }
    }
} else {
    echo "id";
}