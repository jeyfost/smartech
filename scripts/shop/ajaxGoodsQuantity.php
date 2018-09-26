<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 26.09.2018
 * Time: 8:55
 */

include("../connect.php");

$count = 0;

$goodResult = $mysqli->query("SELECT * FROM st_basket WHERE ip = '".real_ip()."'");
while($good = $goodResult->fetch_assoc()) {
    $count++;
}

echo $count;