<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 26.09.2018
 * Time: 12:23
 */

include("../../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$textResult = $mysqli->query("SELECT description FROM st_shop WHERE id = '".$id."'");
$text = $textResult->fetch_array(MYSQLI_NUM);

echo $text[0];