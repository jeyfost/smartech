$(window).on("load", function () {
    if($("div").is(".basketRow")) {
        $(".basketDescription").width(parseInt($(".basketRow").width() - $(".basketPhoto").width() - 20 - 90));
    }
});

function deleteGood(id) {
    if(confirm("Вы действительно хотите удалить этот товар из корзины?")) {
        $.ajax({
            type: "POST",
            data: {"id": id},
            url: "/scripts/basket/ajaxDeleteGood.php",
            success: function(response) {
                switch (response) {
                    case "ok":
                        $.notify("Товар был успешно удалён.", "success");

                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                        break;
                    case "failed":
                        $.notify("Во время удаления товара произошла ошибка. Попробуйте снова.", "error");
                        break;
                    case "id":
                        $.notify("Товара с указанным идентификатором не найдено в вашей корзине.", "error");
                        break;
                    default:
                        $.notify(response, "warn")
                        break;
                }
            }
        });
    }
}

function clearBasket() {
    if(confirm("Вы действительно хотите очистить корзину?")) {
        $.ajax({
            type: "POST",
            url: "/scripts/basket/ajaxClearBasket.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Коризна была очищена.", "success");

                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                        break;
                    case "failed":
                        $.notify("Во время очистки корзины произошла ошибка. Попробуйте снова.", "error");
                        break;
                    case "empty":
                        $.notify("В вашей корзине нет товаров.", "error");
                        break;
                    default:
                        $.notify(response, "warn");
                        break;
                }
            }
        });
    }
}

function sendOrder() {
    var name = $("#nameInput").val();
    var phone = $("#phoneInput").val();
    var email = $("#emailInput").val();

    var inst = $('[data-remodal-id=modal]').remodal();

    if(name !== "") {
        if(email !== "") {
            if(phone !== "") {
                $.ajax({
                    type: "POST",
                    data: {"email": email},
                    url: "/scripts/ajaxEmailValidation.php",
                    success: function (validity) {
                        if(validity === "ok") {
                            $.ajax({
                                type: "POST",
                                data: {
                                    "email": email,
                                    "phone": phone,
                                    "name": name
                                },
                                url: "/scripts/basket/ajaxSendOrder.php",
                                success: function (response) {
                                    switch (response) {
                                        case "ok":
                                            $.notify("Заказ был успешно отправлен.", "success");
                                            inst.close();

                                            setTimeout(function () {
                                                location.reload();
                                            }, 1500);
                                            break;
                                        case "failed":
                                            $.notify("Во время отправки заказа произошла ошибка. Попробуйте снова.", "error");
                                            break;
                                        default:
                                            $.notify(response, "warn");
                                            break;
                                    }
                                }
                            });
                        } else {
                            $.notify("Вы указали email неверного формата.", "error");
                        }
                    }
                });
            } else {
                $.notify("Вы не указали ваш номер телефона.", "error");
            }
        } else {
            $.notify("Вы не указали ваш email.", "error");
        }
    } else {
        $.notify("Вы не указали ваше имя.", "error");
    }
}

function changeGoodQuantity(id) {
    var quantity = $("#quantityInput" + id).val();

    if(quantity !== "") {
        $.ajax({
            type: "POST",
            data: {
                "id": id,
                "quantity": quantity
            },
            url: "/scripts/basket/ajaxChangeGoodQuantity.php",
            success: function(response) {
                $("#totalPrice").html(" " + response + "руб.");
            }
        });
    }
}