$(window).on("load", function () {
    var h = 500;

    $('.catalogueContainer').each(function () {
        var h_block = parseInt($(this).height());
        if(h_block < h) {
            var id = $(this).attr("name");
            $('#goodOverlay' + id).css("display", "none");
        }
    });

    if($("div").is(".goodProperties")) {
        goodResize();
    }
});

$(window).on("resize", function () {
    if($("div").is(".goodProperties")) {
        goodResize();
    }
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

function catalogueMenu(action, id, text) {
    if($("#" + id).attr("class") !== "tdActive") {
        if(action === 1) {
            $("#" + id).css("background-color", "#f5f5f5");
            $("#" + text).css("color", "#fb5c25");
        } else {
            $("#" + id).css("background-color", "#fff");
            $("#" + text).css("color", "#000");
        }
    }
}

function addToBasket(id) {
    $.ajax({
        type: "POST",
        data: {"id": id},
        url: "/scripts/shop/ajaxAddToBasket.php",
        success: function(response) {
            switch(response) {
                case "ok insert":
                    $.notify("Товар был успешно добавлен в корзину.", "success");

                    $("#icon" + id).attr("class", "fa fa-cart-plus");
                    $("#addButton" + id).attr("title", "Увеличить количество товара в корзине");

                    $.ajax({
                        type: "POST",
                        url: "/scripts/shop/ajaxGoodsQuantity.php",
                        success: function (quantity) {
                            $("#basketPoint").html("<i class='fa fa-shopping-cart' aria-hidden='true'></i> (" + quantity + ")");
                            $("#mobileBasketPoint").html("Корзина (" + quantity + ")");
                        }
                    });
                    break;
                case "ok update":
                    $.notify("Количество выбранного товара в корзине было увеличено.", "success");
                    break;
                case "failed":
                    $.notify("При добавлении товара в корзину произошла ошибка. Попробуйте снова.", "error");
                    break;
                case "id":
                    $.notify("Товара с указанным идентификатором не существует.", "error");
                    break;
                default:
                    $.notify(response, "warn");
                    break;
            }
        }
    });
}

function goodResize() {
    if($(window).width() >= 1200) {
        $(".goodProperties").width(parseInt($(".catalogueContent").width() - $('.goodPhoto').width() - 20 - 50));
    } else {
        $(".goodPhoto").css("float", "none");
        $(".goodProperties").css("float", "none");
        $(".goodProperties").css("margin-top", "20px");
        $(".goodProperties").css("width", "100%");
    }
}