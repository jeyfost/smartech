<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 26.09.2018
 * Time: 9:44
 */

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$quantity = $mysqli->real_escape_string($_POST['quantity']);

if($mysqli->query("UPDATE st_basket SET quantity = '".$quantity."' WHERE good_id = '".$id."' AND ip = '".real_ip()."'")) {
    $total = 0;

    $basketResult = $mysqli->query("SELECT * FROM st_basket WHERE ip = '".real_ip()."'");
    while($basket = $basketResult->fetch_assoc()) {
        $goodResult = $mysqli->query("SELECT * FROM st_shop WHERE id = '".$basket['good_id']."'");
        $good = $goodResult->fetch_assoc();

        $total += $good['price'] * $basket['quantity'];
    }

    echo $total;
} else {
    echo "failed";
}