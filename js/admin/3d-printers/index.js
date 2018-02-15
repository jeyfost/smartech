function editGood() {
    var name = $('#nameInput').val();
    var url = $('#urlInput').val();
    var description = $('#descriptionInput').val();
    var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
    var formData = new FormData($('#goodForm').get(0));
    formData.append("text", text);

    if(name !== '') {
        if(url !== '') {
            if(description !== '') {
                if(text !== '' && text !== '<p><br></p>') {
                    $.ajax({
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        url: "/scripts/admin/ajaxEdit.php",
                        beforeSend: function() {
                            $.notify("Информация обновляется...", "info");
                        },
                        success: function (response) {
                            switch(response) {
                                case "ok":
                                    $.notify("Информация успешно обновлена.", "success");

                                    setTimeout(function () {
                                        location.reload();
                                    }, 2000);
                                    break;
                                case "failed":
                                    $.notify("При обновлении информации произошла ошибка. Попробуйте снова.", "error");
                                    break;
                                case "main photo":
                                    $.notify("Основная фотография имеет недопустимый формат.", "error");
                                    break;
                                case "main photo upload":
                                    $.notify("При загрузке основной фотографии произошла ошибка. Попробуйте снова.", "error");
                                    break;
                                case "additional photos":
                                    $.notify("Одна или несколько дополнительных фотографий имеют недопустимый формат.", "error");
                                    break;
                                case "additional photos upload":
                                    $.notify("Не все дополнительные фотографии были загружены. Информация о принтере не обновлена. Попробуйте снова.", "error");
                                    break;
                                case "url":
                                    $.notify("Введённая URL уже присвоена одному из товаров или услуг.", "error");
                                    break;
                                case "numeric":
                                    $.notify("URL не может состоять из одних цифр.", "error");
                                    break;
                                default:
                                    $.notify(response, "warn");
                                    break;
                            }
                        }
                    });
                } else {
                    $.notify("Вы не ввели описание.", "error");
                }
            } else {
                $.notify("Вы не ввели краткое описание.", "error");
            }
        } else {
            $.notify("Вы не ввели URL.", "error");
        }
    } else {
        $.notify("Вы не ввели название.", "error");
    }
}

function deleteAllPhotos() {
    if(confirm("Вы действительно хотите удалить все дополнительные фотографии?")) {
        var id = $('#goodSelect').val();

        if(id !== '') {
            $.ajax({
                type: "POST",
                data: {"id": id},
                url: "/scripts/admin/ajaxDeleteAllPhotos.php",
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
                            $.notify("Принтера с таким ID не существует.", "error");
                            break;
                        default:
                            $.notify(response, "warn");
                            break;
                    }
                }
            });
        } else {
            $.notify("Вы не выбрали принтер.", "error");
        }
    }
}

function deleteGood() {
    if(confirm("Вы действительно хотите удалить принтер?")) {
        var id = $('#goodSelect').val();

        if(id !== '') {
            $.ajax({
                type: "POST",
                data: {"id": id},
                url: "/scripts/admin/ajaxDeleteGood.php",
                beforeSend: function () {
                    $.notify("Принтер удаляется...", "info");
                },
                success: function (response) {
                    switch(response) {
                        case "ok":
                            $.notify("Принтер был успешно удалён.", "success");

                            setTimeout(function () {
                                window.location.href = "/admin/3d-printers/";
                            }, 2000);
                            break;
                        case "failed":
                            $.notify("Во время удаления принтера произошла ошибка. Попробуйте снова.", "error");
                            break;
                        case "id":
                            $.notify("Принтера с таким ID не существует.", "error");
                            break;
                        default:
                            $.notify(response, "warn");
                            break;
                    }
                }
            });
        } else {
            $.notify("Вы не выбрали принтер.", "error");
        }
    }
}