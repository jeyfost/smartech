<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 27.09.2018
 * Time: 14:15
 */

session_start();

include("../../scripts/connect.php");

if(!empty($_REQUEST['p'])) {
    if(!is_numeric($_REQUEST['p'])) {
        header("Location: /admin/orders/history.php");
    }

    if($_REQUEST['p'] == 1) {
        header("Location: /admin/orders/history.php");
    }
}

$quantityResult = $mysqli->query("SELECT COUNT(id) FROM st_orders WHERE accepted = '1'");
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

if(!empty($_REQUEST['p'])) {
    $page = $_REQUEST['p'];
} else {
    $page = 1;
}

if($page < 1 or $page > $numbers) {
    header("Location: /admin/orders/history.php");
}

$start = $page * GOODS_ON_PAGE - GOODS_ON_PAGE;

?>

<html>

<head>

    <meta charset="utf-8" />

    <title>Панель администрирования | История заказов</title>

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
    <script type="text/javascript" src="/js/admin/orders/history.js"></script>

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
    <span class="headerFont">История заказов</span>
    <br /><br />
    <input type='button' id='ordersSubmit' value='Активные заявки' onmouseover='buttonHover("ordersSubmit", 1)' onmouseout='buttonHover("ordersSubmit", 0)' onclick='window.location.href = "/admin/orders"' class='button' />
    <br /><br />
    <table class='ordersTable'>
        <thead>
        <tr>
            <td>№</td>
            <td>Ссылка на заказ</td>
            <td>Детализация</td>
            <td>Дата совершения заказа</td>
            <td>Итоговая сумма</td>
            <td>Статус заказа</td>
        </tr>
        </thead>
        <tbody>
        <?php
            $i = $page * 10 - 10;

            $orderResult = $mysqli->query("SELECT * FROM st_orders WHERE accepted = '1' ORDER BY date DESC LIMIT ".$start.", ".GOODS_ON_PAGE);
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
                        <td>Принят</td>
                    </tr>
                ";
            }
        ?>
        </tbody>
    </table>
    <br /><br >
    <?php
        /* Блок с постраничной навигацией */
        echo "<div class='text-center' style='width: 100%;'>";
        echo "<div id='pageNumbers'>";

        if(empty($_REQUEST['p'])) {
            $uri = 1;
        } else {
            $uri = $_REQUEST['p'];
        }

        $link = "/admin/orders/history.php?p=";

        if($numbers > 1) {
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
        /* Конец блока с постраничной навигацией */
    ?>
</div>

</body>

</html>