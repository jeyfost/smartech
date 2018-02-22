<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 07.02.2018
 * Time: 16:22
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);
$title = $mysqli->real_escape_string($_POST['title']);
$keywords = $mysqli->real_escape_string($_POST['keywords']);
$description = $mysqli->real_escape_string($_POST['description']);
$text = $mysqli->real_escape_string($_POST['text']);

if(substr($keywords, strlen($keywords) - 1, 1) == ",") {
    $keywords = substr($keywords, 0, strlen($keywords) - 1);
}

if($mysqli->query("UPDATE st_catalogue_categories SET title = '".$title."', keywords = '".$keywords."', description = '".$description."', text = '".$text."' WHERE id = '".$id."'")) {
    echo "ok";
} else {
    echo "failed";
}