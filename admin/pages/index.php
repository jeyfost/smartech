<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 07.02.2018
 * Time: 16:02
 */

session_start();
include("../../scripts/connect.php");

if($_SESSION['userID'] != 1) {
    header("Location: ../../");
}

if(!empty($_REQUEST['id'])) {
    $pageCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_catalogue_categories WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
    $pageCheck = $pageCheckResult->fetch_array(MYSQLI_NUM);

    if($pageCheck[0] == 0) {
        header("Location: index.php");
    }
}

?>

<head>

    <meta charset="utf-8" />

    <title>Панель администрирования</title>

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

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/libs/notify/notify.js"></script>
    <script type="text/javascript" src="/js/admin/common.js"></script>
    <script type="text/javascript" src="/js/admin/pages/index.js"></script>

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

<body>

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
            <div class="menuPointActive">
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
            <div class="menuPoint">
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
        <span class="headerFont">Редактирование страниц</span>
        <br /><br />
        <form method="post" id="pagesForm">
            <label for="pageSelect"></label>
            <select id="pageSelect" name="page" onchange="window.location = '?id=' + this.options[this.selectedIndex].value">
                <option value="">- Выберите страницу -</option>
                <?php
                    $pageResult = $mysqli->query("SELECT * FROM st_catalogue_categories ORDER BY id");
                    while($page = $pageResult->fetch_assoc()) {
                        echo "<option value='".$page['id']."'"; if($_REQUEST['id'] == $page['id']) {echo " selected";} echo ">".$page['name']."</option>";
                    }
                ?>
            </select>
            <?php
                if(!empty($_REQUEST['id'])) {
                    $pageResult = $mysqli->query("SELECT * FROM st_catalogue_categories WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
                    $page = $pageResult->fetch_assoc();

                    echo "
                        <br /><br />
                        <label for='titleInput'>Заголовок (тег <b>title</b>):</label>
                        <br />
                        <input id='titleInput' name='title' value='".$page['title']."' />
                        <br /><br />
                        <label for='keywordsInput'>Ключевые слова (meta-тег <b>keywords</b>):</label>
                        <br />
                        <textarea id='keywordsInput' name='keywords' onkeydown='textAreaHeight(this)'>".$page['keywords']."</textarea>
                        <br /><br />
                        <label for='descriptionInput'>Описание (meta-тег <b>description</b>):</label>
                        <br />
                        <textarea id='descriptionInput' name='description' onkeydown='textAreaHeight(this)'>".$page['description']."</textarea>
                        <br /><br />
                        <label for='textInput'>Описание раздела на главной странице:</label>
                        <br />
                        <textarea id='textInput' name='description' onkeydown='textAreaHeight(this)'>".$page['text']."</textarea>
                        <br /><br />
                        <input type='button' class='button' id='pageSubmit' value='Редактировать' onmouseover='buttonHover(\"pageSubmit\", 1)' onmouseout='buttonHover(\"pageSubmit\", 0)' onclick='edit()' />
                     ";
                }
            ?>
        </form>
    </div>

</body>

</html>