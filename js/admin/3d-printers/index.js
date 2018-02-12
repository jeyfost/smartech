function deletePhoto(photoID) {
    if(confirm("Вы действительно хотите удалить фотографию?")) {
        $.ajax({
            type: "POST",
            data: {"id": photoID},
            url: "/scripts/admin/3d-printers/ajaxDeletePhoto.php",
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

function loadText(id) {
    $.ajax({
        type: "POST",
        data: {"id": id},
        url: "/scripts/admin/3d-printers/ajaxLoadText.php",
        success: function (response) {
            CKEDITOR.instances["textInput"].setData(response);
        }
    });
}

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
                        url: "/scripts/admin/3d-printers/ajaxEdit.php",
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
                                default:
                                    $.notify(response, "warn");
                                    break;
                            }
                        },
                        error: function(xhr,status,error){
                            console.log(status);
                            console.log(error);
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
                url: "/scripts/admin/3d-printers/ajaxDeleteAllPhotos.php",
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
                url: "/scripts/admin/3d-printers/ajaxDeleteGood.php",
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