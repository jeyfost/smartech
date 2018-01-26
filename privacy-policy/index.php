<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 26.01.2018
 * Time: 18:30
 */

include("../scripts/connect.php");
?>

<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->
<head>
    <title>Политика конфиденциальности</title>

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
    <script type="text/javascript" src="/js/common.js"></script>

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
                <a href="/iot/"><div class="menuPoint">IoT</div></a>
                <a href="/engineering/"><div class="menuPoint">Проектирование</div></a>
                <a href="/study/"><div class="menuPoint">Обучение</div></a>
                <a href="/3d-print/"><div class="menuPoint">3D-печать</div></a>
                <a href="/3d-printers/"><div class="menuPoint">3D-принтеры</div></a>
                <a href="/"><div class="menuPoint">Главная</div></a>
            </div>
            <div class="clear"></div>
        </div>

        <div id="mobileMenu">
            <div class="mobileMenuPoint" style="text-align: right;">
                <i class="fa fa-times" aria-hidden="true" onclick="closeMobileMenu()"></i>
            </div>
            <div class="mobileMenuPoint"><a href="/"><span>Главная</span></a></div>
            <div class="mobileMenuPoint"><a href="/3d-printers/"><span>3D-принтеры</span></a></div>
            <div class="mobileMenuPoint"><a href="/3d-print/"><span>3D-печать</span></a></div>
            <div class="mobileMenuPoint"> <a href="/study/"><span>Обучение</span></a></div>
            <div class="mobileMenuPoint"><a href="/engineering/"><span>Проектирование</span></a></div>
            <div class="mobileMenuPoint"><a href="/iot/"><span>IoT</span></a></div>
            <div class="mobileMenuPoint"><a href="/contacts/"><span>Контакты</span></a></div>
        </div>
    </div>

    <div class="section white" id="policySection">
        <div class="header">
            <br /><br />
            <span class="headerFont" id="policyHeader">Политика конфиденциальности</span>
            <br />
        </div>
        <div class="orangeLine"></div>
        <br />
        <div class="text-center smallHeaderFont">
            <p>Эта страница содержит информацию о нашей политике конфиденциальности, сборе, использовании и освещении персональной информации, предоставленной нам пользователями сайта.</p>
        </div>
        <div class="orangeLine"></div>
        <br />
        <div class="text-center basicFont">
            <p>Мы используем Вашу личную информацию только для улучшения сайта. Используя наш сайт, вы соглашаетесь на сбор и использование информации в соответствии с этой политикой.</p>
        </div>

        <div class="basicFont policyContainer grey">
            <span class="policyHeaderFont">Сбор и использование информации</span>
            <br />
            <div class="orangeLeftLine"></div>
            <br />
            <p>Во время использования сайта мы можем попросить Вас предоставить нам определённую персональную идентифицирующую Вас информацию, которая может быть использована для связи с Вами или установления Вашей личности. Данная информация может включать в себя (но не ограничивается только лишь следующими пунктами):</p>
            <ul>
                <li>Ваше имя;</li>
                <li>личную информацию;</li>
                <li>данные логов.</li>
            </ul>
            <p>Как и каждый владелец сайта, мы собираем информацию, которую Ваш браузер в любом случае отправляет в момент входа на сайт.</p>
        </div>

        <div class="basicFont policyContainer white">
            <span class="policyHeaderFont">Данные логов</span>
            <br />
            <div class="orangeLeftLine"></div>
            <br />
            <p>Данные логов могут включать в себя следующую информацию:</p>
            <ul>
                <li>Ваш IP-адрес;</li>
                <li>тип браузера;</li>
                <li>версию браузера;</li>
                <li>страницы нашего сайта, которые Вы посетили;</li>
                <li>дата и время Вашего визита;</li>
                <li>время проведённое на каждой странице;</li>
                <li>и другую системную информацию.</li>
            </ul>
            <p>В дополнение, мы можем использовать данные сторонних сервисов, таких, например, как Google Analytics, которые собирают, отслеживают и анализируют Ваши данные. Данные логов необходимы для подобных сервисов, занимающихся анализом статистики.</p>
        </div>

        <div class="basicFont policyContainer grey">
            <span class="policyHeaderFont">Связь</span>
            <br />
            <div class="orangeLeftLine"></div>
            <br />
            <p>Мы можем использовать Вашу личную информацию для связи с Вами при помощи новостных рассылок, маркетинговых и рекламных материалов или иных информационных методов.</p>
        </div>

        <div class="basicFont policyContainer white">
            <span class="policyHeaderFont">Файлы &laquo;Cookies&raquo;</span>
            <br />
            <div class="orangeLeftLine"></div>
            <br />
            <p>&laquo;Cookies&raquo; — это файлы с небольшим количеством информации, которые могут содержать анонимные уникальные идентификаторы. Данные файлы отправляется сайтом Вашему браузеру и хранятся на Вашем жёстком диске. Как и многие другие сайты, мы используем файлы &laquo;cookies&raquo; для сбора информации. Вы можете дать указание вашему браузеру запретить использование этих файлов или получать уведомление каждый раз, когда браузер собирается эти файлы принять. Однако, если Вы не принимаете файлы &laquo;cookies&raquo;, некоторые разделы нашего сайта могут отображаться не корректно.</p>
        </div>

        <div class="basicFont policyContainer grey">
            <span class="policyHeaderFont">Безопасность</span>
            <br />
            <div class="orangeLeftLine"></div>
            <br />
            <p>Безопасность Вашей личной информации очень важна для нас, но помните, что не существует метода передачи через сеть Интернет и метода хранения на электронных носителях на 100% безопасного. Хотя мы стремимся использовать надёжные средства защиты Вашей личной информации, мы не можем гарантировать её абсолютную безопасность из-за характера процесса.</p>
        </div>

        <div class="basicFont policyContainer white">
            <span class="policyHeaderFont">Изменения в политике конфиденциальности</span>
            <br />
            <div class="orangeLeftLine"></div>
            <br />
            <p>Эта политика конфиденциальности актуальна на <?= dateToString(date('Y-m-d')) ?> г. и будет оставаться в силе в дальнейшем, за исключением изменений в её положениях, которые вступят в силу сразу же после публикации на этой странице.</p>
            <p>Мы оставляем за собой право обновлять или изменять политику конфиденциальности в любое время. Для того, чтобы быть в курсе изменений, Вам необходимо периодически проверять данную страницу. Ваше дальнейшее использование сайта после внесения любых изменений в политику конфиденциальности на данной странице будет означать Ваше подтверждение изменений и Ваше согласие действовать в рамках изменённой политики конфиденциальности.</p>
        </div>

        <div class="basicFont policyContainer grey">
            <span class="policyHeaderFont">Свяжитесь с нами</span>
            <br />
            <div class="orangeLeftLine"></div>
            <br />
            <p>Если у вас есть вопросы по повду политики конфиденциальности, пожалуйста, свяжитесь с нами.</p>
        </div>

        <div class="basicFont policyContainer white" style="margin: 0;"></div>
    </div>

    <div id="footer">
        <div class="section" style="margin: 0 auto; width: 90%;">
            <div class="footerLogo text-center">
                <a href="/"><img src="/img/system/logo_white_text_small.png" /></a>
                <br /><br />
                <a href="#" target="_blank"><i class="fa fa-vk" aria-hidden="true"></i></a>
                &nbsp;&nbsp;&nbsp;
                <a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
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
        </div>
    </div>

    <div onclick="scrollToTop()" id="scroll"><i class="fa fa-chevron-up" aria-hidden="true"></i></div>

</body>

</html>