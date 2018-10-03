<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 18.09.2018
 * Time: 12:38
 */

include("scripts/connect.php");

$url = explode("/", $_SERVER['REQUEST_URI']);

/*
 *  ///// МАГАЗИН /////
 *  ///$url[1] = 'shop' — магазин
 *  ///$url[2] — раздел первого уровня в магазине
 *  ///        — если число, то номер страницы со всеми товарами в каталоге
 *  ///$url[3] — раздел второго уровня в каталоге
 *  ///        — если число, то номер страницы с товарами из раздела первого уровня
 *  ///$url[4] — товар
 *  ///        — если число, то номер страницы с товарами из раздела второго уровня
 *  //////////////////
 *
 *  ///// ОСТАЛЬНЫЕ РАЗДЕЛЫ /////
 *  ///$url[1] — категория
 *  ///$url[2] —
 *  ///        — если empty, то выводить первую страницу категории
 *  ///        — если число, то выводить соответствующую страницу категории
 *  ///        — если строка, то выводить товар/услугу
 *  /////////////////////////////
 */

$categoryResult = $mysqli->query("SELECT * FROM st_catalogue_categories WHERE url = '".$mysqli->real_escape_string($url[1])."'");
$category = $categoryResult->fetch_assoc();

if($url[1] != "shop" and $url[1] != "blog") {
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
}

if($url[1] == "shop") {
    if(!empty($url[2])) {
        if($url[2] == 1) {
            header("Location: /shop");
        }

        $addressNew = (int)$url[2];
        $address = (string)$url[2];
        $addressNew = (string)$addressNew;

        if($address == $addressNew) {
            //$url[2] — номер страницы

            $quantityResult = $mysqli->query("SELECT COUNT(id) FROM st_shop");
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
                header("Location: /shop");
            }

            $start = $page * GOODS_ON_PAGE - GOODS_ON_PAGE;

            $type = "all";
        } else {
            $categoryCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_shop_categories WHERE url = '".$mysqli->real_escape_string($url[2])."'");
            $categoryCheck = $categoryCheckResult->fetch_array(MYSQLI_NUM);

            if($categoryCheck[0] == 0) {
                header("Location: /shop");
            } else {
                $categoryResult = $mysqli->query("SELECT * FROM st_shop_categories WHERE url = '".$mysqli->real_escape_string($url[2])."'");
                $category = $categoryResult->fetch_assoc();

                if(!empty($url[3])) {
                    if($url[3] == 1) {
                        header("Location: /shop/".$url[2]);
                    }

                    $addressNew = (int)$url[3];
                    $address = (string)$url[3];
                    $addressNew = (string)$addressNew;

                    if($address == $addressNew) {
                        //$url[3] — номер страницы

                        $quantityResult = $mysqli->query("SELECT COUNT(id) FROM st_shop WHERE category_id = '".$category['id']."'");
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
                            header("Location: /shop/".$url[2]);
                        }

                        $start = $page * GOODS_ON_PAGE - GOODS_ON_PAGE;

                        $type = "category";
                    } else {
                        $subcategoryCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_shop_subcategories WHERE category_id = '".$category['id']."' AND url = '".$mysqli->real_escape_string($url[3])."'");
                        $subcategoryCheck = $subcategoryCheckResult->fetch_array(MYSQLI_NUM);

                        if($subcategoryCheck[0] == 0) {
                            header("Location: /shop/".$url[2]);
                        } else {
                            $subcategoryResult = $mysqli->query("SELECT * FROM st_shop_subcategories WHERE url = '".$url[3]."'");
                            $subcategory = $subcategoryResult->fetch_assoc();

                            if(!empty($url[4])) {
                                if($url[4] == 1) {
                                    header("Location: /shop/".$url[2]."/".$url[3]);
                                }

                                $addressNew = (int)$url[4];
                                $address = (string)$url[4];
                                $addressNew = (string)$addressNew;

                                if($address == $addressNew) {
                                    //$url[3] — номер страницы

                                    $quantityResult = $mysqli->query("SELECT COUNT(id) FROM st_shop WHERE subcategory_id = '".$subcategory['id']."'");
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
                                        header("Location: /shop/".$url[2]."/".$url[3]);
                                    }

                                    $start = $page * GOODS_ON_PAGE - GOODS_ON_PAGE;

                                    $type = "subcategory";
                                } else {
                                    $goodCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_shop WHERE category_id = '".$category['id']."' AND subcategory_id = '".$subcategory['id']."' AND url = '".$mysqli->real_escape_string($url[4])."'");
                                    $goodCheck = $goodCheckResult->fetch_array();

                                    if($goodCheck[0] == 0) {
                                        header("Location: /shop/".$url[2]."/".$url[3]);
                                    } else {
                                        $type = "good";

                                        $goodResult = $mysqli->query("SELECT * FROM st_shop WHERE url = '".$mysqli->real_escape_string($url[4])."'");
                                        $good = $goodResult->fetch_assoc();

                                        if(!empty($url[5])) {
                                            header("Location: /shop/".$url[2]."/".$url[3]."/".$url[4]);
                                        }
                                    }
                                }
                            } else {
                                $type = "subcategory";

                                $quantityResult = $mysqli->query("SELECT COUNT(id) FROM st_shop WHERE subcategory_id = '".$subcategory['id']."'");
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

                                $start = $page * GOODS_ON_PAGE - GOODS_ON_PAGE;
                            }
                        }
                    }
                } else {
                    $type = "category";

                    $quantityResult = $mysqli->query("SELECT COUNT(id) FROM st_shop WHERE category_id = '".$category['id']."'");
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

                    $start = $page * GOODS_ON_PAGE - GOODS_ON_PAGE;
                }
            }
        }
    } else {
        $type = "all";

        $quantityResult = $mysqli->query("SELECT COUNT(id) FROM st_shop");
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

        $start = $page * GOODS_ON_PAGE - GOODS_ON_PAGE;
    }
}

