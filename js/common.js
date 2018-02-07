/**
 * Created by jeyfost on 23.01.2018
 */

$(window).on("load", function () {
    if($('#footer').offset().top < parseInt($(window).height() - $('#footer').height())) {
        $('#footer').offset({top: parseInt($(window).height() - $('#footer').height())});
    }
});

function scrollToTop() {
    $('html, body').animate({scrollTop: 0}, 500);
}

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("scroll").style.display = "block";
    } else {
        document.getElementById("scroll").style.display = "none";
    }
}

function mobileMenu() {
    var c = $('#menuIcon').attr("class");

    if (c === "fa fa-bars hidden") {
        $('#menuIcon').attr("class", "fa fa-bars");
        $('#menuIcon').css("color", "#a01a21");

        if($('#mobileMenu').height() < parseInt($(window).height() - 80)) {
            $('#mobileMenu').height(parseInt($(window).height() - 80));
        }

        $('#mobileMenu').show();
    } else {
        closeMobileMenu();
    }
}

function closeMobileMenu() {
    $('#menuIcon').attr("class", "fa fa-bars hidden");
    $('#menuIcon').css("color", "#fb5c25");

    $('#mobileMenu').hide();
}

function iconColor(id, action) {
    console.log(id);

    if(action === 1) {
        $('#' + id).css("color", "#fb5c25");
    } else {
        $('#' + id).css("color", "#ededed");
    }
}