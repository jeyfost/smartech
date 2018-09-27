<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 27.09.2018
 * Time: 11:02
 */

session_start();

include("../../scripts/connect.php");

if($_SESSION['userID'] != 1) {
    header("Location: ../../");
}

if(!empty($_REQUEST['id'])) {
    $orderCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_orders WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
    $orderCheck = $orderCheckResult->fetch_array(MYSQLI_NUM);

    if($orderCheck[0] == 0) {
        header("Location: /admin/orders");
    }
}

?>

<html>

<head>

    <meta charset="utf-8" />

    <title>Панель администрирования | Заказы</title>

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
    <script type="text/javascript" src="/js/admin/orders/index.js"></script>

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
        <div class="menuPointActive">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i><span> Заказы<?php if($ordersCount[0] > 0) {echo " (".$ordersCount[0].")";} ?></span>
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
    <span class="headerFont">Заказы</span>
    <br /><br />
    <input type='button' id='historySubmit' value='История заказов' onmouseover='buttonHover("historySubmit", 1)' onmouseout='buttonHover("historySubmit", 0)' onclick='window.location.href = "/admin/orders/history.php"' class='button' />
    <br /><br />
    <?php
        if(empty($_REQUEST['id'])) {
            if($ordersCount[0] == 0) {
                echo "На данный момент активных заявок нет.";
            } else {
                echo "
                <table class='ordersTable'>
                    <thead>
                        <tr>
                            <td>№</td>
                            <td>Ссылка на заказ</td>
                            <td>Детализация</td>
                            <td>Дата совершения заказа</td>
                            <td>Итоговая сумма</td>
                        </tr>
                    </thead>
                    <tbody>
            ";

                $i = 0;

                $orderResult = $mysqli->query("SELECT * FROM st_orders WHERE accepted = '0' ORDER BY date DESC");
                while($order = $orderResult->fetch_assoc()) {
                    $i++;

                    echo "
                    <tr>
                        <td>".$i."</td>
                        <td><a href='/admin/orders/?id=".$order['id']."'>Заказ №".$order['id']."</a></td>
                        <td style='text-align: left;'>
                ";

                    $j = 0;

                    $orderGoodResult = $mysqli->query("SELECT * FROM st_orders_goods WHERE order_id = '".$order['id']."'");
                    while($orderGood = $orderGoodResult->fetch_assoc()) {
                        $j++;

                        $goodResult = $mysqli->query("SELECT * FROM st_shop WHERE id = '".$orderGood['good_id']."'");
                        $good = $goodResult->fetch_assoc();

                        $categoryResult = $mysqli->query("SELECT * FROM st_shop_categories WHERE id = '".$good['category_id']."'");
                        $category = $categoryResult->fetch_assoc();

                        $subcategoryResult = $mysqli->query("SELECT * FROM st_shop_subcategories WHERE id = '".$good['subcategory_id']."'");
                        $subcategory = $subcategoryResult->fetch_assoc();

                        echo $j.". <a href='/shop/".$category['url']."/".$subcategory['url']."/".$good['url']."' target='_blank'>".$good['name']."</a><br />";
                    }

                    echo "
                        </td>
                        <td>".dateTimeToString($order['date'])."</td>
                        <td>".$order['price']." руб.</td>
                    </tr>
                ";
                }

                echo "
                    </tbody>
                </table>
            ";
            }
        } else {
            $orderResult = $mysqli->query("SELECT * FROM st_orders WHERE id = '".$mysqli->real_escape_string($_REQUEST['id'])."'");
            $order = $orderResult->fetch_assoc();

            echo "
                <h3>Заказ №".$order['id']."</h3>
                <br />
                <b>Заказчик:</b> ".$order['name']."
                <br />
                <b>Email:</b> <a href='mailto:".$order['email']."'>".$order['email']."</a>
                <br />
                <b>Phone:</b> ".$order['phone']."
                <br />
                <b>Дата совершения заказа:</b> ".dateTimeToString($order['date'])."
                <br /><br /><br /><br />
            ";

            $orderGoodResult = $mysqli->query("SELECT * FROM st_orders_goods WHERE order_id = '".$order['id']."'");
            while($orderGood = $orderGoodResult->fetch_assoc()) {
                $goodResult = $mysqli->query("SELECT * FROM st_shop WHERE id = '".$orderGood['good_id']."'");
                $good = $goodResult->fetch_assoc();

                $categoryResult = $mysqli->query("SELECT * FROM st_shop_categories WHERE id = '".$good['category_id']."'");
                $category = $categoryResult->fetch_assoc();

                $subcategoryResult = $mysqli->query("SELECT * FROM st_shop_subcategories WHERE id = '".$good['subcategory_id']."'");
                $subcategory = $subcategoryResult->fetch_assoc();

                echo "
                    <div class='basketRow'>
                        <div class='basketPhoto'><a href='/img/shop/big/".$good['photo']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-group='photos'><img src='/img/shop/small/".$good['preview']."' /></a></div>
                        <div class='basketDescription'>
                            <div class='basketNameFont'><a href='/shop/".$category['url']."/".$subcategory['url']."/".$good['url']."' class='transition'>".$good['name']."</a></div>
                            <br />
                            <div class='goodFont basketDescriptionText'>".$good['description']."</div>
                            <br />
                            <b>Цена за единицу:</b><span> ".calculatePrice($good['price'])."</span>
                        </div>
                        <div class='clear'></div>
                        <br /><hr /><br />
                    </div>
                ";
            }

            echo "<center><input type='button' id='acceptOrderSubmit' value='Принять заказ' onmouseover='buttonHover(\"acceptOrderSubmit\", 1)' onmouseout='buttonHover(\"acceptOrderSubmit\", 0)' onclick='acceptOrder(\"".$order['id']."\")' class='button' /></center>";
        }
    ?>
</div>

<script type="text/javascript">
    CKEDITOR.replace("text");
</script>

</body>

</html>
