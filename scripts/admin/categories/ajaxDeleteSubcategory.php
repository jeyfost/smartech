<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 04.10.2018
 * Time: 17:39
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$subcategoryCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_shop_subcategories WHERE id = '".$id."'");
$subcategoryCheck = $subcategoryCheckResult->fetch_array(MYSQLI_NUM);

if($subcategoryCheck[0] > 0) {
    $goodResult = $mysqli->query("SELECT * FROM st_shop WHERE subcategory_id = '".$id."'");
    while($good = $goodResult->fetch_assoc()) {
        $photoResult = $mysqli->query("SELECT * FROM st_shop_photos WHERE good_id = '".$good['id']."'");
        while($photo = $photoResult->fetch_assoc()) {
            if($mysqli->query("DELETE FROM st_shop_photos WHERE id = '".$photo['id']."'")) {
                unlink("../../../img/shop/big/".$photo['photo']);
                unlink("../../../img/shop/small/".$photo['preview']);
            }
        }

        if($mysqli->query("DELETE FROM st_shop WHERE id = '".$good['id']."'")) {
            unlink("../../../img/shop/big/".$good['photo']);
            unlink("../../../img/shop/small/".$good['preview']);
        }
    }

    if($mysqli->query("DELETE FROM st_shop_subcategories WHERE id = '".$id."'")) {
        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "id";
}