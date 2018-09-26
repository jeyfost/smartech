<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 14.02.2018
 * Time: 10:56
 */

session_start();
include("../../scripts/connect.php");

if($_SESSION['userID'] != 1) {
    header("Location: ../../");
}

$categoryResult = $mysqli->query("SELECT * FROM st_catalogue_categories WHERE url = 'study'");
$category = $categoryResult->fetch_assoc();

if(!empty($_REQUEST['id'])) {
    $goodCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_catalogue WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."' AND category_id = '".$category['id']."'");
    $goodCheck = $goodCheckResult->fetch_array(MYSQLI_NUM);

    if($goodCheck[0] == 0) {
        header("Location: index.php");
    } else {
        $goodResult = $mysqli->query("SELECT * FROM st_catalogue WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
        $good = $goodResult->fetch_assoc();
    }
}

?>

<head>

    <meta charset="utf-8" />

    <title>Панель администрирования | Обучение</title>

    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/manifest.json">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" type="text/css" href="/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="/css/admin.css" />
    <link rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="/libs/lightview/css/lightview/lightview.css" />

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/libs/lightview/js/lightview/lightview.js"></script>
    <script type="text/javascript" src="/libs/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/libs/notify/notify.js"></script>
    <script type="text/javascript" src="/js/admin/common.js"></script>
    <script type="text/javascript" src="/js/admin/study/index.js"></script>

    <style>
        #page-preloader {position: fixed; left: 0; top: 0; right: 0; bottom: 0; background: #fff; z-index: 100500;}
        #page-preloader .spinner {width: 32px; height: 32px; position: absolute; left: 50%; top: 50%; background: url('/img/system/spinner.gif') no-repeat 50% 50%; margin: -16px 0 0 -16px;}
    </style>

    <script type="text/javascript">
        $(window).on('load', function () {
            var $preloader = $('#page-preloader'), $spinner = $preloader.find('.spinner');
            $spinner.delay(500).fadeOut();
            $preloader.delay(850).fadeOut();
        });
    </script>

    <!-- Yandex.Metrika counter --><!-- /Yandex.Metrika counter -->
    <!-- Google Analytics counter --><!-- /Google Analytics counter -->
</head>

<body <?php if(!empty($_REQUEST['id'])) {echo "onload='loadText(\"".$good['id']."\")'";} ?>>

<div id="page-preloader"><span class="spinner"></span></div>

<div id="topLine">
    <div id="logo">
        <a href="/"><span><i class="fa fa-home" aria-hidden="true"></i> <?= $_SERVER['HTTP_HOST'] ?></span></a>
    </div>
    <a href="/admin/admin.php"><span class="headerText">Панель администрирвания</span></a>
    <div id="exit" onclick="exit()">
        <span>Выйти <i class="fa fa-sign-out" aria-hidden="true"></i></span>
    </div>
</div>
<div id="leftMenu">
    <a href="/admin/pages/">
        <div class="menuPoint">
            <i class="fa fa-file-text-o" aria-hidden="true"></i><span> Страницы</span>
        </div>
    </a>
    <a href="/admin/shop/">
        <div class="menuPoint">
            <i class="fa fa-shopping-bag" aria-hidden="true"></i><span> Магазин</span>
        </div>
    </a>
    <?php
        $ordersCountResult = $mysqli->query("SELECT COUNT(id) FROM st_orders WHERE accepted = '0'");
        $ordersCount = $ordersCountResult->fetch_array(MYSQLI_NUM);
    ?>
    <a href="/admin/orders/">
        <div class="menuPoint">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i><span> Заказы<?php if($ordersCount[0] > 0) {echo " (".$ordersCount[0].")";} ?></span>
        </div>
    </a>
    <a href="/admin/3d-print/">
        <div class="menuPoint">
            <i class="fa fa-cube" aria-hidden="true"></i><span> 3D-печать</span>
        </div>
    </a>
    <a href="/admin/study/">
        <div class="menuPointActive">
            <i class="fa fa-graduation-cap" aria-hidden="true"></i><span> Обучение</span>
        </div>
    </a>
    <a href="/admin/engineering/">
        <div class="menuPoint">
            <i class="fa fa-cogs" aria-hidden="true"></i><span> Проектирование</span>
        </div>
    </a>
    <a href="/admin/iot/">
        <div class="menuPoint">
            <i class="fa fa-hdd-o" aria-hidden="true"></i><span> IoT</span>
        </div>
    </a>
    <a href="/admin/security/">
        <div class="menuPoint">
            <i class="fa fa-shield" aria-hidden="true"></i><span> Безопасность</span>
        </div>
    </a>
</div>

