function loadGoodText(id) {
    $.ajax({
        type: "POST",
        data: {"id": id},
        url: "/scripts/admin/shop/ajaxLoadText.php",
        success: function (response) {
            CKEDITOR.instances["textInput"].setData(response);
        }
    });
}

function deleteGoodPhoto(photoID) {
    if(confirm("Вы действительно хотите удалить фотографию?")) {
        $.ajax({
            type: "POST",
            data: {"id": photoID},
            url: "/scripts/admin/shop/ajaxDeletePhoto.php",
            beforeSend: function () {
                $.notify("Фотография удаляется...", "info");
            },
            success: function(response) {
                switch (response) {
                    case "ok":
                        $.notify("Фотография была успшно удалена.", "success");

                        setTimeout(function () {
                            location.reload();
                        }, 700);
                        break;
                    case "failed":
                        $.notify("Во время удаления фотографии произошла ошибка. Попробуйте снова.", "error");
                        break;
                    case "id":
                        $.notify("Фотографии с таким ID не существует.", "error");
                        break;
                    default:
                        $.notify(response, "warn");
                        break;
                }
            }
        });
    }
}

function deleteAllPhotos() {
    if(confirm("Вы действительно хотите удалить все дополнительные фотографии?")) {
        var id = $('#goodSelect').val();

        if(id !== '') {
            $.ajax({
                type: "POST",
                data: {"id": id},
                url: "/scripts/admin/shop/ajaxDeleteAllPhotos.php",
                beforeSend: function () {
                    $.notify("Фотографии удаляются...", "info");
                },
                success: function (response) {
                    switch(response) {
                        case "ok":
                            $.notify("Все дополнительные фотографии были удалены.", "success");

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                            break;
                        case "failed":
                            $.notify("Во время удаления дополнительных фотографий произошла ошибка. Попробуйте снова.", "error");
                            break;
                        case "id":
                            $.notify("Товара с таким ID не существует.", "error");
                            break;
                        default:
                            $.notify(response, "warn");
                            break;
                    }
                }
            });
        } else {
            $.notify("Вы не выбрали товар.", "error");
        }
    }
}

function deleteGood() {
    if(confirm("Вы действительно хотите удалить товар?")) {
        var id = $('#goodSelect').val();

        if(id !== '') {
            $.ajax({
                type: "POST",
                data: {"id": id},
                url: "/scripts/admin/shop/ajaxDeleteGood.php",
                beforeSend: function () {
                    $.notify("Товар удаляется...", "info");
                },
                success: function (response) {
                    switch(response) {
                        case "ok":
                            $.notify("Товар был успешно удалён.", "success");

                            setTimeout(function () {
                                window.location.href = "/admin/shop";
                            }, 2000);
                            break;
                        case "failed":
                            $.notify("Во время удаления товара произошла ошибка. Попробуйте снова.", "error");
                            break;
                        case "id":
                            $.notify("Товара с таким ID не существует.", "error");
                            break;
                        default:
                            $.notify(response, "warn");
                            break;
                    }
                }
            });
        } else {
            $.notify("Вы не выбрали товар.", "error");
        }
    }
}

function editGood() {
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
                            url: "/scripts/admin/shop/ajaxEditGood.php",
                            beforeSend: function() {
                                $.notify("Товар редактируется...", "info")
                            },
                            success: function(response) {
                                switch (response) {
                                    case "ok":
                                        $.notify("Товар успешно отредактирован.", "success");

                                        setTimeout(function() {
                                            location.reload();
                                        }, 1500);
                                        break;
                                    case "failed":
                                        $.notify("В процессе редактирования товара произошла ошибка. Попробуйте снова.", "error");
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
                                        $.notify("Вы выбрали основную фотографию неверного формата.", "error");
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