<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 12.02.2018
 * Time: 16:15
 */

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$idCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_catalogue WHERE id = '".$id."'");
$idCheck = $idCheckResult->fetch_array(MYSQLI_NUM);

if($idCheck[0] > 0) {
    $photoResult = $mysqli->query("SELECT * FROM st_photos WHERE good_id = '".$id."'");

    if($mysqli->query("DELETE FROM st_photos WHERE good_id = '".$id."'")) {
        while($photo = $photoResult->fetch_assoc()) {
            unlink("../../img/photos/big/".$photo['photo']);
            unlink("../../img/photos/small/".$photo['preview']);
        }

        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "id";
}