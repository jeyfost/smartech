function addGood() {
    var name = $("#nameInput").val();
    var url = $("#urlInput").val();
    var code = $("#codeInput").val();
    var price = $("#priceInput").val();
    var description = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;

    var formData = new FormData($('#goodForm').get(0));
    formData.append("description", description);

    if(name !== "") {
        if(url !== "") {
            if(code !== "") {
                if(price !== "") {
                    if(description !== "" && description !== "<p><br></p>") {
                        $.ajax({
                            type: "POST",
                            data: formData,
                            dataType: "json",
                            processData: false,
                            contentType: false,
                            url: "/scripts/admin/shop/ajaxAddGood.php",
                            beforeSend: function() {
                                $.notify("Товар добавляется...", "info")
                            },
                            success: function(response) {
                                switch (response) {
                                    case "ok":
                                        $.notify("Товар успешно добавлен.", "success");

                                        setTimeout(function() {
                                            location.reload();
                                        }, 1500);
                                        break;
                                    case "failed":
                                        $.notify("В процессе добавления товара произошла ошибка. Попробуйте снова.", "error");
                                        break;
                                    case "url":
                                        $.notify("Введённый вами URL уже существует.", "error");
                                        break;
                                    case "numeric":
                                        $.notify("URL не может состоять из одних цифр.", "error");
                                        break;
                                    case "code":
                                        $.notify("Введённый вами артикул уже существует.", "error");
                                        break;
                                    case "price":
                                        $.notify("Цена должна быть выше нуля.", "error");
                                        break;
                                    case "photo":
                                        $.notify("Вы не выбрали основную фотографию.", "error");
                                        break;
                                    case "photo format":
                                        $.notify("Вы не выбрали основную фотографию.", "error");
                                        break;
                                    case "photo upload":
                                        $.notify("Во время загрузки основной фотографии произошла ошибка. Попробуйте снова.", "error");
                                        break;
                                    case "additional photos":
                                        $.notify("Вы выбрали одну или несколько дополнительных фотографий имеют недопустимый формат.", "error");
                                        break;
                                    case "additional photos upload":
                                        $.notify("Во время загрузки дополнительных фотографий произошла ошибка. Попробуйте снова", "error");
                                        break;
                                    default:
                                        $.notify(response, "warn");
                                        break;
                                }
                            },
                            error: function (jqXHR, exception) {
                                console.log(jqXHR);
                            }
                        });
                    } else {
                        $.notify("Вы не ввели описание товара.", "error")
                    }
                } else {
                    $.notify("Вы не ввели цену товара.", "error")
                }
            } else {
                $.notify("Вы не ввели артикул товара.", "error")
            }
        } else {
            $.notify("Вы не ввели URL товара.", "error")
        }
    } else {
        $.notify("Вы не ввели название товара.", "error")
    }
}