<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 30.01.2018
 * Time: 13:02
 */

include('../scripts/connect.php');

?>

<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->
<head>
    <title>Контактная информация</title>

    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/manifest.json">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/css/fonts.css" />
    <link rel="stylesheet" href="/css/main.css" />
    <link rel="stylesheet" href="/css/media.css" />

    <link href="https://fonts.googleapis.com/css?family=Exo+2|Istok+Web|Montserrat|Poiret+One" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script type="text/javascript" src="/libs/notify/notify.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
    <script type="text/javascript" src="/js/contacts.js"></script>

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
            <?php
            $basketCountResult = $mysqli->query("SELECT COUNT(id) FROM st_basket WHERE ip = '".real_ip()."'");
            $basketCount = $basketCountResult->fetch_array(MYSQLI_NUM);
            ?>
            <a href="/basket"><div class="menuPoint"><i class="fa fa-shopping-cart" aria-hidden="true"></i><?php if($basketCount[0] > 0) {echo " (".$basketCount[0].")";} ?></div></a>
            <a href="/contacts"><div class="menuPoint active">Контакты</div></a>
            <a href="/blog"><div class="menuPoint">Блог</div></a>
            <a href="/iot"><div class="menuPoint">IoT</div></a>
            <a href="/engineering"><div class="menuPoint">Проектирование</div></a>
            <a href="/study"><div class="menuPoint">Обучение</div></a>
            <a href="/3d-print"><div class="menuPoint">3D-печать</div></a>
            <a href="/shop"><div class="menuPoint">Магазин</div></a>
            <a href="/"><div class="menuPoint">Главная</div></a>
        </div>
        <div class="clear"></div>
    </div>

    <div id="mobileMenu">
        <div class="mobileMenuPoint" style="text-align: right;">
            <i class="fa fa-times" aria-hidden="true" onclick="closeMobileMenu()"></i>
        </div>
        <div class="mobileMenuPoint"><a href="/"><span>Главная</span></a></div>
        <div class="mobileMenuPoint"><a href="/shop"><span>3D-принтеры</span></a></div>
        <div class="mobileMenuPoint"><a href="/3d-print"><span>3D-печать</span></a></div>
        <div class="mobileMenuPoint"><a href="/study"><span>Обучение</span></a></div>
        <div class="mobileMenuPoint"><a href="/engineering"><span>Проектирование</span></a></div>
        <div class="mobileMenuPoint"><a href="/iot"><span>IoT</span></a></div>
        <div class="mobileMenuPoint"><a href="/blog"><span>Блог</span></a></div>
        <div class="mobileMenuPoint active"><a href="/contacts"><span>Контакты</span></a></div>
        <div class="mobileMenuPoint"><a href="/basket"><span>Корзина<?php if($basketCount[0] > 0) {echo " (".$basketCount[0].")";} ?></span></a></div>
    </div>
</div>

<div class="section grey" style="width: 100%; margin-top: 80px;">
    <div class="header">
        <br /><br />
        <span class="headerFont" id="policyHeader">Контактная информация</span>
        <br /><br /><br /><br />
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

    <div class="section text-center" style="margin-top: 50px;">
        <div class="column firstColumn">
            <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Республика Беларусь, г. Минск,<br />ул. Стариновская, 17
        </div>
        <div class="column text-center">
            <i class="fa fa-mobile" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;+375 (29) 573-77-53
            <br />
            <i class="fa fa-mobile" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;+375 (29) 536-16-50
        </div>
        <div class="column">
            <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<?= CONTACT_EMAIL ?>
        </div>
        <div class="clear"></div>
        <br /><br />
    </div>
</div>

<div class="section white" style="margin-top: 50px;">
    <div class="header">
        <br /><br />
        <span class="headerFont" id="policyHeader">Напишите нам</span>
    </div>

    <div class="container60">
        <form id="contactForm" name="contactForm">
            <label for="nameInput">Ваше имя:</label>
            <br />
            <input id="nameInput" name="name" />
            <br /><br />
            <label for="emailInput">Ваш email:</label>
            <br />
            <input id="emailInput" name="email" />
            <br /><br />
            <label for="phoneInput">Ваш номер телефона:</label>
            <br />
            <input id="phoneInput" name="phone" />
            <br /><br />
            <label for="messageInput">Текст сообщения:</label>
            <br />
            <textarea id="messageInput" name="message" onkeydown="textAreaHeight(this)" style="width: 95%;"></textarea>
            <br /><br />
            <div class="g-recaptcha" data-sitekey="6LfBT0MUAAAAAOMa_302KKxDduJbyDkaB3bYTwGB"></div>
            <br />
            <center><button onclick="sendEmail()" class="messageButton" id="messageButton">отправить&nbsp;&nbsp;&nbsp;<i class="fa fa-share" aria-hidden="true"></i></button></center>
        </form>
    </div>
</div>

<div class="section"></div>

<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Afc2ae729f9c3630a7e108c5c0d286b768b38dacde8758c922b3c6db85ce676a6&amp;width=100%&amp;height=470&amp;lang=ru_RU&amp;scroll=false"></script>

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