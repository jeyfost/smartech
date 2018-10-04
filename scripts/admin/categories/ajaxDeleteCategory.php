<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 04.10.2018
 * Time: 17:26
 */

include ("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$categoryCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_shop_categories WHERE id = '".$id."'");
$categoryCheck = $categoryCheckResult->fetch_array(MYSQLI_NUM);

if($categoryCheck[0] > 0) {
    $subcategoryResult = $mysqli->query("SELECT * FROM st_shop_subcategories WHERE category_id = '".$id."'");
    while($subcategory = $subcategoryResult->fetch_assoc()) {
        $mysqli->query("DELETE FROM st_shop_subcategories WHERE id = '".$subcategory['id']."'");
    }

    $goodResult = $mysqli->query("SELECT * FROM st_shop WHERE category_id = '".$id."'");
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

    if($mysqli->query("DELETE FROM st_shop_categories WHERE id = '".$id."'")) {
        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "id";
}