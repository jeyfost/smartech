<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 26.09.2018
 * Time: 14:00
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$idCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_shop WHERE id = '".$id."'");
$idCheck = $idCheckResult->fetch_array(MYSQLI_NUM);

if($idCheck[0] > 0) {
    $goodResult = $mysqli->query("SELECT * FROM st_shop WHERE id = '".$id."'");
    $good = $goodResult->fetch_assoc();

    $photosCountResult = $mysqli->query("SELECT COUNT(id) FROM st_shop_photos WHERE good_id = '".$good['id']."'");
    $photosCount = $photosCountResult->fetch_array(MYSQLI_NUM);

    if($photosCount[0] > 0) {
        $photoResult = $mysqli->query("SELECT * FROM st_shop_photos WHERE good_id = '".$good['id']."'");
        while($photo = $photoResult->fetch_assoc()) {
            if($mysqli->query("DELETE FROM st_shop_photos WHERE id = '".$photo['id']."'")) {
                unlink("../../../img/shop/big/".$photo['photo']);
                unlink("../../../img/shop/small/".$photo['preview']);
            }
        }
    }

    if($mysqli->query("DELETE FROM st_shop WHERE id = '".$good['id']."'")) {
        unlink("../../../img/shop/big/".$good['photo']);
        unlink("../../../img/shop/small/".$good['preview']);

        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "id";
}