<div id="content">
    <span class="headerFont">Редактирование услуг</span>
    <br /><br />
    <form method="post" id="goodForm">
        <label for="goodSelect"></label>
        <select id="goodSelect" name="good" onchange="window.location = '?id=' + this.options[this.selectedIndex].value">
            <option value="">- Выберите услугу -</option>
            <?php
            $catalogueResult = $mysqli->query("SELECT * FROM st_catalogue WHERE category_id = '".$category['id']."' ORDER BY id");
            while($catalogue = $catalogueResult->fetch_assoc()) {
                echo "<option value='".$catalogue['id']."'"; if($_REQUEST['id'] == $catalogue['id']) {echo " selected";} echo ">".$catalogue['name']."</option>";
            }
            ?>
        </select>
        <br /><br />
        <input type='button' id='addGoodSubmit' value='Добавить услугу' onmouseover='buttonHover("addGoodSubmit", 1)' onmouseout='buttonHover("addGoodSubmit", 0)' onclick='window.location.href = "/admin/study/add.php"' class='button' />

        <?php
        if(!empty($_REQUEST['id'])) {
            echo "
                    <br /><br /><br /><br />
                    <hr />
                    <br /><br />
                    <span class='headerFont'>Редактирование услуги <span style='color: #939393;'>&laquo;".$good['name']."&raquo;</span></span>
                    <br /><br />
                    <label for='nameInput'>Название услуги:</label>
                    <br />
                    <input id='nameInput' name='name' value='".$good['name']."' />
                    <br /><br />
                    <label for='previewInput'>Превью:</label>
                    <br />
                    <input type='file' class='file' id='previewInput' name='preview' />
                    <br /><br />
                    <a href='/img/catalogue/big/".$good['photo']."' class='lightview' data-lightview-options='skin: \"light\"'>
                        <div class='photoPreview'>
                            <img src='/img/catalogue/small/".$good['preview']."' />
                            <br />
                            <span>Увеличить</span>
                        </div>
		            </a>
		            <br /><br />
		            <label for='additionalPhotosInput'>Дополнительные фотографии:</label>
		            <br />
		            <input type='file' class='file' id='additionalPhotosInput' name='additionalPhotos[]' multiple='multiple' />
		            <br /><br />
                ";

            $photoResult = $mysqli->query("SELECT * FROM st_photos WHERE good_id = '".$good['id']."'");

            if($photoResult->num_rows > 0) {
                echo "<div id='additionalPhotosContainer'>";

                while($photo = $photoResult->fetch_assoc()) {
                    echo "
                            <div class='photoPreview'>
                                <a href='/img/photos/big/".$photo['photo']."' class='lightview' data-lightview-group='additional-photos' data-lightview-options='skin: \"light\"'>
                                    <img src='/img/photos/small/".$photo['preview']."' />
                                </a>
                                <br />
                                <span onclick='deletePhoto(\"".$photo['id']."\")'>Удалить</span>
                            </div>
                        ";
                }

                echo "
                        </div>
                        <br />
                        <input type='button' id='deletePhotosSubmit' value='Удалить все дополнительные фотографии' onmouseover='buttonHoverRed(\"deletePhotosSubmit\", 1)' onmouseout='buttonHoverRed(\"deletePhotosSubmit\", 0)' onclick='deleteAllPhotos(\"".$photo['good_id']."\")' class='button' />
                        <br /><br />
                    ";
            }

            echo "
                    <label for='urlInput'>URL:</label>
                    <br />
                    <input id='urlInput' name='url' value='".$good['url']."' />
                    <br /><br />
                    <label for='descriptionInput'>Краткое описание:</label>
                    <br />
                    <textarea id='descriptionInput' name='description' onkeydown='textAreaHeight(this)'>".$good['description']."</textarea>
                    <br /><br />
                    <label for='textInput'>Описание:</label>
                    <br />
                    <textarea id='textInput' name='text'></textarea>
                    <br /><br />
					<div style='width: 100%;'>
						<input type='button' id='editSubmit' value='Редактировать' onmouseover='buttonHover(\"editSubmit\", 1)' onmouseout='buttonHover(\"editSubmit\", 0)' onclick='editGood()' class='button relative' />
						<input type='button' id='deleteSubmit' value='Удалить' onmouseover='buttonHoverRed(\"deleteSubmit\", 1)' onmouseout='buttonHoverRed(\"deleteSubmit\", 0)' onclick='deleteGood()' class='button relative' style='margin-left: 10px;' />
						<div class='clear'></div>
					</div>
                ";
        }
        ?>
    </form>
</div>

<script type="text/javascript">
    CKEDITOR.replace("text");
</script>

</body>

</html>