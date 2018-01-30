$(window).on("load", function () {
    $('input[id!="messageButton"]').width(parseInt($('#contactForm').width() - 15));
    $('textarea').width(parseInt($('#contactForm').width() - 15));

    $('form').submit(function () {
        return false;
    });
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