if($url[1] == "blog") {
    //Условия для блога
    if(!empty($url[2])) {
        if($url[2] == 1) {
            header("Location: /blog");
        }

        $addressNew = (int)$url[2];
        $address = (string)$url[2];
        $addressNew = (string)$addressNew;

        if($address == $addressNew) {
            //$url[2] — номер страницы

            $quantityResult = $mysqli->query("SELECT COUNT(id) FROM st_blog");
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
                header("Location: /shop");
            }

            $start = $page * GOODS_ON_PAGE - GOODS_ON_PAGE;

            $type = "all";
        } else {
            $categoryCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_blog_categories WHERE url = '".$mysqli->real_escape_string($url[2])."'");
            $categoryCheck = $categoryCheckResult->fetch_array(MYSQLI_NUM);

            if($categoryCheck[0] == 0) {
                header("Location: /blog");
            } else {
                $categoryResult = $mysqli->query("SELECT * FROM st_blog_categories WHERE url = '".$mysqli->real_escape_string($url[2])."'");
                $category = $categoryResult->fetch_assoc();

                if(!empty($url[3])) {
                    if($url[3] == 1) {
                        header("Location: /blog/".$url[2]);
                    }

                    $addressNew = (int)$url[3];
                    $address = (string)$url[3];
                    $addressNew = (string)$addressNew;

                    if($address == $addressNew) {
                        //$url[3] — номер страницы

                        $quantityResult = $mysqli->query("SELECT COUNT(id) FROM st_blog WHERE category_id = '".$category['id']."'");
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
                            header("Location: /blog/".$url[2]);
                        }

                        $start = $page * GOODS_ON_PAGE - GOODS_ON_PAGE;

                        $type = "category";
                    } else {
                        $postCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_blog WHERE category_id = '".$category['id']."' AND url = '".$mysqli->real_escape_string($url[3])."'");
                        $postCheck = $postCheckResult->fetch_array();

                        if($postCheck[0] == 0) {
                            header("Location: /blog/".$url[2]);
                        } else {
                            $type = "post";

                            $postResult = $mysqli->query("SELECT * FROM st_blog WHERE url = '".$mysqli->real_escape_string($url[3])."'");
                            $post = $postResult->fetch_assoc();

                            if(!empty($url[4])) {
                                header("Location: /shop/".$url[2]."/".$url[3]);
                            }
                        }
                    }
                } else {
                    $type = "category";

                    $quantityResult = $mysqli->query("SELECT COUNT(id) FROM st_blog WHERE category_id = '".$category['id']."'");
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

                    $start = $page * GOODS_ON_PAGE - GOODS_ON_PAGE;
                }
            }
        }
    } else {
        $type = "all";

        $quantityResult = $mysqli->query("SELECT COUNT(id) FROM st_blog");
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

        $start = $page * GOODS_ON_PAGE - GOODS_ON_PAGE;
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
    <?php
        if($url[1] == "shop") {
            switch ($type) {
                case "all":
                    $title = $category['title'];
                    break;
                case "category":
                    $title = $category['name'];
                    break;
                case "subcategory":
                    $title = $subcategory['name'];
                    break;
                case "good":
                    $title = $good['name'];
                    break;
                default:
                    $title = $category['title'];
                    break;
            }
        } else {
            if($url[1] == "blog") {
                switch($type) {
                    case "all":
                        $title = $category['title'];
                        break;
                    case "category":
                        $title = $category['name'];
                        break;
                    case "post":
                        $title = $post['name'];
                        break;
                    default:
                        $title = $category['title'];
                        break;
                }
            } else {
                $title = $category['title'];
            }
        }
    ?>
    <title><?= $title ?></title>

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
<link rel="stylesheet" href="/libs/remodal/dist/remodal-default-theme.css" />
<link rel="stylesheet" href="/libs/remodal/dist/remodal.css" />
<link rel="stylesheet" href="/css/fonts.css" />
<link rel="stylesheet" href="/css/main.css" />
<link rel="stylesheet" href="/css/media.css" />

<link href="https://fonts.googleapis.com/css?family=Exo+2|Istok+Web|Montserrat|Poiret+One" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript" src="/libs/lightview/js/lightview/lightview.js"></script>
<script type="text/javascript" src="/libs/remodal/dist/remodal.min.js"></script>
<script type="text/javascript" src="/libs/notify/notify.js"></script>
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
            <?php
            $basketCountResult = $mysqli->query("SELECT COUNT(id) FROM st_basket WHERE ip = '".real_ip()."'");
            $basketCount = $basketCountResult->fetch_array(MYSQLI_NUM);
            ?>
            <a href="/basket"><div class="menuPoint" id="basketPoint"><i class="fa fa-shopping-cart" aria-hidden="true"></i><?php if($basketCount[0] > 0) {echo " (".$basketCount[0].")";} ?></div></a>
            <a href="/contacts"><div class="menuPoint">Контакты</div></a>
            <?php if($url[1] != "blog" or !empty($url[2])) {echo "<a href='/blog'>";} ?><div class="menuPoint <?php if($url[1] == "blog") {echo "active";} ?>">Блог</div><?php if($url[1] != "blog" or !empty($url[2])) {echo "</a>";} ?>
            <!--
            <?php //if($url[1] != "iot" or !empty($url[2])) {echo "<a href='/iot'>";} ?><div class="menuPoint <?php //if($url[1] == "iot") {echo "active";} ?>">IoT</div><?php //if($url[1] != "iot" or !empty($url[2])) {echo "</a>";} ?>
            <?php //if($url[1] != "engineering" or !empty($url[2])) {echo "<a href='/engineering'>";} ?><div class="menuPoint <?php //if($url[1] == "engineering") {echo "active";} ?>">Проектирование</div><?php //if($url[1] != "engineering" or !empty($url[2])) {echo "</a>";} ?>
            -->
            <?php if($url[1] != "study" or !empty($url[2])) {echo "<a href='/study'>";} ?><div class="menuPoint <?php if($url[1] == "study") {echo "active";} ?>">Обучение</div><?php if($url[1] != "study" or !empty($url[2])) {echo "</a>";} ?>
            <?php if($url[1] != "3d-print" or !empty($url[2])) {echo "<a href='/3d-print'>";} ?><div class="menuPoint <?php if($url[1] == "3d-print") {echo "active";} ?>">3D-печать</div><?php if($url[1] != "3d-print" or !empty($url[2])) {echo "</a>";} ?>
            <?php if($url[1] != "shop" or !empty($url[2])) {echo "<a href='/shop'>";} ?><div class="menuPoint <?php if($url[1] == "shop") {echo "active";} ?>">Магазин</div><?php if($url[1] != "shop" or !empty($url[2])) {echo "</a>";} ?>
            <a href="/"><div class="menuPoint">Главная</div></a>
        </div>
        <div class="clear"></div>
    </div>

    <div id="mobileMenu">
        <div class="mobileMenuPoint" style="text-align: right;">
            <i class="fa fa-times" aria-hidden="true" onclick="closeMobileMenu()"></i>
        </div>
        <div class="mobileMenuPoint"><a href="/"><span>Главная</span></a></div>
        <div class="mobileMenuPoint <?php if($url[1] == "shop") {echo "active";} ?>"><?php if($url[1] != "shop") {echo "<a href='/shop'>";} ?><span>Магазин</span><?php if($url[1] != "shop") {echo "</a>";} ?></div>
        <div class="mobileMenuPoint <?php if($url[1] == "3d-print") {echo "active";} ?>"><?php if($url[1] != "3d-print") {echo "<a href='/3d-print'>";} ?><span>3D-печать</span><?php if($url[1] != "3d-print") {echo "</a>";} ?></div>
        <div class="mobileMenuPoint <?php if($url[1] == "study") {echo "active";} ?>"><?php if($url[1] != "study") {echo "<a href='/study'>";} ?><span>Обучение</span><?php if($url[1] != "study") {echo "</a>";} ?></div>
        <!--
        <div class="mobileMenuPoint <?php //if($url[1] == "engineering") {echo "active";} ?>"><?php //if($url[1] != "engineering") {echo "<a href='/engineering'>";} ?><span>Проектирование</span><?php //if($url[1] != "engineering") {echo "</a>";} ?></div>
        <div class="mobileMenuPoint <?php //if($url[1] == "iot") {echo "active";} ?>"><?php //if($url[1] != "iot") {echo "<a href='/iot'>";} ?><span>IoT</span><?php //if($url[1] != "iot") {echo "</a>";} ?></div>
        -->
        <div class="mobileMenuPoint <?php if($url[1] == "blog") {echo "active";} ?>"><?php if($url[1] != "blog") {echo "<a href='/blog'>";} ?><span>Блог</span><?php if($url[1] != "blog") {echo "</a>";} ?></div>
        <div class="mobileMenuPoint"><a href="/contacts"><span>Контакты</span></a></div>
        <div class="mobileMenuPoint"><a href="/basket"><span id="mobileBasketPoint">Корзина<?php if($basketCount[0] > 0) {echo " (".$basketCount[0].")";} ?></span></a></div>
    </div>
</div>

<?php
    if($url[1] == "shop") {
        //Магазин
        echo "
            <div class='section white' id='section'>
                <div class='breadcrumbs'>
                    <a href='/'><i class='fa fa-home' aria-hidden='true'></i> Главная</a>
        ";

        if(empty($url[2])) {
            echo " > Магазин";
        } else {
            echo " > <a href='/shop'>Магазин</a>";
            if(!empty($url[3])) {
                if($type != "category") {
                    echo " > <a href='/shop/".$url[2]."'>".$category['name']."</a>";

                    if(!empty($url[4])) {
                        if($type != "subcategory") {
                            echo " > <a href='/shop/".$url[2]."/".$url[3]."'>".$subcategory['name']."</a> > ".$good['name'];
                        } else {
                            echo " > ".$subcategory['name'];
                        }
                    } else {
                        echo " > ".$subcategory['name'];
                    }
                } else {
                    echo " > ".$category['name'];
                }
            } else {
                echo " > ".$category['name'];
            }
        }

        echo "
                </div>
                <br />
                <table class='catalogueMenu'>
                    <thead>
                        <tr class='catalogueMenuPoint'>
                            <td class='tdHead'><i class='fa fa-level-down' aria-hidden='true'></i> Выберите раздел</td>
                        </tr>
                    </thead>
                    <tbody>
        ";

        $shopCategoryResult = $mysqli->query("SELECT * FROM st_shop_categories ORDER BY name");
        while($shopCategory = $shopCategoryResult->fetch_assoc()) {
            echo "
                <tr class='catalogueMenuPoint'>
                    <td id='category".$shopCategory['id']."' onclick='document.location = \"/shop/".$shopCategory['url']."\"' onmouseover='catalogueMenu(1, \"category".$shopCategory['id']."\", \"categoryName".$shopCategory['id']."\")' onmouseout='catalogueMenu(0, \"category".$shopCategory['id']."\", \"categoryName".$shopCategory['id']."\")'"; if(!empty($url[2]) and $url[2] == $shopCategory['url']) {echo " class='tdActive'";} echo ">
                        <a href='/shop/".$shopCategory['url']."'>
                            <span id='categoryName".$shopCategory['id']."'>".$shopCategory['name']."</span>
                        </a>
                    </td>
                </tr>
            ";

            if(!empty($url[2]) and $url[2] == $shopCategory['url']) {
                $shopSubcategoryResult = $mysqli->query("SELECT * FROM st_shop_subcategories WHERE category_id = '".$shopCategory['id']."'");
                while($shopSubcategory = $shopSubcategoryResult->fetch_assoc()) {
                    echo "
                        <tr class='catalogueMenuPoint'>
                            <td id='subcategory".$shopSubcategory['id']."' onclick='document.location = \"/shop/".$url[2]."/".$shopSubcategory['url']."\"' onmouseover='catalogueMenu(1, \"subcategory".$shopSubcategory['id']."\", \"subcategoryName".$shopSubcategory['id']."\")' onmouseout='catalogueMenu(0, \"subcategory".$shopSubcategory['id']."\", \"subcategoryName".$shopSubcategory['id']."\")'"; if(!empty($url[3]) and $url[3] == $shopSubcategory['url']) {echo " class='tdActive'";} echo ">
                                <a href='/shop/".$url[2]."/".$shopSubcategory['url']."'>
                                    <span id='subcategoryName".$shopSubcategory['id']."'>&nbsp;&nbsp;&nbsp;&nbsp;".$shopSubcategory['name']."</span>
                                </a>
                            </td>
                        </tr>
                    ";

                    if(!empty($url[3]) and $url[3] == $shopSubcategory['url']) {
                        $goodResult = $mysqli->query("SELECT * FROM st_shop WHERE subcategory_id = '".$shopSubcategory['id']."' ORDER BY name");
                        while($good = $goodResult->fetch_assoc()) {
                            echo "
                                <tr class='catalogueMenuPoint'>
                                    <td id='menuGood".$good['id']."' onclick='document.location = \"/shop/".$url[2]."/".$url[3]."/".$good['url']."\"' onmouseover='catalogueMenu(1, \"menuGood".$good['id']."\", \"menuGoodName".$good['id']."\")' onmouseout='catalogueMenu(0, \"menuGood".$good['id']."\", \"menuGoodName".$good['id']."\")'"; if(!empty($url[4]) and $url[4] == $good['url']) {echo " class='tdActive'";} echo ">
                                        <a href='/shop/".$url[2]."/".$url[3]."/".$good['url']."'>
                                            <span id='menuGoodName".$good['id']."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; — ".$good['name']."</span>
                                        </a>
                                    </td>
                                </tr>
                            ";
                        }
                    }
                }
            }
        }

        echo "
                    </tbody>
                </table>
                <div class='catalogueContent'>
                    <div class='header'>
                        <span class='headerFont'>
        ";

        switch($type) {
            case "all":
                echo "Интернет-магазин";
                break;
            case "category":
                echo $category['name'];
                break;
            case "subcategory":
                echo $subcategory['name'];
                break;
            case "good":
                $goodResult = $mysqli->query("SELECT * FROM st_shop WHERE url = '".$mysqli->real_escape_string($url[4])."'");
                $good = $goodResult->fetch_assoc();

                echo $good['name'];
                break;
            default:
                echo "Интернет-магазин";
                break;
        }

        echo "
                        </span>
                    </div>
                    <br /><br />
        ";

        switch($type) {
            case "all":
                $goodResult = $mysqli->query("SELECT * FROM st_shop ORDER BY name LIMIT ".$start.", ".GOODS_ON_PAGE);
                break;
            case "category":
                $goodResult = $mysqli->query("SELECT * FROM st_shop WHERE category_id = '".$category['id']."' ORDER BY name LIMIT ".$start.", ".GOODS_ON_PAGE);
                break;
            case "subcategory":
                $goodResult = $mysqli->query("SELECT * FROM st_shop WHERE subcategory_id = '".$subcategory['id']."' ORDER BY name LIMIT ".$start.", ".GOODS_ON_PAGE);
                break;
            case "good":
                $goodResult = $mysqli->query("SELECT * FROM st_shop WHERE url = '".$mysqli->real_escape_string($url[4])."'");
                break;
            default:
                $goodResult = $mysqli->query("SELECT * FROM st_shop ORDER BY name LIMIT ".$start.", ".GOODS_ON_PAGE);
                break;
        }

        if($type == "good") {
            $good = $goodResult->fetch_assoc();

            echo "
                <div class='goodDataRow'>
                    <div class='goodDataContainer'>
                        <span>Наименование: </span>
                        <span class='goodDataFont'>".$good['name']."</span>
                    </div>
                    <div class='goodDataContainer'>
                        <span>Артикул: </span>
                        <span class='goodDataFont'>".$good['code']."</span>
                    </div>
                    <div class='clear'></div>
                </div>
                <br />
                <div class='goodPhoto'>
                    <a href='/img/shop/big/".$good['photo']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-group='good'><img src='/img/shop/big/".$good['photo']."' /></a>
            ";

            $goodPhotoResult = $mysqli->query("SELECT * FROM st_shop_photos WHERE good_id = '".$good['id']."'");
            while($goodPhoto = $goodPhotoResult->fetch_assoc()) {
                echo "
                    <div class='goodAdditionalPhoto'>
                        <a href='/img/shop/big/".$goodPhoto['photo']."' class='lightview' data-lightview-options='skin: \"light\"' data-lightview-group='good'><img src='/img/shop/small/".$goodPhoto['preview']."' /></a>
                    </div>
                ";
            }

            $basketCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_basket WHERE good_id = '".$good['id']."' AND ip = '".real_ip()."'");
            $basketCheck = $basketCheckResult->fetch_array(MYSQLI_NUM);

            echo "
                </div>
                <div class='goodProperties'>
                    ".$good['description']."
                    <br /><br />
                    <div style='width: 100%' class='priceFont text-center'>
                        ".calculatePrice($good['price'])."
                        &nbsp;&nbsp;
                        <button class='activityButton' onmouseover='iconColor(\"icon".$good['id']."\", 1)' onmouseout='iconColor(\"icon".$good['id']."\", 0)' onclick='addToBasket(".$good['id'].")' title='"; if($basketCheck[0] > 0) {echo "Увеличить количество товара в корзине";} else {echo "Добавить товар в коризну";} echo "' id='addButton".$good['id']."'><i class='"; if($basketCheck[0] > 0) {echo "fa fa-cart-plus";} else {echo "fa fa-cart-arrow-down";} echo "' aria-hidden='true' id='icon".$good['id']."'></i></button>
                    </div>
                </div>
                <div class='clear'></div>
            ";
        } else {
            if($goodResult->num_rows > 0) {
                while($good = $goodResult->fetch_assoc()) {
                    $cResult = $mysqli->query("SELECT * FROM st_shop_categories WHERE id = '".$good['category_id']."'");
                    $c = $cResult->fetch_assoc();

                    $sResult = $mysqli->query("SELECT * FROM st_shop_subcategories WHERE id = '".$good['subcategory_id']."'");
                    $s = $sResult->fetch_assoc();

                    echo "
                    <div class='catalogueContainer flex' id='catalogueContainer".$good['id']."' name='".$good['id']."'>
                        <div class='cataloguePhoto'>
                            <a href='/shop/".$c['url']."/".$s['url']."/".$good['url']."'><img src='/img/shop/small/".$good['preview']."' /></a>
                        </div>
                        <div class='catalogueDescription' id='catalogueDescription".$good['id']."'>
                            <div class='catalogueName'>".$good['name']."</div>
                            <br />
                            <div class='catalogueDescription text-center'>".calculatePrice($good['price'])."</div>
                        </div>
                        <div class='catalogueButtonContainer text-center' id='showButton".$good['id']."'>
                            <a href='/shop/".$c['url']."/".$s['url']."/".$good['url']."'>
                                <button class='activityButton'>подробнее</button>
                            </a>
                ";

                    $basketCheckResult = $mysqli->query("SELECT COUNT(id) FROM st_basket WHERE good_id = '".$good['id']."' AND ip = '".real_ip()."'");
                    $basketCheck = $basketCheckResult->fetch_array(MYSQLI_NUM);

                    echo "
                            <button class='activityButton' onmouseover='iconColor(\"icon".$good['id']."\", 1)' onmouseout='iconColor(\"icon".$good['id']."\", 0)' onclick='addToBasket(".$good['id'].")' title='"; if($basketCheck[0] > 0) {echo "Увеличить количество товара в корзине";} else {echo "Добавить товар в коризну";} echo "' id='addButton".$good['id']."'><i class='"; if($basketCheck[0] > 0) {echo "fa fa-cart-plus";} else {echo "fa fa-cart-arrow-down";} echo "' aria-hidden='true' id='icon".$good['id']."'></i></button>
                        </div>
                    </div>
                ";
                }

                /* Блок с постраничной навигацией */
                switch($type) {
                    case "all":
                        $uri = $url[2];

                        if(empty($uri)) {
                            $uri = 1;
                        }

                        $link = "/".$category['url']."/";
                        break;
                    case "category":
                        $uri = $url[3];

                        if(empty($uri)) {
                            $uri = 1;
                        }

                        $link = "/shop/".$category['url']."/";
                        break;
                    case "subcategory":
                        $uri = $url[4];

                        if(empty($uri)) {
                            $uri = 1;
                        }

                        $link = "/shop/".$category['url']."/".$subcategory['url']."/";
                        break;
                    default:
                        break;
                }

                echo "<div class='text-center' style='width: 100%;'>";
                echo "<div id='pageNumbers'>";

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
            } else {
                echo "
                    <br />
                    <center>
                        <span class='basicFont'>На данный момент выбранный вами раздел пуст, однако мы работаем над его наполнением.</span>
                    </center>
                ";
            }
        }

        echo "
                </div>
                <div class='clear'></div>
            </div>
            <br /><br />
        ";
    } else {
        if($url[1] == "blog") {
            //Блог
            echo "
            <div class='section white' id='section'>
                <div class='breadcrumbs'>
                    <a href='/'><i class='fa fa-home' aria-hidden='true'></i> Главная</a>
        ";

            if(empty($url[2])) {
                echo " > Блог";
            } else {
                echo " > <a href='/blog'>Блог</a>";
                if(!empty($url[3])) {
                    if($type != "category") {
                        $postResult = $mysqli->query("SELECT * FROM st_blog WHERE url = '".$mysqli->real_escape_string($url[3])."'");
                        $post = $postResult->fetch_assoc();

                        echo " > <a href='/blog/".$url[2]."'>".$category['name']."</a> > ".$post['name'];
                    } else {
                        echo " > ".$category['name'];
                    }
                } else {
                    echo " > ".$category['name'];
                }
            }

            echo "
                </div>
                <br />
                <table class='catalogueMenu'>
                    <thead>
                        <tr class='catalogueMenuPoint'>
                            <td class='tdHead'><i class='fa fa-level-down' aria-hidden='true'></i> Выберите раздел</td>
                        </tr>
                    </thead>
                    <tbody>
            ";

            $blogCategoryResult = $mysqli->query("SELECT * FROM st_blog_categories ORDER BY name");
            while($blogCategory = $blogCategoryResult->fetch_assoc()) {
                echo "
                    <tr class='catalogueMenuPoint'>
                        <td id='category" . $blogCategory['id'] . "' onclick='document.location = \"/blog/" . $blogCategory['url'] . "\"' onmouseover='catalogueMenu(1, \"category" . $blogCategory['id'] . "\", \"categoryName" . $blogCategory['id'] . "\")' onmouseout='catalogueMenu(0, \"category" . $blogCategory['id'] . "\", \"categoryName" . $blogCategory['id'] . "\")'";
                    if (!empty($url[2]) and $url[2] == $blogCategory['url']) {
                        echo " class='tdActive'";
                    }
                    echo ">
                            <a href='/blog/" . $blogCategory['url'] . "'>
                                <span id='categoryName" . $blogCategory['id'] . "'>" . $blogCategory['name'] . "</span>
                            </a>
                        </td>
                    </tr>
                ";

                if(!empty($url[2]) and $url[2] == $blogCategory['url']) {
                    $postResult = $mysqli->query("SELECT * FROM st_blog WHERE category_id = '".$blogCategory['id']."' ORDER BY name");
                    while($post = $postResult->fetch_assoc()) {
                        echo "
                            <tr class='catalogueMenuPoint'>
                                <td id='menuGood".$post['id']."' onclick='document.location = \"/blog/".$url[2]."/".$post['url']."\"' onmouseover='catalogueMenu(1, \"menuGood".$post['id']."\", \"menuGoodName".$post['id']."\")' onmouseout='catalogueMenu(0, \"menuGood".$post['id']."\", \"menuGoodName".$post['id']."\")'"; if(!empty($url[3]) and $url[3] == $post['url']) {echo " class='tdActive'";} echo ">
                                    <a href='/blog/".$url[2]."/".$post['url']."'>
                                        <span id='menuGoodName".$post['id']."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; — ".$post['name']."</span>
                                    </a>
                                </td>
                            </tr>
                        ";
                    }
                }
            }

            echo "
                    </tbody>
                </table>
                </div>
                <div class='catalogueContent'>
                    <div class='header'>
                        <span class='headerFont'>
            ";

            switch ($type) {
                case "all":
                    echo "Блог";
                    break;
                case "category":
                    echo $category['name'];
                    break;
                case "post":
                    $postResult = $mysqli->query("SELECT * FROM st_blog WHERE url = '".$mysqli->real_escape_string($url[3])."'");
                    $post = $postResult->fetch_assoc();

                    echo $post['name'];
                    break;
                default:
                    break;
            }

            echo "
                        </span>
                    </div>
            ";

            switch($type) {
                case "all":
                    $postResult = $mysqli->query("SELECT * FROM st_blog ORDER BY date DESC LIMIT ".$start.", ".GOODS_ON_PAGE);
                    break;
                case "category":
                    $postResult = $mysqli->query("SELECT * FROM st_blog WHERE category_id = '".$category['id']."' ORDER BY date DESC LIMIT ".$start.", ".GOODS_ON_PAGE);
                    break;
                default:
                    $postResult = $mysqli->query("SELECT * FROM st_blog ORDER BY date DESC LIMIT ".$start.", ".GOODS_ON_PAGE);
                    break;
            }

            if($type == "post") {
                echo "
                    <br />
                    <span class='catalogueDate'>".dateTimeToString($post['date'])."</span>
                    <br /><br />
                    <div class='postPhoto'>
                        <a href='/img/blog/big/".$post['photo']."' class='lightview' data-lightview-options='skin: \"light\"'><img src='/img/blog/small/".$post['preview']."' /></a>
                    </div>
                    <br /><br />
                    <div class='basicFont'>".$post['text']."</div>
                    <br /><br />
                    <center>
                    <a href='/blog/".$url['2']."'>
                        <button class='activityButton'><i class='fa fa-angle-left' aria-hidden='true'></i> назад к списку статей</button>
                    </a>
                    </center>
                ";
            } else {
                if($postResult->num_rows > 0) {
                    while($post = $postResult->fetch_assoc()) {
                        $cResult = $mysqli->query("SELECT * FROM st_blog_categories WHERE id = '".$post['category_id']."'");
                        $c = $cResult->fetch_assoc();

                        echo "
                        <div class='catalogueContainer flex' id='catalogueContainer".$post['id']."' name='".$post['id']."'>
                            <div class='cataloguePhoto'>
                                <a href='/blog/".$c['url']."/".$post['url']."'><img src='/img/blog/small/".$post['preview']."' /></a>
                            </div>
                            <div class='catalogueDescription' id='catalogueDescription".$post['id']."'>
                                <div class='catalogueName'>".$post['name']."</div>
                                <br />
                                <div class='catalogueDate'>".dateTimeToString($post['date'])."</div>
                                <br />
                                <div class='catalogueDescriptionContainer'>".$post['description']."</div>
                            </div>
                            <div class='catalogueButtonContainer text-center' id='showButton".$post['id']."'>
                                <a href='/blog/".$c['url']."/".$post['url']."'>
                                    <button class='activityButton'>читать полностью</button>
                                </a>
                            </div>
                        </div>
                    ";
                    }

                    /* Блок с постраничной навигацией */
                    switch($type) {
                        case "all":
                            $uri = $url[2];

                            if(empty($uri)) {
                                $uri = 1;
                            }

                            $link = "/".$category['url']."/";
                            break;
                        case "category":
                            $uri = $url[3];

                            if(empty($uri)) {
                                $uri = 1;
                            }

                            $link = "/blog/".$category['url']."/";
                            break;
                        default:
                            break;
                    }

                    echo "<div class='text-center' style='width: 100%;'>";
                    echo "<div id='pageNumbers'>";

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
                } else {
                    echo "
                        <br />
                        <center>
                            <span class='basicFont'>На данный момент выбранный вами раздел пуст, однако мы работаем над его наполнением.</span>
                        </center>
                    ";
                }
            }

            echo "
                </div>
                <div class='clear'></div>
                <br /><br />
            ";
        } else {
            //Разделы сайта
            echo "
            <div class='section white' id='section'>
                <div class='header'>
                    <br /><br />
                    <span class='headerFont'>
        ";

            if($type == "good") {
                $goodResult = $mysqli->query("SELECT * FROM st_catalogue WHERE url = '".$mysqli->real_escape_string($url[2])."'");
                $good = $goodResult->fetch_assoc();

                echo $good['name'];
            } else {
                echo $category['title'];
            }

            echo "            
                        </span>
                    <br />
                </div>
            </div>
            
            <div class='section100 grey text-center' style='margin-top: 30px; padding-bottom: 100px;'>
                <br />
        ";

            if($type != "good") {
                //Список всех товаров и услуг
                $catalogueResult = $mysqli->query("SELECT * FROM st_catalogue WHERE category_id = '".$category['id']."' ORDER BY id DESC LIMIT ".$start.", ".GOODS_ON_PAGE);

                if($catalogueResult->num_rows > 0) {
                    while($catalogue = $catalogueResult->fetch_assoc()) {
                        echo "
                            <div class='catalogueContainer' id='catalogueContainer".$catalogue['id']."' name='".$catalogue['id']."'>
                                <div class='goodOverlay' id='goodOverlay".$catalogue['id']."' onclick='expand(\"".$catalogue['id']."\")'>
                                    <div class='goodOverlayContent'><i class=\"fa fa-angle-double-down\" aria-hidden=\"true\"></i></div>
                                </div>
                                <div class='cataloguePhoto'>
                                    <a href='/".$category['url']."/".$catalogue['url']."'><img src='/img/catalogue/small/".$catalogue['preview']."' /></a>
                                </div>
                                <div class='catalogueDescription' id='catalogueDescription".$catalogue['id']."'>
                                    <div class='catalogueName'>".$catalogue['name']."</div>
                                    <div class='catalogueShortDescription'>".$catalogue['description']."</div>
                                </div>
                                <div class='catalogueButtonContainer text-center' id='catalogueButtonContainer".$catalogue['id']."'>
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
                            <br />
                            <a data-remodal-target=\"modal\"><button class='activityButton' onmouseover='iconColor(\"icon\", 1)' onmouseout='iconColor(\"icon\", 0)'>заказать&nbsp;&nbsp;<i class='fa fa-handshake-o' aria-hidden='true' id='icon' style='color: #ededed;'></i></button></a>
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
                        <br />
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

            echo "
                </div>
                
                <div class='remodal' data-remodal-id='modal' data-remodal-options='closeOnConfirm: false'>
                    <button data-remodal-action='close' class='remodal-close'></button>
                    <div style='width: 80%; margin: 0 auto;'><h1>Задайте свой вопрос или закажите<br /><span style='color: #fb5c25;'>&laquo;".$good['name']."&raquo;</span></h1></div>
                    <br /><br />
                    <form method='post' id='modalForm'>
                        <input id='nameInput' name='name' placeholder='Имя' />
                        <br /><br />
                        <input id='emailInput' name='email' placeholder='E-mail' />
                        <br /><br />
                        <input id='phoneInput' name='phone' placeholder='Номер телефона' />
                        <br /><br />
                        <textarea id='textInput' name='text' placeholder='Сообщение'></textarea>
                        <br /><br />
                        <div class='g-recaptcha' data-sitekey='6LfBT0MUAAAAAOMa_302KKxDduJbyDkaB3bYTwGB'></div>
                    </form>
                    <br /><br />
                    <button data-remodal-action='confirm' class='remodal-confirm' onclick='send(\"".$good['id']."\")'>Отправить&nbsp;&nbsp;&nbsp;<i class='fa fa-share' aria-hidden='true'></i></button>
                </div>
            ";
        }
    }
?>

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