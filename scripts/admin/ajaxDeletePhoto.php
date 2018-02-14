<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 08.02.2018
 * Time: 10:25
 */

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$photoCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_photos WHERE id = '".$id."'");
$photoCheck = $photoCheckResult->fetch_array(MYSQLI_NUM);

if($photoCheck[0] > 0) {
    $photoResult = $mysqli->query("SELECT * FROM st_photos WHERE id = '".$id."'");
    $photo = $photoResult->fetch_assoc();

    if($mysqli->query("DELETE FROM st_photos WHERE id = '".$id."'")) {
        unlink("../../img/photos/big/".$photo['photo']);
        unlink("../../img/photos/small/".$photo['preview']);

        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "id";
}