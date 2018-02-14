<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 12.02.2018
 * Time: 16:44
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$idCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_catalogue WHERE id = '".$id."'");
$idCheck = $idCheckResult->fetch_array(MYSQLI_NUM);

if($idCheck[0] > 0) {
    $goodResult = $mysqli->query("SELECT * FROM st_catalogue WHERE id = '".$id."'");
    $good = $goodResult->fetch_assoc();

    $photosCountResult = $mysqli->query("SELECT COUNT(id) FROM st_photos WHERE good_id = '".$good['id']."'");
    $photosCount = $photosCountResult->fetch_array(MYSQLI_NUM);

    if($photosCount[0] > 0) {
        $photoResult = $mysqli->query("SELECT * FROM st_photos WHERE id = '".$good['id']."'");
        while($photo = $photoResult->fetch_assoc()) {
            if($mysqli->query("DELETE FROM st_photos WHERE id = '".$photo['id']."'")) {
                unlink("../../../img/photos/big/".$photo['photo']);
                unlink("../../../img/photos/small/".$photo['preview']);
            }
        }
    }

    if($mysqli->query("DELETE FROM st_catalogue WHERE id = '".$good['id']."'")) {
        unlink("../../../img/catalogue/big/".$good['photo']);
        unlink("../../../img/catalogue/small/".$good['preview']);

        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "id";
}