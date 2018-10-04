<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 14.02.2018
 * Time: 11:07
 */

include("../../connect.php");
include("../image.php");

$req = false;
ob_start();

$id = $mysqli->real_escape_string($_POST['good']);
$name = $mysqli->real_escape_string($_POST['name']);
$url = $mysqli->real_escape_string($_POST['url']);
$description = $mysqli->real_escape_string(nl2br($_POST['description']));
$text = $mysqli->real_escape_string($_POST['text']);

if(!is_numeric($url)) {
    $url = str_replace(" ", "-", $url);
    $url = str_replace("_", "-", $url);

    $urlCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_catalogue WHERE url = '".$url."'");
    $urlCheck = $urlCheckResult->fetch_array(MYSQLI_NUM);

    if($urlCheck[0] == 0) {
        if(!empty($_FILES['preview']['tmp_name']) and $_FILES['preview']['error'] == 0 and substr($_FILES['preview']['type'], 0, 5) == "image") {
            $errors = 0;
            $additionalPhotosCount = 0;

            foreach ($_FILES['additionalPhotos']['error'] as $key => $error) {
                if(!empty($_FILES['additionalPhotos']['tmp_name'][$key])) {
                    $additionalPhotosCount++;

                    if($error != UPLOAD_ERR_OK or substr($_FILES['additionalPhotos']['type'][$key], 0, 5) != "image") {
                        $errors++;
                    }
                }
            }

            if($errors == 0) {
                $categoryResult = $mysqli->query("SELECT * FROM st_catalogue_categories WHERE url = 'study'");
                $category = $categoryResult->fetch_assoc();

                $previewTmpName = $_FILES['preview']['tmp_name'];
                $previewName = randomName($previewTmpName);
                $previewDBName = $previewName.".".substr($_FILES['preview']['name'], count($_FILES['preview']['name']) - 4, 4);
                $previewUploadDir = "../../../img/catalogue/small/";
                $previewUpload = $previewUploadDir.$previewDBName;

                $photoTmpName = $_FILES['preview']['tmp_name'];
                $photoName = randomName($photoTmpName);
                $photoDBName = $photoName.".".substr($_FILES['preview']['name'], count($_FILES['preview']['name']) - 4, 4);
                $photoUploadDir = "../../../img/catalogue/big/";
                $photoUpload = $photoUploadDir.$photoDBName;

                if($mysqli->query("INSERT INTO st_catalogue (category_id, name, preview, photo, url, description, text) VALUES ('".$category['id']."', '".$name."', '".$previewDBName."', '".$photoDBName."', '".$url."', '".$description."', '".$text."')")) {
                    copy($photoTmpName, $photoUpload);

                    resize($previewTmpName, 300);
                    move_uploaded_file($previewTmpName, $previewUpload);

                    if($additionalPhotosCount > 0) {
                        $goodResult = $mysqli->query("SELECT * FROM st_catalogue WHERE url = '".$url."'");
                        $good = $goodResult->fetch_assoc();

                        $start = 0;
                        $finish = 0;

                        foreach ($_FILES['additionalPhotos']['error'] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $previewTmpName = $_FILES['additionalPhotos']['tmp_name'][$key];
                                $previewName = randomName($previewTmpName);
                                $previewDBName = $previewName.".".substr($_FILES['additionalPhotos']['name'][$key], count($_FILES['additionalPhotos']['name'][$key]) - 4, 4);
                                $previewUploadDir = "../../../img/photos/small/";
                                $previewUpload = $previewUploadDir.$previewDBName;

                                $photoTmpName = $_FILES['additionalPhotos']['tmp_name'][$key];
                                $photoName = randomName($photoTmpName);
                                $photoDBName = $photoName.".".substr($_FILES['additionalPhotos']['name'][$key], count($_FILES['additionalPhotos']['name'][$key]) - 4, 4);
                                $photoUploadDir = "../../../img/photos/big/";
                                $photoUpload = $photoUploadDir.$photoDBName;

                                $start++;

                                if($mysqli->query("INSERT INTO st_photos (good_id, preview, photo) VALUES ('".$good['id']."', '".$previewDBName."', '".$photoDBName."')")) {
                                    copy($photoTmpName, $photoUpload);

                                    resize($previewTmpName, 80);
                                    move_uploaded_file($previewTmpName, $previewUpload);

                                    $finish++;
                                }
                            }
                        }

                        if($start == $finish) {
                            echo "ok";
                        } else {
                            echo "additional photos";
                        }
                    } else {
                        echo "ok";
                    }
                } else {
                    echo "failed";
                }
            } else {
                echo "additional photos";
            }
        } else {
            echo "photo";
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