<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 06.02.2018
 * Time: 11:20
 */

include("scripts/connect.php");

$url = explode("/", $_SERVER['REQUEST_URI']);

/*
 *  $url[1] — категория
 *  $url[2] —
 *          — если empty, то выводить первую страницу категории
 *          — если цифра, то выводить соответствующую страницу категории
 *          — если строка, то выводить товар/услугу
 */

$categoryResult = $mysqli->query("SELECT * FROM st_catalogue_categories WHERE url = '".$mysqli->real_escape_string($url[1])."'");
$category = $categoryResult->fetch_assoc();

if(empty($category)) {
    header("Location: /");
}

if(!empty($url[2])) {
    if($url[2] == 1) {
        header("Location: /".$category['url']."/");
    }

    $linkCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_catalogue WHERE url = '".$mysqli->real_escape_string($url[2])."'");
    $linkCheck = $linkCheckResult->fetch_array(MYSQLI_NUM);

    if($linkCheck[0] == 0) {
        $addressNew = (int)$url[2];
        $address = (string)$url[2];
        $addressNew = (string)$addressNew;

        if($addressNew == $address) {
            //$url[2] содержит номер страницы

            $quantityResult = $mysqli->query("SELECT COUNT(id) FROM st_catalogue WHERE category_id = '".$category['id']."'");
            $quantity = $quantityResult->fetch_array(MYSQLI_NUM);

            if ($quantity[0] > GOODS_ON_PAGE) {
                if ($quantity[0] % GOODS_ON_PAGE != 0) {
                    $numbers = intval(($quantity[0] / GOODS_ON_PAGE) + 1);
                } else {
                    $numbers = intval($quantity[0] / GOODS_ON_PAGE);
                }
            } else {
                $numbers = 1;
            }

            $page = (int)$addressNew;

            if($page < 1 or $page > $numbers) {
                header("Location: /".$category['url']."/");
            }

            $start = $page * GOODS_ON_PAGE - GOODS_ON_PAGE;

        } else {
            header("Location: /".$category['url']."/");
        }
    } else {
        $type = "good";
    }
} else {
    $quantityResult = $mysqli->query("SELECT COUNT(id) FROM st_catalogue WHERE category_id = '".$category['id']."'");
    $quantity = $quantityResult->fetch_array(MYSQLI_NUM);

    if ($quantity[0] > GOODS_ON_PAGE) {
        if ($quantity[0] % GOODS_ON_PAGE != 0) {
            $numbers = intval(($quantity[0] / GOODS_ON_PAGE) + 1);
        } else {
            $numbers = intval($quantity[0] / GOODS_ON_PAGE);
        }
    } else {
        $numbers = 1;
    }

    $page = 1;

    if($page < 1 or $page > $numbers) {
        header("Location: /".$category['url']."/");
    }

    $start = $page * GOODS_ON_PAGE - GOODS_ON_PAGE;
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
    <title><?= $category['title'] ?></title>

    <meta charset="utf-8" />
    <meta name="description" content="<?= $category['description'] ?>" />
    <meta name="keywords" content="<?= $category['keywords'] ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/manifest.json">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/libs/lightview/css/lightview/lightview.css" />
    <link rel="stylesheet" href="/css/fonts.css" />
    <link rel="stylesheet" href="/css/main.css" />
    <link rel="stylesheet" href="/css/media.css" />

    <link href="https://fonts.googleapis.com/css?family=Exo+2|Istok+Web|Montserrat|Poiret+One" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/libs/lightview/js/lightview/lightview.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
    <script type="text/javascript" src="/js/url-processor.js"></script>

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

    <div id="menu">
        <div id="menuContent">
            <a href="/"><div id="logo"><img src="/img/system/logo_text_small.png" /></div></a>
            <div id="mobileMenuIcon">
                <i class="fa fa-bars hidden" aria-hidden="true" onclick="mobileMenu()" id="menuIcon"></i>
            </div>
            <div id="menuPoints">
                <a href="/contacts/"><div class="menuPoint">Контакты</div></a>
                <?php if($url[1] != "iot or !empty($url[2])") {echo "<a href='/iot/'>";} ?><div class="menuPoint <?php if($url[1] == "iot") {echo "active";} ?>">IoT</div><?php if($url[1] != "iot" or !empty($url[2])) {echo "</a>";} ?>
                <?php if($url[1] != "engineering" or !empty($url[2])) {echo "<a href='/engineering/'>";} ?><div class="menuPoint <?php if($url[1] == "engineering") {echo "active";} ?>">Проектирование</div><?php if($url[1] != "engineering" or !empty($url[2])) {echo "</a>";} ?>
                <?php if($url[1] != "study" or !empty($url[2])) {echo "<a href='/study/'>";} ?><div class="menuPoint <?php if($url[1] == "study") {echo "active";} ?>">Обучение</div><?php if($url[1] != "study" or !empty($url[2])) {echo "</a>";} ?>
                <?php if($url[1] != "3d-print" or !empty($url[2])) {echo "<a href='/3d-print/'>";} ?><div class="menuPoint <?php if($url[1] == "3d-print") {echo "active";} ?>">3D-печать</div><?php if($url[1] != "3d-print" or !empty($url[2])) {echo "</a>";} ?>
                <?php if($url[1] != "3d-printers" or !empty($url[2])) {echo "<a href='/3d-printers/'>";} ?><div class="menuPoint <?php if($url[1] == "3d-printers") {echo "active";} ?>">3D-принтеры</div><?php if($url[1] != "3d-printers" or !empty($url[2])) {echo "</a>";} ?>
                <a href="/"><div class="menuPoint">Главная</div></a>
            </div>
            <div class="clear"></div>
        </div>

        <div id="mobileMenu">
            <div class="mobileMenuPoint" style="text-align: right;">
                <i class="fa fa-times" aria-hidden="true" onclick="closeMobileMenu()"></i>
            </div>
            <div class="mobileMenuPoint"><a href="/"><span>Главная</span></a></div>
            <div class="mobileMenuPoint <?php if($url[1] == "3d-printers") {echo "active";} ?>"><?php if($url[1] != "3d-printers") {echo "<a href='/3d-printers/'>";} ?><span>3D-принтеры</span><?php if($url[1] != "3d-printers") {echo "</a>";} ?></div>
            <div class="mobileMenuPoint <?php if($url[1] == "3d-print") {echo "active";} ?>"><?php if($url[1] != "3d-print") {echo "<a href='/3d-print/'>";} ?><span>3D-печать</span><?php if($url[1] != "3d-print") {echo "</a>";} ?></div>
            <div class="mobileMenuPoint <?php if($url[1] == "study") {echo "active";} ?>"><?php if($url[1] != "study") {echo "<a href='/study/'>";} ?><span>Обучение</span><?php if($url[1] != "study") {echo "</a>";} ?></div>
            <div class="mobileMenuPoint <?php if($url[1] == "engineering") {echo "active";} ?>"><?php if($url[1] != "engineering") {echo "<a href='/engineering/'>";} ?><span>Проектирование</span><?php if($url[1] != "engineering") {echo "</a>";} ?></div>
            <div class="mobileMenuPoint <?php if($url[1] == "iot") {echo "active";} ?>"><?php if($url[1] != "iot") {echo "<a href='/iot/'>";} ?><span>IoT</span><?php if($url[1] != "iot") {echo "</a>";} ?></div>
            <div class="mobileMenuPoint"><a href="/contacts/"><span>Контакты</span></a></div>
        </div>
    </div>

    <div class="section white" id="section">
        <div class="header">
            <br /><br />
            <span class="headerFont">
                <?php
                    if($type == "good") {
                        $goodResult = $mysqli->query("SELECT * FROM st_catalogue WHERE url = '".$mysqli->real_escape_string($url[2])."'");
                        $good = $goodResult->fetch_assoc();

                        echo $good['name'];
                    } else {
                        echo $category['title'];
                    }
                ?>
            </span>
            <br />
        </div>
    </div>

    <div class="section100 grey text-center" style="margin-top: 30px; padding-bottom: 100px;">
        <br />
        <?php
            if($type != "good") {
                //Список всех товаров и услуг
                $catalogueResult = $mysqli->query("SELECT * FROM st_catalogue WHERE category_id = '".$category['id']."' LIMIT ".$start.", ".GOODS_ON_PAGE);

                if($catalogueResult->num_rows > 0) {
                    while($catalogue = $catalogueResult->fetch_assoc()) {
                        echo "
                            <div class='catalogueContainer'>
                                <div class='cataloguePhoto'>
                                    <a href='/img/catalogue/big/".$catalogue['photo']."' class='lightview' data-lightview-options='skin: \"light\"'><img src='/img/catalogue/small/".$catalogue['preview']."' /></a>
                                </div>
                                <div class='catalogueDescription'>
                                    <div class='catalogueName'>".$catalogue['name']."</div>
                                    <div class='catalogueShortDescription'>".$catalogue['description']."</div>
                                </div>
                                <div class='catalogueButtonContainer text-center'>
                                    <a href='/".$category['url']."/".$catalogue['url']."'><button class='activityButton' onmouseover='iconColor(\"icon".$catalogue['id']."\", 1)' onmouseout='iconColor(\"icon".$catalogue['id']."\", 0)'>подробнее&nbsp;&nbsp;<i class='fa fa-hand-o-right' aria-hidden='true' id='icon".$catalogue['id']."' style='color: #ededed;'></i></button></a>
                                </div>
                            </div>
                        ";
                    }

                    /* Блок с постраничной навигацией */
                    echo "<div class='text-center' style='width: 100%;'>";
                    echo "<div id='pageNumbers'>";

                    if($numbers > 1) {
                        $uri = $url[2];

                        if(empty($uri)) {
                            $uri = 1;
                        }

                        $link = "/".$category['url']."/";
                        if($numbers <= 7) {
                            echo "<br /><br />";

                            if($uri == 1) {
                                echo "<div class='pageNumberBlockSide' id='pbPrev' style='cursor: url(/img/cursor/no.cur), auto;'><span class='paginationInactive'>Предыдущая</span></div>";
                            } else {
                                echo "<a href='".$link.($uri - 1)."'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='paginationLink' id='pbtPrev'>Предыдущая</span></div></a>";
                            }

                            for($i = 1; $i <= $numbers; $i++) {
                                if($uri != $i) {
                                    echo "<a href='".$link.$i."'>";
                                }

                                echo "<div id='pb".$i."' "; if($i == $uri) {echo "class='pageNumberBlockActive'";} else {echo "class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")'";} echo "><span "; if($i == $uri) {echo "class='paginationActive'";} else {echo "class='paginationLink' id='pbt".$i."'";} echo ">".$i."</span></div>";

                                if($uri != $i) {
                                    echo "</a>";
                                }
                            }

                            if($uri == $numbers) {
                                echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(/img/cursor/no.cur), auto;'><span class='paginationInactive'>Следующая</span></div>";
                            } else {
                                echo "<a href='".$link.($uri + 1)."'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='paginationLink' id='pbtNext'>Следующая</span></div></a>";
                            }

                            echo "</div>";

                        } else {
                            if($uri < 5) {
                                if($uri == 1) {
                                    echo "<div class='pageNumberBlockSide' id='pbPrev' style='cursor: url(/img/cursor/no.cur), auto;'><span class='paginationInactive'>Предыдущая</span></div>";
                                } else {
                                    echo "<a href='".$link.($uri - 1)."'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='paginationLink' id='pbtPrev'>Предыдущая</span></div></a>";
                                }

                                for($i = 1; $i <= 5; $i++) {
                                    if($uri != $i) {
                                        echo "<a href='".$link.$i."'>";
                                    }

                                    echo "<div id='pb".$i."' "; if($i == $uri) {echo "class='pageNumberBlockActive'";} else {echo "class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")'";} echo "><span "; if($i == $uri) {echo "class='paginationActive'";} else {echo "class='paginationLink' id='pbt".$i."'";} echo ">".$i."</span></div>";

                                    if($uri != $i) {
                                        echo "</a>";
                                    }
                                }

                                echo "<div class='pageNumberBlock' style='cursor: url(/img/cursor/no.cur), auto;'><span class='paginationInactive'>...</span></div>";
                                echo "<a href='".$link.$numbers."'><div id='pb".$numbers."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$numbers."\", \"pbt".$numbers."\")' onmouseout='pageBlock(0, \"pb".$numbers."\", \"pbt".$numbers."\")'><span class='paginationLink' id='pbt".$numbers."'>".$numbers."</span></div></a>";

                                if($uri == $numbers) {
                                    echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(/img/cursor/no.cur), auto;'><span class='paginationInactive'>Следующая</span></div>";
                                } else {
                                    echo "<a href='".$link.($uri + 1)."'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='paginationLink' id='pbtNext'>Следующая</span></div></a>";
                                }

                                echo "</div>";
                            } else {
                                $check = $numbers - 3;

                                if($uri >= 5 and $uri < $check) {
                                    echo "
                                            <br /><br />
                                            <div id='pageNumbers'>
                                                <a href='".$link.($uri - 1)."'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='paginationLink' id='pbtPrev'>Предыдущая</span></div></a>
                                                <a href='".$link."1'><div id='pb1' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb1\", \"pbt1\")' onmouseout='pageBlock(0, \"pb1\", \"pbt1\")'><span class='paginationLink' id='pbt1'>1</span></div></a>
                                                <div class='pageNumberBlock' style='cursor: url(/img/cursor/no.cur), auto;'><span class='paginationInactive'>...</span></div>
                                                <a href='".$link.($uri - 1)."'><div id='pb".($uri - 1)."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".($uri - 1)."\", \"pbt".($uri - 1)."\")' onmouseout='pageBlock(0, \"pb".($uri - 1)."\", \"pbt".($uri - 1)."\")'><span class='paginationLink' id='pbt".($uri - 1)."'>".($uri - 1)."</span></div></a>
                                                <div class='pageNumberBlockActive'><span class='paginationActive'>".$uri."</span></div>
                                                <a href='".$link.($uri + 1)."'><div id='pb".($uri + 1)."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".($uri + 1)."\", \"pbt".($uri + 1)."\")' onmouseout='pageBlock(0, \"pb".($uri + 1)."\", \"pbt".($uri + 1)."\")'><span class='paginationLink' id='pbt".($uri + 1)."'>".($uri + 1)."</span></div></a>
                                                <div class='pageNumberBlock' style='cursor: url(/img/cursor/no.cur), auto;'><span class='paginationInactive'>...</span></div>
                                                <a href='".$link.$numbers."'><div id='pb".$numbers."' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$numbers."\", \"pbt".$numbers."\")' onmouseout='pageBlock(0, \"pb".$numbers."\", \"pbt".$numbers."\")'><span class='paginationLink' id='pbt".$numbers."'>".$numbers."</span></div></a>
                                                <a href='".$link.($uri + 1)."'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='paginationLink' id='pbtNext'>Следующая</span></div></a>
                                            </div>
                                        ";
                                } else {
                                    echo "
                                            <br /><br />
                                            <div id='pageNumbers'>
                                                <a href='".$link.($uri - 1)."'><div class='pageNumberBlockSide' id='pbPrev' onmouseover='pageBlock(1, \"pbPrev\", \"pbtPrev\")' onmouseout='pageBlock(0, \"pbPrev\", \"pbtPrev\")'><span class='paginationLink' id='pbtPrev'>Предыдущая</span></div></a>
                                                <a href='".$link."1'><div id='pb1' class='pageNumberBlock' onmouseover='pageBlock(1, \"pb1\", \"pbt1\")' onmouseout='pageBlock(0, \"pb1\", \"pbt1\")'><span class='paginationLink' id='pbt1'>1</span></div></a>
                                                <div class='pageNumberBlock' style='cursor: url(/img/cursor/no.cur), auto;'><span class='paginationInactive'>...</span></div>
                                        ";

                                    for($i = ($numbers - 4); $i <= $numbers; $i++) {
                                        if($uri != $i) {
                                            echo "<a href='".$link.$i."'>";
                                        }

                                        echo "<div id='pb".$i."' "; if($i == $uri) {echo "class='pageNumberBlockActive'";} else {echo "class='pageNumberBlock' onmouseover='pageBlock(1, \"pb".$i."\", \"pbt".$i."\")' onmouseout='pageBlock(0, \"pb".$i."\", \"pbt".$i."\")'";} echo "><span "; if($i == $uri) {echo "class='paginationActive'";} else {echo "class='paginationLink' id='pbt".$i."'";} echo ">".$i."</span></div>";

                                        if($uri != $i) {
                                            echo "</a>";
                                        }
                                    }

                                    if($uri == $numbers) {
                                        echo "<div class='pageNumberBlockSide' id='pbNext' style='cursor: url(/img/cursor/no.cur), auto;'><span class='paginationInactive'>Следующая</span></div>";
                                    } else {
                                        echo "<a href='".$link.($uri + 1)."'><div class='pageNumberBlockSide' id='pbNext' onmouseover='pageBlock(1, \"pbNext\", \"pbtNext\")' onmouseout='pageBlock(0, \"pbNext\", \"pbtNext\")'><span class='paginationLink' id='pbtNext'>Следующая</span></div></a>";
                                    }
                                }
                            }
                        }
                    }

                    echo "</div><div class='clear'></div>";
                    echo "</div>";
                    /* Конец блока постраничной навигации */
                } else {
                    echo "
                        <div class='section text-center'>
                            <p class='activityText'>На данный момент мы ещё ничего не добавили в раздел &laquo;".$category['title']."&raquo;, но скоро мы обязательно опубликуем много интересного &#9786;</p>
                        </div>
                    ";
                }
            } else {
                //Страница товара
                echo "
                    <div class='goodContainer'>
                        <div class='breadcrumbs'><a href='/".$category['url']."/'>".$category['title']."</a> > <a href='/".$category['url']."/".$good['url']."'>".$good['name']."</a></div>
                        <br />
                        <div class='goodPhoto'>
                            <a href='/img/catalogue/big/".$good['photo']."' class='lightview' data-lightview-options='skin: \"light\"'><img src='/img/catalogue/small/".$good['preview']."' /></a>
                        </div>
                        <div class='goodDescription'>
                            <span class='descriptionFont'>".$good['description']."</span>
                            <br /><br />
                            <span class='goodFont'>".$good['text']."</span>
                        </div>
                        <div class='clear'></div>
                    </div>
                ";

                $photoCountResult = $mysqli->query("SELECT COUNT(id) FROM st_photos WHERE good_id = '".$good['id']."'");
                $photoCount = $photoCountResult->fetch_array(MYSQLI_NUM);

                if($photoCount[0] > 0) {
                    echo "
                        <br /><br />
                        <div class='goodContainer' style='text-align: left;'>
                            <div style='margin-left: 20px;'><span class='activityHeaderFont'>Дополнительные фотографии</span></div>
                            <br />
                    ";

                    $i = 0;

                    $photoResult = $mysqli->query("SELECT * FROM st_photos WHERE good_id = '".$good['id']."'");
                    while($photo = $photoResult->fetch_assoc()) {
                        $i++;

                        echo "
                            <div class='goodPhotoPreview'>
                                <a href='/img/photos/big/".$photo['photo']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-group='photos'><img src='/img/photos/small/".$photo['preview']."' /></a>
                            </div>
                        ";
                    }
                }

                echo "
                    </div>
                ";
            }
        ?>
    </div>

    <div id="footer">
        <div class="section" style="margin: 0 auto; width: 90%;">
            <div class="footerLogo text-center">
                <a href="/"><img src="/img/system/logo_white_text_small.png" /></a>
                <br /><br />
                <a href="https://vk.com/oaosmartech" target="_blank"><i class="fa fa-vk" aria-hidden="true"></i></a>
                &nbsp;&nbsp;&nbsp;
                <a href="https://www.facebook.com/oaosmartech/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                &nbsp;&nbsp;&nbsp;
                <a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                &nbsp;&nbsp;&nbsp;
                <a href="#" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                &nbsp;&nbsp;&nbsp;
                <a href="#" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
            </div>
            <div class="footerText">
                <p>Многие знают, насколько быстро сейчас развивается индустрия 3D-печати. Мы уверены в том, что в smARTech мы идём в ногу с прогрессом, и, каким бы масштабным ни был Ваш проект, мы сможем его реализовать в соответствии со всеми современными стандартами.</p>
            </div>
            <div class="clear"></div>
        </div>
        <div class="section text-center" style="margin: 50px auto auto auto;">
            <span class="copyFont">smARTech &copy; <?= date('Y') ?> - <a href="/privacy-policy/">Политика конфиденциальности</a></span>
            <br />
            <span class="greyFont">Создание сайта: <a href="https://airlab.by/">airlab</a></span>
        </div>
    </div>

    <div onclick="scrollToTop()" id="scroll"><i class="fa fa-chevron-up" aria-hidden="true"></i></div>

</body>

</html>