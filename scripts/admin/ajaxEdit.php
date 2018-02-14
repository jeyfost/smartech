<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 08.02.2018
 * Time: 12:26
 */

include("../connect.php");
include("image.php");

$req = false;
ob_start();

$id = $mysqli->real_escape_string($_POST['good']);
$name = $mysqli->real_escape_string($_POST['name']);
$url = $mysqli->real_escape_string($_POST['url']);
$description = $mysqli->real_escape_string($_POST['description']);
$text = $mysqli->real_escape_string($_POST['text']);

$goodResult = $mysqli->query("SELECT * FROM st_catalogue WHERE id = '".$id."'");
$good = $goodResult->fetch_assoc();

if(!is_numeric($url)) {
    $urlCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_catalogue WHERE url = '".$url."' AND id <> '".$good['id']."'");
    $urlCheck = $urlCheckResult->fetch_array(MYSQLI_NUM);

    if($urlCheck[0] == 0) {
        if(!empty($_FILES['preview']['name'])) {
            if($_FILES['preview']['error'] == 0 and substr($_FILES['preview']['type'], 0, 5) == "image") {
                $previewTmpName = $_FILES['preview']['tmp_name'];
                $previewName = randomName($previewTmpName);
                $previewDBName = $previewName.".".substr($_FILES['preview']['name'], count($_FILES['preview']['name']) - 4, 4);
                $previewUploadDir = "../../img/catalogue/small/";
                $previewUpload = $previewUploadDir.$previewDBName;

                $photoTmpName = $_FILES['preview']['tmp_name'];
                $photoName = randomName($photoTmpName);
                $photoDBName = $photoName.".".substr($_FILES['preview']['name'], count($_FILES['preview']['name']) - 4, 4);
                $photoUploadDir = "../../img/catalogue/big/";
                $photoUpload = $photoUploadDir.$photoDBName;

                if($mysqli->query("UPDATE st_catalogue SET preview = '".$previewDBName."', photo = '".$photoDBName."' WHERE id = '".$good['id']."'")) {
                    unlink($previewUploadDir.$good['preview']);
                    unlink($photoUploadDir.$good['photo']);

                    copy($photoTmpName, $photoUpload);

                    resize($previewTmpName, 300);
                    move_uploaded_file($previewTmpName, $previewUpload);
                } else {
                    echo "main photo upload";

                    $req = ob_get_contents();
                    ob_end_clean();
                    echo json_encode($req);

                    exit;
                }
            } else {
                echo "main photo";

                $req = ob_get_contents();
                ob_end_clean();
                echo json_encode($req);

                exit;
            }
        }

        $start = 0;
        $finish = 0;
        $errors = 0;

        foreach ($_FILES['additionalPhotos']['error'] as $key => $error) {
            if(!empty($_FILES['additionalPhotos']['tmp_name'][$key])) {
                if($error != UPLOAD_ERR_OK or substr($_FILES['additionalPhotos']['type'][$key], 0, 5) != "image") {
                    $errors++;
                }
            }
        }

        if($errors == 0) {
            foreach ($_FILES['additionalPhotos']['error'] as $key => $error) {
                if($error == UPLOAD_ERR_OK) {
                    $previewTmpName = $_FILES['additionalPhotos']['tmp_name'][$key];
                    $previewName = randomName($previewTmpName);
                    $previewDBName = $previewName.".".substr($_FILES['additionalPhotos']['name'][$key], count($_FILES['additionalPhotos']['name'][$key]) - 4, 4);
                    $previewUploadDir = "../../img/photos/small/";
                    $previewUpload = $previewUploadDir.$previewDBName;

                    $photoTmpName = $_FILES['additionalPhotos']['tmp_name'][$key];
                    $photoName = randomName($photoTmpName);
                    $photoDBName = $photoName.".".substr($_FILES['additionalPhotos']['name'][$key], count($_FILES['additionalPhotos']['name'][$key]) - 4, 4);
                    $photoUploadDir = "../../img/photos/big/";
                    $photoUpload = $photoUploadDir.$photoDBName;

                    $start++;

                    if($mysqli->query("INSERT INTO st_photos (good_id, preview, photo) VALUES ('".$good['id']."', '".$previewDBName."', '".$photoDBName."')")) {
                        copy($photoTmpName, $photoUpload);

                        resize($previewTmpName, 80);
                        move_uploaded_file($previewTmpName, $previewUpload);

                        $finish++;
                    }
                } else {
                    $errors++;
                }
            }

            if($start != $finish) {
                echo "additional photos upload";

                $req = ob_get_contents();
                ob_end_clean();
                echo json_encode($req);

                exit;
            }
        } else {
            echo "additional photos";

            $req = ob_get_contents();
            ob_end_clean();
            echo json_encode($req);

            exit;
        }

        if($mysqli->query("UPDATE st_catalogue SET name = '".$name."', url = '".$url."', description = '".$description."', text = '".$text."' WHERE id = '".$good['id']."'")) {
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