<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 27.09.2018
 * Time: 10:36
 */

include("../../connect.php");
include("../image.php");

$req = false;
ob_start();

$categoryID = $mysqli->real_escape_string($_POST['category']);
$subcategoryID = $mysqli->real_escape_string($_POST['subcategory']);
$id = $mysqli->real_escape_string($_POST['good']);
$name = $mysqli->real_escape_string($_POST['name']);
$url = $mysqli->real_escape_string($_POST['url']);
$description = $mysqli->real_escape_string($_POST['description']);
$text = $mysqli->real_escape_string($_POST['text']);
$code = $mysqli->real_escape_string($_POST['code']);
$price = $mysqli->real_escape_string($_POST['price']);

if(!is_numeric($url)) {
    $url = str_replace(" ", "-", $url);
    $url = str_replace("_", "-", $url);

    $urlCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_shop WHERE url = '".$url."'");
    $urlCheck = $urlCheckResult->fetch_array(MYSQLI_NUM);

    if($urlCheck[0] == 0) {
        $codeCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_shop WHERE code = '".$code."'");
        $codeCheck = $codeCheckResult->fetch_array(MYSQLI_NUM);

        if($codeCheck[0] == 0) {
            if(!empty($_FILES['preview']['name'])) {
                if ($_FILES['preview']['error'] == 0 and substr($_FILES['preview']['type'], 0, 5) == "image") {
                    $previewTmpName = $_FILES['preview']['tmp_name'];
                    $previewName = randomName($previewTmpName);
                    $previewDBName = $previewName . "." . substr($_FILES['preview']['name'], count($_FILES['preview']['name']) - 4, 4);
                    $previewUploadDir = "../../../img/shop/small/";
                    $previewUpload = $previewUploadDir . $previewDBName;

                    $photoTmpName = $_FILES['preview']['tmp_name'];
                    $photoName = randomName($photoTmpName);
                    $photoDBName = $photoName . "." . substr($_FILES['preview']['name'], count($_FILES['preview']['name']) - 4, 4);
                    $photoUploadDir = "../../../img/shop/big/";
                    $photoUpload = $photoUploadDir . $photoDBName;

                    $maxIDResult = $mysqli->query("SELECT MAX(id) FROM st_shop");
                    $maxID = $maxIDResult->fetch_array(MYSQLI_NUM);

                    $newID = $maxID[0] + 1;

                    if($mysqli->query("INSERT INTO st_shop (id, category_id, subcategory_id, name, price, description, preview, photo, code, url) VALUES ('".$newID."', '".$categoryID."', '".$subcategoryID."', '".$name."', '".$price."', '".$description."', '".$previewDBName."', '".$photoDBName."', '".$code."', '".$url."')")) {
                        copy($photoTmpName, $photoUpload);
                        resize($previewTmpName, 300);
                        move_uploaded_file($previewTmpName, $previewUpload);

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
                                    $previewUploadDir = "../../../img/shop/small/";
                                    $previewUpload = $previewUploadDir.$previewDBName;

                                    $photoTmpName = $_FILES['additionalPhotos']['tmp_name'][$key];
                                    $photoName = randomName($photoTmpName);
                                    $photoDBName = $photoName.".".substr($_FILES['additionalPhotos']['name'][$key], count($_FILES['additionalPhotos']['name'][$key]) - 4, 4);
                                    $photoUploadDir = "../../../img/shop/big/";
                                    $photoUpload = $photoUploadDir.$photoDBName;

                                    $start++;

                                    if($mysqli->query("INSERT INTO st_shop_photos (good_id, preview, photo) VALUES ('".$newID."', '".$previewDBName."', '".$photoDBName."')")) {
                                        copy($photoTmpName, $photoUpload);

                                        resize($previewTmpName, 100);
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
                            } else {
                                echo "ok";
                            }
                        } else {
                            echo "additional photos";
                        }
                    } else {
                        echo "failed";
                    }
                } else {
                    echo "photo format";
                }
            } else {
                echo "photo";
            }
        } else {
            echo "code";
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