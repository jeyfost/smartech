<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 03.10.2018
 * Time: 16:47
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$textResult = $mysqli->query("SELECT text FROM st_blog WHERE id = '".$id."'");
$text = $textResult->fetch_array(MYSQLI_NUM);

echo $text[0];