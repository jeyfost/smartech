<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 25.09.2018
 * Time: 16:07
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
    <title>Корзина</title>

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
    <link rel="stylesheet" href="/libs/lightview/css/lightview/lightview.css" />
    <link rel="stylesheet" href="/libs/remodal/dist/remodal-default-theme.css" />
    <link rel="stylesheet" href="/libs/remodal/dist/remodal.css" />
    <link rel="stylesheet" href="/css/fonts.css" />
    <link rel="stylesheet" href="/css/main.css" />
    <link rel="stylesheet" href="/css/media.css" />

    <link href="https://fonts.googleapis.com/css?family=Exo+2|Istok+Web|Montserrat|Poiret+One" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/libs/notify/notify.js"></script>
    <script type="text/javascript" src="/libs/lightview/js/lightview/lightview.js"></script>
    <script type="text/javascript" src="/libs/remodal/dist/remodal.min.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
    <script type="text/javascript" src="/js/basket.js"></script>

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
                <a href="/basket"><div class="menuPoint active"><i class="fa fa-shopping-cart" aria-hidden="true"></i><?php if($basketCount[0] > 0) {echo " (".$basketCount[0].")";} ?></div></a>
                <a href="/contacts"><div class="menuPoint">Контакты</div></a>
                <a href="/blog"><div class="menuPoint">Блог</div></a>
                <!--
                <a href="/iot"><div class="menuPoint">IoT</div></a>
                <a href="/engineering"><div class="menuPoint">Проектирование</div></a>
                -->
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
            <div class="mobileMenuPoint"><a href="/shop"><span>Магазин</span></a></div>
            <div class="mobileMenuPoint"><a href="/3d-print"><span>3D-печать</span></a></div>
            <div class="mobileMenuPoint"><a href="/study"><span>Обучение</span></a></div>
            <!--
            <div class="mobileMenuPoint"><a href="/engineering"><span>Проектирование</span></a></div>
            <div class="mobileMenuPoint"><a href="/iot"><span>IoT</span></a></div>
            -->
            <div class="mobileMenuPoint"><a href="/blog"><span>Блог</span></a></div>
            <div class="mobileMenuPoint"><a href="/contacts"><span>Контакты</span></a></div>
            <div class="mobileMenuPoint active"><a href="/basket"><span>Корзина<?php if($basketCount[0] > 0) {echo " (".$basketCount[0].")";} ?></span></a></div>
        </div>
    </div>

    <div class="section white" style="width: 100%; margin-top: 80px;">
        <div class="header">
            <br /><br />
            <span class="headerFont" id="policyHeader">Корзина</span>
            <br /><br />
            <?php
                if($basketCount[0] == 0) {
                    echo "<span class='goodFont'>На данный момент Ваша корзина пуста. Для того, чтобы совершить покупку, перейдти в <a href='/shop' class='link'>магазин</a>.</span>";
                } else {
                    $total = 0;

                    $basketResult = $mysqli->query("SELECT * FROM st_basket WHERE ip = '".real_ip()."' ORDER BY id");
                    while($basket = $basketResult->fetch_assoc()) {
                        $goodResult = $mysqli->query("SELECT * FROM st_shop WHERE id = '".$basket['good_id']."'");
                        $good = $goodResult->fetch_assoc();

                        $total += $basket['quantity'] * $good['price'];

                        $categoryURLResult = $mysqli->query("SELECT url FROM st_shop_categories WHERE id = '".$good['category_id']."'");
                        $categoryURL = $categoryURLResult->fetch_array(MYSQLI_NUM);

                        $subcategoryURLResult = $mysqli->query("SELECT url FROM st_shop_subcategories WHERE id = '".$good['subcategory_id']."'");
                        $subcategoryURL = $subcategoryURLResult->fetch_array(MYSQLI_NUM);

                        echo "
                            <div class='basketRow'>
                                <div class='basketPhoto'><a href='/img/shop/big/".$good['photo']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-group='photos'><img src='/img/shop/small/".$good['preview']."' /></a></div>
                                <div class='basketDescription'>
                                    <div class='basketNameFont'><a href='/shop/".$categoryURL[0]."/".$subcategoryURL[0]."/".$good['url']."' class='transition'>".$good['name']."</a></div>
                                    <br />
                                    <div class='goodFont basketDescriptionText'>".$good['description']."</div>
                                    <br />
                                    <b>Цена за единицу:</b><span> ".calculatePrice($good['price'])."</span>
                                </div>
                                <div class='basketControls'>
                                    <i class='fa fa-times icon transition' aria-hidden='true' title='Удалить этот товар из корзины' onclick='deleteGood(\"".$good['id']."\")'></i>
                                    <br /><br />
                                    <form id='quantityForm".$good['id']."' name='quantityForm".$good['id']."'>
                                        <input id='quantityInput".$good['id']."' name='quantity".$good['id']."' value='".$basket['quantity']."' class='goodFont' onkeyup='changeGoodQuantity(\"".$good['id']."\")' />
                                    </form>
                                </div>
                                <div class='clear'></div>
                                <br /><hr /><br />
                            </div>
                        ";
                    }

                    echo "
                        <br />
                        <b style='font-size: 24px;'>Итого:</b><span class='priceFont' id='totalPrice'> ".calculatePrice($total)."</span>
                        <br /><br />
                        <a data-remodal-target='modal'><button class='activityButton'>оформить заказ</button></a>
                        <button class='activityButtonDelete' onclick='clearBasket()'><i class='fa fa-trash-o' aria-hidden='true'></i> очистить корзину</button>
                    ";
                }
            ?>
        </div>
    </div>

    <div class='remodal' data-remodal-id='modal' data-remodal-options='closeOnConfirm: false'>
        <button data-remodal-action='close' class='remodal-close'></button>
        <div style='width: 80%; margin: 0 auto;'><h1>Оставьте свои данные</h1></div>
        <br /><br />
        <form method='post' id='modalForm'>
            <input id='nameInput' name='name' placeholder='Имя' />
            <br /><br />
            <input id='emailInput' name='email' placeholder='E-mail' />
            <br /><br />
            <input id='phoneInput' name='phone' placeholder='Номер телефона' />
        </form>
        <br /><br />
        <button data-remodal-action='confirm' class='remodal-confirm' onclick='sendOrder()'>Отправить&nbsp;&nbsp;&nbsp;<i class='fa fa-share' aria-hidden='true'></i></button>
    </div>

    <br /><br />

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