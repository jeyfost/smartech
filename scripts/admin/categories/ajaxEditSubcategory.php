<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 01.10.2018
 * Time: 11:22
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['subcategoryID']);
$name = $mysqli->real_escape_string($_POST['subcategoryName']);
$url = $mysqli->real_escape_string($_POST['subcategoryURL']);


if(!empty($url)) {
    if (!is_numeric($url)) {
        $url = str_replace(" ", "-", $url);
        $url = str_replace("_", "-", $url);

        $urlCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_shop_subcategories WHERE url = '" . $url . "' AND id <> '" . $id . "'");
        $urlCheck = $urlCheckResult->fetch_array(MYSQLI_NUM);

        if ($urlCheck[0] == 0) {
            if($mysqli->query("UPDATE st_shop_subcategories SET name = '".$name."', url = '".$url."' WHERE id = '".$id."'")) {
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