<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 03.10.2018
 * Time: 16:19
 */

session_start();
include("../../scripts/connect.php");

if($_SESSION['userID'] != 1) {
    header("Location: ../");
}

if(!empty($_REQUEST['c'])) {
    $categoryCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_blog_categories WHERE id = '".$mysqli->real_escape_string($_REQUEST['c'])."'");
    $categoryCheck = $categoryCheckResult->fetch_array(MYSQLI_NUM);

    if($categoryCheck[0] == 0) {
        header("Location: /admin/blog");
    }
}

if(!empty($_REQUEST['id'])) {
    $postCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_blog WHERE category_id = '".$mysqli->real_escape_string($_REQUEST['c'])."' AND id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
    $postCheck = $postCheckResult->fetch_array(MYSQLI_NUM);

    if($postCheck[0] == 0) {
        header("Location: /admin/blog/?c=".$_REQUEST['c']);
    }
}

?>

<!DOCTYPE html>

<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->

<head>

    <meta charset="utf-8" />

    <title>Панель администрирования | Записи в блоге</title>

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
    <link rel="stylesheet" href="/libs/strip/dist/css/strip.css" />

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/libs/notify/notify.js"></script>
    <script src="/libs/strip/dist/js/strip.pkgd.min.js"></script>
    <script type="text/javascript" src="/libs/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/js/admin/common.js"></script>
    <script type="text/javascript" src="/js/admin/blog/index.js"></script>

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

<body <?php if(!empty($_REQUEST['id'])) {echo "onload='loadPostText(\"".$_REQUEST['id']."\")'";} ?>>

    <div id="page-preloader"><span class="spinner"></span></div>

    <div id="topLine">
        <div id="logo">
            <a href="../"><span><i class="fa fa-home" aria-hidden="true"></i> <?= $_SERVER['HTTP_HOST'] ?></span></a>
        </div>
        <a href="admin.php"><span class="headerText">Панель администрирвания</span></a>
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
        <a href="/admin/categories/">
            <div class="menuPoint">
                <i class="fa fa-bars" aria-hidden="true"></i><span> Разделы магазина</span>
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
        <a href="/admin/blog/">
            <div class="menuPointActive">
                <i class="fa fa-pencil" aria-hidden="true"></i><span> Блог</span>
            </div>
        </a>
        <a href="/admin/blog-categories/">
            <div class="menuPoint">
                <i class="fa fa-bars" aria-hidden="true"></i><span> Разделы блога</span>
            </div>
        </a>
        <a href="/admin/3d-print/">
            <div class="menuPoint">
                <i class="fa fa-cube" aria-hidden="true"></i><span> 3D-печать</span>
            </div>
        </a>
        <a href="/admin/study/">
            <div class="menuPoint">
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
        <span class="headerFont">Управление записями блога</span>
        <br /><br />
        <input type='button' id='addPostSubmit' value='Добавить запись' onmouseover='buttonHover("addPostSubmit", 1)' onmouseout='buttonHover("addPostSubmit", 0)' onclick='window.location.href = "/admin/blog/add.php"' class='button' />
        <br /><br />
        <form method="post" id="postForm">
            <label for="categorySelect">Раздел:</label>
            <br />
            <select id="categorySelect" name="category" onchange="window.location = '?c=' + this.options[this.selectedIndex].value">
                <option value="">- Выберите раздел -</option>
                <?php
                    $categoryResult = $mysqli->query("SELECT * FROM st_blog_categories ORDER BY name");
                    while($category = $categoryResult->fetch_assoc()) {
                        echo "<option value='".$category['id']."'"; if($_REQUEST['c'] == $category['id']) {echo " selected";} echo ">".$category['name']."</option>";
                    }
                ?>
            </select>
            <br /><br />
            <?php
            if(!empty($_REQUEST['c'])) {
                echo "
                    <label for='postSelect'>Запись:</label>
                    <br />
                    <select id='postSelect' name='post' onchange=\"window.location = '?c=' + ".$_REQUEST['c']." + '&id=' + this.options[this.selectedIndex].value\">
                        <option value=''>- Выберите запись -</option>
                ";

                $postResult = $mysqli->query("SELECT * FROM st_blog WHERE category_id = '".$mysqli->real_escape_string($_REQUEST['c'])."'");
                while($post = $postResult->fetch_assoc()) {
                    echo "<option value='".$post['id']."'"; if($_REQUEST['id'] == $post['id']) {echo " selected";} echo ">".$post['name']."</option>";
                }

                echo "
                    </select>
                ";

                if(!empty($_REQUEST['id'])) {
                    $postResult = $mysqli->query("SELECT * FROM st_blog WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
                    $post = $postResult->fetch_assoc();

                    echo "
                        <br /><br />
                        <label for='nameInput'>Название записи:</label>
                        <br />
                        <input id='nameInput' name='name' value='".$post['name']."' />
                        <br /><br />
                        <label for='urlInput'>URL записи:</label>
                        <br />
                        <input id='urlInput' name='url' value='".$post['url']."' />
                        <br /><br />
                        <label for='previewInput'>Превью:</label>
                        <br />
                        <input type='file' class='file' id='previewInput' name='preview' />
                        <br /><br />
                        <a href='/img/blog/big/".$post['photo']."' class='strip' data-strip-caption='".$post['name']."'>
                            <div class='photoPreview'>
                                <img src='/img/blog/small/".$post['preview']."' />
                                <br />
                                <span>Увеличить</span>
                            </div>
                        </a>
                        <br /><br />
                        <label for='descriptionInput'>Краткое описание:</label>
                        <br/>
                        <textarea id='descriptionInput' name='description' onkeydown='textAreaHeight(this)'>".$post['description']."</textarea>
                        <br /><br />
                        <label for='textInput'>Текст:</label>
                        <br />
                        <textarea id='textInput' name='text'></textarea>
                        <br /><br />
                        <div style='width: 100%;'>
                            <input type='button' id='editSubmit' value='Редактировать' onmouseover='buttonHover(\"editSubmit\", 1)' onmouseout='buttonHover(\"editSubmit\", 0)' onclick='editPost()' class='button relative' />
                            <input type='button' id='deleteSubmit' value='Удалить' onmouseover='buttonHoverRed(\"deleteSubmit\", 1)' onmouseout='buttonHoverRed(\"deleteSubmit\", 0)' onclick='deletePost()' class='button relative' style='margin-left: 10px;' />
                            <div class='clear'></div>
                        </div>
                    ";
                }
            }
            ?>
        </form>
    </div>

    <script type="text/javascript">
        CKEDITOR.replace("text");
    </script>

</body>

</html>