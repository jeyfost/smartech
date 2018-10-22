/**
 * Created by jeyfost on 23.01.2018
 */

$(window).on("load", function () {
    $('#section').offset({top: parseInt($('#videoContainer').offset().top + $('#videoContainer').height() + 100)});
    $('#contacts').offset({top: parseInt($('#section').offset().top + $('#section').height() + 100)});
    $('.bigSection').offset({top: parseInt($('#contacts').offset().top + $('#contacts').height() + 100)});
    $('.bigSection').height(parseInt($('.bigSection').width() / 3.184));
    $('.sloganBottom').offset({top: parseInt(($('.bigSection').height() - $('.sloganBottom').height()) / 2 + $('.bigSection').offset().top)});
    $('#footer').offset({top: parseInt($('.bigSection').offset().top + $('.bigSection').height())});

    $('input[id!="messageButton"]').width(parseInt($('#contactForm').width() - 15));
    $('textarea').width(parseInt($('#contactForm').width() - 15));

    $('form').submit(function () {
        return false;
    });
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

$(window).on("resize", function () {
    $('input[id!="messageButton"]').width(parseInt($('#contactForm').width() - 15));
    $('textarea').width(parseInt($('#contactForm').width() - 15));
});

$(document).on("ready", function () {
    $(window).on("keydown", function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
});

function textAreaHeight(textarea) {
    if (!textarea._tester) {
        var ta = textarea.cloneNode();
        ta.style.position = 'absolute';
        ta.style.zIndex = 2000000;
        ta.style.visibility = 'hidden';
        ta.style.height = '1px';
        ta.id = '';
        ta.name = '';
        textarea.parentNode.appendChild(ta);
        textarea._tester = ta;
        textarea._offset = ta.clientHeight - 1;
    }
    if (textarea._timer) clearTimeout(textarea._timer);
    textarea._timer = setTimeout(function () {
        textarea._tester.style.width = textarea.clientWidth + 'px';
        textarea._tester.value = textarea.value;
        textarea.style.height = (textarea._tester.scrollHeight - textarea._offset) + 'px';
        textarea._timer = false;
    }, 1);
}

function sendEmail() {
    var name = $('#nameInput').val();
    var phone = $('#phoneInput').val();
    var email = $('#emailInput').val();
    var text = $('#messageInput').val();
    var formData = new FormData($('#contactForm').get(0));

    if(name !== '') {
        if(email !== '') {
            $.ajax({
                type: "POST",
                data: {"email": email},
                url: "/scripts/ajaxEmailValidation.php",
                success: function (response) {
                    if(response === "ok") {
                        if(phone !== '') {
                            if(text !== '') {
                                $.ajax({
                                    type: "POST",
                                    data: formData,
                                    dataType: "json",
                                    processData: false,
                                    contentType: false,
                                    url: "/scripts/ajaxSendMessage.php",
                                    success: function (result) {
                                        switch (result) {
                                            case "ok":
                                                $.notify("Ваше сообщение отправлено. Мы скоро вам ответим.", "success");

                                                $('#nameInput').val("");
                                                $('#emailInput').val("");
                                                $('#phoneInput').val("");
                                                $('#messageInput').val("");

                                                textAreaHeight(document.getElementById("messageInput"));
                                                break;
                                            case "captcha":
                                                $.notify("Вы не прошли тест на робота. Попробуйте снова.", "error");
                                                break;
                                            case "failed":
                                                $.notify("При отправке сообщения произошла ошибка. Попробуйте снова.", "error");
                                                break;
                                            default:
                                                $.notify(result, "warn");
                                                break;
                                        }
                                    }
                                });
                            } else {
                                $.notify("Вы не ввели текст сообщения.", "error");
                            }
                        } else {
                            $.notify("Вы ввели свой номер телефона.", "error");
                        }
                    } else {
                        $.notify("Вы ввели email недопустимого формата.", "error");
                    }
                }
            });
        } else {
            $.notify("Вы не ввели свой email.", "error");
        }
    } else {
        $.notify("Вы не ввели своё имя.", "error");
    }
}

function scrollToInfo(e) {
    $('html, body').animate({
        scrollTop: parseInt($('#section').offset().top - 20)
    }, 300);

    e.preventDefault();
    return false;
}