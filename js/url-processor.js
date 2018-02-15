$(window).on("load", function () {
    var h = 500;

    $('.catalogueContainer').each(function () {
        var h_block = parseInt($(this).height());
        if(h_block < h) {
            var id = $(this).attr("name");
            $('#goodOverlay' + id).css("display", "none");
        }
    });
});

function pageBlock(action, block, text) {
    if(action === 1) {
        document.getElementById(block).style.backgroundColor = "#fb5c25";
        document.getElementById(text).style.color = "#fff";
    } else {
        document.getElementById(block).style.backgroundColor = "transparent";
        document.getElementById(text).style.color = "#fb5c25";
    }
}

function expand(id) {
    var h = 500;

    $('.catalogueContainer').each(function () {
        var h_block = parseInt($(this).height());

        if(h_block > parseInt(h - 1)) {
            $(this).css("z-index", "1");
            $(this).css("overflow-y", "hidden");
            $(this).css("max-height", h + "px");
            $(this).css("height", h + "px");
            var cID = $(this).attr("name");
            $('#goodOverlay' + cID).css("display", "inline-block");
        }
    });

    var diff = parseInt(parseInt($('#catalogueDescription' + id).offset().top + $('#catalogueDescription' + id).height() + $('#catalogueButtonContainer' + id).height()) - parseInt($('#catalogueContainer' + id).offset().top + $('#catalogueContainer' + id).height()));

    $('#catalogueContainer' + id).css("z-index", "99");
    $('#catalogueContainer' + id).css("overflow-y", "visible");
    $('#catalogueContainer' + id).css("max-height", "none");
    $('#goodOverlay' + id).css("display", "none");

    $('#catalogueContainer' + id).height(parseInt($('#catalogueContainer' + id).height() + diff));
}

function send(id) {
    var inst = $('[data-remodal-id=modal]').remodal();

    var name = $('#nameInput').val();
    var email = $('#emailInput').val();
    var phone = $('#phoneInput').val();
    var text = $('#textInput').val();
    var formData = new FormData($('#modalForm').get(0));
    formData.append("id", id);

    if(name !== '') {
        if(email !== '') {
            if(phone !== '') {
                if(text !== '') {
                    $.ajax({
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        url: "/scripts/ajaxSendOrder.php",
                        beforeSend: function () {
                            $.notify("Письмо отправляется. После завершения отправки окно закроется автоматически.", "info");
                        },
                        success: function (response) {
                            switch(response) {
                                case "ok":
                                    $.notify("Спасибо! Ваше письмо было отправлено. Мы скоро с Вами свяжемся.", "success");
                                    inst.close();
                                    break;
                                case "failed":
                                    $.notify("Во время отправки письма произошла ошибка. Попробуйте снова.", "error");
                                    break;
                                case "file":
                                    $.notify("Во время загрузки файла произошла ошибка. Попробуйте снова.", "error");
                                    break;
                                case "email":
                                    $.notify("Вы ввели email недопустимого формата.", "error");
                                    break;
                                case "captcha":
                                    $.notify("Вы не прошли проверку на робота.", "error");
                                    break;
                                default:
                                    $.notify(response, "warn");
                                    break;
                            }
                        }
                    });
                } else {
                    $.notify("Вы не ввели текст сообщения.", "error");
                }
            } else {
                $.notify("Вы не ввели свой номер телефона.", "error");
            }
        } else {
            $.notify("Вы не ввели свой email.", "error");
        }
    } else {
        $.notify("Вы не ввели своё имя.", "error");
    }
}