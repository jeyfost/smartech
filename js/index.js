/**
 * Created by jeyfost on 23.01.2018
 */

$(window).on("load", function () {
    $('#section').offset({top: parseInt($('#videoContainer').offset().top + $('#videoContainer').height() + 100)});
    $('.bigSection').offset({top: parseInt($('#section').offset().top + $('#section').height() + 100)});
    $('.bigSection').height(parseInt($('.bigSection').width() / 3.184));
    $('.sloganBottom').offset({top: parseInt(($('.bigSection').height() - $('.sloganBottom').height()) / 2 + $('.bigSection').offset().top)});
    $('#footer').offset({top: parseInt($('.bigSection').offset().top + $('.bigSection').height() + 100)});
});

$(window).on("scroll", function () {
    if($(window).scrollTop() > 10) {
        $('#menu').height(70);
        $('#logo img').css("margin-top", "10px");
        $('#mobileMenu').css("top", "70px");
        $('.menuPoint').css("line-height", "70px");
    } else {
        $('#menu').height(80);
        $('#logo img').css("margin-top", "15px");
        $('#mobileMenu').css("top", "80px");
        $('.menuPoint').css("line-height", "80px");
    }
});

function scrollToInfo(e) {
    $('html, body').animate({
        scrollTop: parseInt($('#section').offset().top - 20)
    }, 300);

    e.preventDefault();
    return false;
}