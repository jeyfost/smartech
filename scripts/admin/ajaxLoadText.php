<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 08.02.2018
 * Time: 11:24
 */

include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

$textResult = $mysqli->query("SELECT text FROM st_catalogue WHERE id = '".$id."'");
$text = $textResult->fetch_array(MYSQLI_NUM);

echo $text[0];