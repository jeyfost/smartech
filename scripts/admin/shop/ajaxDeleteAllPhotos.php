<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 26.09.2018
 * Time: 13:45
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$idCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_shop WHERE id = '".$id."'");
$idCheck = $idCheckResult->fetch_array(MYSQLI_NUM);

if($idCheck[0] > 0) {
    $photoResult = $mysqli->query("SELECT * FROM st_shop_photos WHERE good_id = '".$id."'");

    if($mysqli->query("DELETE FROM st_shop_photos WHERE good_id = '".$id."'")) {
        while($photo = $photoResult->fetch_assoc()) {
            unlink("../../../img/shop/big/".$photo['photo']);
            unlink("../../../img/shop/small/".$photo['preview']);
        }

        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "id";
}