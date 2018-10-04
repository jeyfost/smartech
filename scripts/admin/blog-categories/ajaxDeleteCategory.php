<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 04.10.2018
 * Time: 16:34
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$categoryCheckResult = $mysqli->query("SELECT * FROM st_blog_categories WHERE id = '".$id."'");
$categoryCheck = $categoryCheckResult->fetch_array(MYSQLI_NUM);

if($categoryCheck[0] > 0) {
    $postResult = $mysqli->query("SELECT * FROM st_blog WHERE category_id = '".$id."'");
    while($post = $postResult->fetch_assoc()) {
        if($mysqli->query("DELETE FROM st_blog WHERE id = '".$post['id']."'")) {
            unlink("../../../img/blog/big/".$post['photo']);
            unlink("../../../img/blog/small/".$post['preview']);
        }
    }

    if($mysqli->query("DELETE FROM st_blog_categories WHERE id = '".$id."'")) {
        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "id";
}