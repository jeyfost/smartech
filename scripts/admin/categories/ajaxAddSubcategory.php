<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 04.10.2018
 * Time: 18:17
 */

include("../../connect.php");

$categoryID = $mysqli->real_escape_string($_POST['categoryID']);
$name = $mysqli->real_escape_string($_POST['name']);
$url = $mysqli->real_escape_string($_POST['url']);

if(!is_numeric($url)) {
    $url = str_replace(" ", "-", $url);
    $url = str_replace("_", "-", $url);

    $urlCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_shop_subcategories WHERE url = '".$url."'");
    $urlCheck = $urlCheckResult->fetch_array(MYSQLI_NUM);

    if($urlCheck[0] == 0) {
        $nameCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_shop_subcategories WHERE name = '".$name."' AND category_id = '".$categoryID."'");
        $nameCheck = $nameCheckResult->fetch_array(MYSQLI_NUM);

        if($nameCheck[0] == 0) {
            if($mysqli->query("INSERT INTO st_shop_subcategories (category_id, name, url) VALUES ('".$categoryID."', '".$name."', '".$url."')")) {
                echo "ok";
            } else {
                echo "failed";
            }
        } else {
            echo "name";
        }
    } else {
        echo "url";
    }
} else {
    echo "numeric";
}