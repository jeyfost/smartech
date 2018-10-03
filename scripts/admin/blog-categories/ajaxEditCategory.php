<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 03.10.2018
 * Time: 15:49
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$name = $mysqli->real_escape_string($_POST['name']);
$url = $mysqli->real_escape_string($_POST['url']);

if(!is_numeric($url)) {
    $url = str_replace(" ", "-", $url);
    $url = str_replace("_", "-", $url);

    $urlCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_blog_categories WHERE url = '".$url."' AND id <> '".$id."'");
    $urlCheck = $urlCheckResult->fetch_array(MYSQLI_NUM);

    if($urlCheck[0] == 0) {
        $nameCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_blog_categories WHERE id <> '".$id."' AND name = '".$name."'");
        $nameCheck = $nameCheckResult->fetch_array(MYSQLI_NUM);

        if($nameCheck[0] == 0) {
            if($mysqli->query("UPDATE st_blog_categories SET name = '".$name."', url = '".$url."' WHERE id = '".$id."'")) {
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