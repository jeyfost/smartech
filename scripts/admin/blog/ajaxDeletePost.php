<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 04.10.2018
 * Time: 16:58
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$postCheckResult = $mysqli->query("SELECT * FROM st_blog WHERE id = '".$id."'");
$postCheck = $postCheckResult->fetch_array(MYSQLI_NUM);

if($postCheck[0] > 0) {
    $postResult = $mysqli->query("SELECT * FROM st_blog WHERE id = '".$id."'");
    $post = $postResult->fetch_assoc();

    if($mysqli->query("DELETE FROM st_blog WHERE id = '".$id."'")) {
        unlink("../../../img/blog/big/".$post['photo']);
        unlink("../../../img/blog/small/".$post['preview']);

        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "id";
}