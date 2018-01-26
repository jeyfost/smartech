<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->
<head>
	<title>smARTech</title>

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

    <link rel="stylesheet" href="/libs/revealator-master/fm.revealator.jquery.css" />
    <link rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="/css/fonts.css" />
	<link rel="stylesheet" href="/css/main.css" />
	<link rel="stylesheet" href="/css/media.css" />

    <link href="https://fonts.googleapis.com/css?family=Exo+2|Istok+Web|Montserrat|Poiret+One" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/libs/revealator-master/fm.revealator.jquery.js"></script>
    <script type="text/javascript" src="/libs/vide/jquery.vide.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
    <script type="text/javascript" src="/js/index.js"></script>

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
                <div class="menuPoint active">Главная</div>
            </div>
            <div class="clear"></div>
        </div>

        <div id="mobileMenu">
            <div class="mobileMenuPoint" style="text-align: right;">
                <i class="fa fa-times" aria-hidden="true" onclick="closeMobileMenu()"></i>
            </div>
            <div class="mobileMenuPoint active"><span>Главная</span></div>
            <div class="mobileMenuPoint"><a href="/3d-printers/"><span>3D-принтеры</span></a></div>
            <div class="mobileMenuPoint"><a href="/3d-print/"><span>3D-печать</span></a></div>
            <div class="mobileMenuPoint"> <a href="/study/"><span>Обучение</span></a></div>
            <div class="mobileMenuPoint"><a href="/engineering/"><span>Проектирование</span></a></div>
            <div class="mobileMenuPoint"><a href="/iot/"><span>IoT</span></a></div>
            <div class="mobileMenuPoint"><a href="/contacts/"><span>Контакты</span></a></div>
        </div>
    </div>

    <div id="videoContainer" class="text-center" data-vide-bg="mp4: /files/main_video.mp4, webm: /files/main_video.webm, ogv: /files/main_video.ogv, poster: /files/main_video_preview.jpg" data-vide-options="posterType: jpg, loop: true, muted: true, position: 0% 0%">
        <div id="mask"></div>
        <div id="sloganContainer" class="text-center">
            <div class="slogan revealator-slideup revealator-load revealator-delay12">
                <img src="/img/system/logo_small.png" />
                <br /><br /><br />
                <span class="sloganBigFont">smARTech</span>
                <br />
                <span class="sloganSmallFont">возможно многое!</span>
                <br /><br />
                <button class="promoButton" id="topButton" onclick="scrollToInfo()"><i class="fa fa-info-circle" aria-hidden="true"></i>узнать больше</button>
            </div>
        </div>
    </div>

    <div class="section white" id="section">
        <div class="header">
            <br /><br />
            <span class="headerFont">Чем мы занимаемся?</span>
            <br />
        </div>
        <div class="activityBlock white">
            <div class="activityPhoto">
                <img src="/img/system/img5.jpg" />
            </div>
            <div class="activityDescription">
                <div class="header">
                    <span class="activityHeaderFont">3D-принтеры</span>
                </div>
                <div class="activityText">
                    <p>Mauris vel leo ut magna iaculis rutrum eget sit amet dolor. Maecenas id felis consequat, eleifend diam ut, cursus massa. Sed tempor, augue a imperdiet efficitur, dolor ex porta quam, et ullamcorper ligula enim sed lacus. Ut porta ultrices enim, eu sodales mi varius ac. Praesent quis blandit lacus. Suspendisse porta, libero ac fringilla varius, leo est lacinia purus, non fermentum leo ex quis ligula. Nunc eget enim condimentum quam ullamcorper sodales non a lacus. Fusce non nulla in arcu ultricies mollis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean accumsan tincidunt dolor at facilisis. Integer semper justo ac justo rutrum, ac euismod augue posuere.</p>
                </div>
                <div class="header text-right">
                    <a href="/3d-printers/"><button class="activityButton">подробнее&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i></button></a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="activityBlock grey">
            <div class="activityPhoto">
                <img src="/img/system/img4.jpg" />
            </div>
            <div class="activityDescription">
                <div class="header">
                    <span class="activityHeaderFont">3D-печать</span>
                </div>
                <div class="activityText">
                    <p>Aenean in sagittis sem. Ut consequat magna et lorem pulvinar, nec imperdiet elit luctus. Vestibulum at lorem faucibus, malesuada enim laoreet, accumsan nisi. Phasellus tincidunt posuere elit id lacinia. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur turpis lacus, tempor varius mattis finibus, placerat ut leo. Nulla venenatis ut arcu vulputate tristique. Donec vitae ante nibh. Vivamus ultricies, magna vitae imperdiet dictum, lectus ipsum condimentum quam, non vehicula urna libero et augue. Sed non semper leo, ac facilisis libero. In faucibus quis neque quis mollis. Nullam blandit sapien turpis, ut lobortis ipsum sollicitudin nec. Nulla eu lacinia ipsum.</p>
                </div>
                <div class="header text-right">
                    <a href="/3d-print/"><button class="activityButton">подробнее&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i></button></a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="activityBlock white">
            <div class="activityPhoto">
                <img src="/img/system/img6.jpg" />
            </div>
            <div class="activityDescription">
                <div class="header">
                    <span class="activityHeaderFont">Обучение</span>
                </div>
                <div class="activityText">
                    <p>Sed vehicula est augue, a efficitur mauris tempus vel. Maecenas semper, odio at consequat imperdiet, orci justo molestie nibh, et viverra quam sem tempus nibh. Quisque commodo congue quam fermentum ullamcorper. Aenean vulputate mauris et pretium imperdiet. Cras tempus quam non mi blandit, in dictum lorem dignissim. Nullam turpis ex, interdum at ipsum quis, semper rutrum est. Vivamus quis urna odio.</p>
                </div>
            </div>
            <div class="header text-right">
                <a href="/study/"><button class="activityButton">подробнее&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i></button></a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="activityBlock grey">
            <div class="activityPhoto">
                <img src="/img/system/img14.jpg" />
            </div>
            <div class="activityDescription">
                <div class="header">
                    <span class="activityHeaderFont">Проектирование</span>
                </div>
                <div class="activityText">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et arcu bibendum, iaculis lectus ut, ullamcorper erat. Pellentesque elementum interdum purus. Nulla facilisi. Duis a pharetra ipsum. Nam dignissim odio ac velit luctus pulvinar. In non urna elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce et vehicula mi. In vel sollicitudin massa, eu venenatis nisl. In a ex a augue scelerisque faucibus ut sed leo.</p>
                </div>
                <div class="header text-right">
                    <a href="/engineering/"><button class="activityButton">подробнее&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i></button></a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="activityBlock white">
            <div class="activityPhoto">
                <img src="/img/system/iot.png" />
            </div>
            <div class="activityDescription">
                <div class="header">
                    <span class="activityHeaderFont">Internet of Things</span>
                </div>
                <div class="activityText">
                    <p>Nulla auctor lacus a dignissim tincidunt. Vestibulum vitae ornare eros. Fusce posuere odio mi, luctus scelerisque nibh pulvinar sed. Nunc blandit faucibus eros, nec varius neque sodales a. Mauris eget turpis ut dui malesuada feugiat. Duis venenatis vel metus a aliquam. Pellentesque dictum urna leo, lobortis aliquam dolor hendrerit quis. Cras nulla ligula, tristique quis dui in, sodales tristique tellus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam porttitor tortor nibh, quis faucibus purus laoreet ut. Nam id convallis lorem. Praesent tempus justo eget leo convallis convallis. Curabitur eu semper tellus. Integer vestibulum vulputate felis, sed iaculis quam imperdiet et.</p>
                </div>
                <div class="header text-right">
                    <a href="/iot/"><button class="activityButton">подробнее&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i></button></a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="bigSection">
        <div id="sloganContainer" class="text-center">
            <div class="sloganBottom">
                <span class="sloganBottomFont" style="font-size: 4vw">Мы работаем в революционной сфере 3D-печати</span>
                <br />
                <span class="sloganBottomFont">поэтому наш подход к делу всегда иновационный и передовой</span>
                <br /><br />
                <a href="/contatcs/"><button class="promoButton" id="bottomButton"><i class="fa fa-phone" aria-hidden="true"></i>связаться с нами</button></a>
            </div>
        </div>
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