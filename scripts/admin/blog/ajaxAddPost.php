<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 04.10.2018
 * Time: 16:10
 */

include("../../connect.php");
include("../image.php");

$req = false;
ob_start();

$id = $mysqli->real_escape_string($_POST['category']);
$name = $mysqli->real_escape_string($_POST['name']);
$url = $mysqli->real_escape_string($_POST['url']);
$description = $mysqli->real_escape_string(nl2br($_POST['description']));
$text = $mysqli->real_escape_string($_POST['text']);

if(!empty($_FILES['preview']['tmp_name'])) {
    if(!is_numeric($url)) {
        $url = str_replace(" ", "-", $url);
        $url = str_replace("_", "-", $url);

        $urlCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_blog WHERE url = '".$url."'");
        $urlCheck = $urlCheckResult->fetch_array(MYSQLI_NUM);

        if($urlCheck[0] == 0) {
            if($_FILES['preview']['error'] == 0 and substr($_FILES['preview']['type'], 0, 5) == "image") {
                $previewTmpName = $_FILES['preview']['tmp_name'];
                $previewName = randomName($previewTmpName);
                $previewDBName = $previewName.".".substr($_FILES['preview']['name'], count($_FILES['preview']['name']) - 4, 4);
                $previewUploadDir = "../../../img/blog/small/";
                $previewUpload = $previewUploadDir.$previewDBName;

                $photoTmpName = $_FILES['preview']['tmp_name'];
                $photoName = randomName($photoTmpName);
                $photoDBName = $photoName.".".substr($_FILES['preview']['name'], count($_FILES['preview']['name']) - 4, 4);
                $photoUploadDir = "../../../img/blog/big/";
                $photoUpload = $photoUploadDir.$photoDBName;

                if($mysqli->query("INSERT INTO st_blog (category_id, name, description, text, date, preview, photo, url) VALUES ('".$id."', '".$name."', '".$description."', '".$text."', '".date("Y-m-d H:i:s")."', '".$previewDBName."', '".$photoDBName."', '".$url."')")) {
                    copy($photoTmpName, $photoUpload);

                    resize($previewTmpName, 300);
                    move_uploaded_file($previewTmpName, $previewUpload);

                    echo "ok";
                } else {
                    echo "failed";
                }
            } else {
                echo "preview";
            }
        } else {
            echo "url";
        }
    } else {
        echo "numeric";
    }
} else {
    echo "preview empty";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;