<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 03.10.2018
 * Time: 17:19
 */

include("../../connect.php");
include("../image.php");

$req = false;
ob_start();

$id = $mysqli->real_escape_string($_POST['post']);
$name = $mysqli->real_escape_string($_POST['name']);
$url = $mysqli->real_escape_string($_POST['url']);
$description = $mysqli->real_escape_string(nl2br($_POST['description']));
$text = $mysqli->real_escape_string($_POST['text']);

$postResult = $mysqli->query("SELECT * FROM st_blog WHERE id = '".$id."'");
$post = $postResult->fetch_assoc();

if(!is_numeric($url)) {
    $url = str_replace(" ", "-", $url);
    $url = str_replace("_", "-", $url);

    $urlCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_blog WHERE url = '".$url."' AND id <> '".$id."'");
    $urlCheck = $urlCheckResult->fetch_array(MYSQLI_NUM);

    if($urlCheck[0] == 0) {
        if(!empty($_FILES['preview']['tmp_name'])) {
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

                if($mysqli->query("UPDATE st_blog SET preview = '".$previewDBName."', photo = '".$photoDBName."' WHERE id = '".$id."'")) {
                    unlink("../../../img/blog/big/".$post['photo']);
                    unlink("../../../img/blog/small/".$post['preview']);

                    copy($photoTmpName, $photoUpload);

                    image_resize($previewTmpName, $previewUpload, 300, 100);
                    move_uploaded_file($previewTmpName, $previewUpload);
                } else {
                    echo "preview upload";

                    $req = ob_get_contents();
                    ob_end_clean();
                    echo json_encode($req);

                    exit;
                }
            } else {
                echo "preview";

                $req = ob_get_contents();
                ob_end_clean();
                echo json_encode($req);

                exit;
            }
        }

        if($mysqli->query("UPDATE st_blog SET name = '".$name."', description = '".$description."', text = '".$text."', date = '".date('Y-m-d H:i:s')."', url = '".$url."' WHERE id = '".$id."'")) {
            echo "ok";
        } else {
            echo "failed";
        }
    } else {
        echo "url";
    }
} else {
    echo "numeric";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;