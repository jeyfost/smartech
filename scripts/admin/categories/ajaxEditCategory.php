<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 01.10.2018
 * Time: 9:07
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['categoryID']);
$name = $mysqli->real_escape_string($_POST['categoryName']);
$url = $mysqli->real_escape_string($_POST['categoryURL']);

if(!empty($url)) {
    if(!is_numeric($url)) {
        $url = str_replace(" ", "-", $url);
        $url = str_replace("_", "-", $url);

        $urlCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_shop_categories WHERE url = '".$url."' AND id <> '".$id."'");
        $urlCheck = $urlCheckResult->fetch_array(MYSQLI_NUM);

        if($urlCheck[0] == 0) {
            if($mysqli->query("UPDATE st_shop_categories SET name = '".$name."', url = '".$url."' WHERE id = '".$id."'")) {
                echo "ok";
            } else {
                echo "failed";
            }
        } else {
            echo "url duplicate";
        }
    } else {
        echo "numeric";
    }
} else {
    echo "empty url";
}