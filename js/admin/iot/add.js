function addGood() {
    var name = $('#nameInput').val();
    var photo = $('#previewInput').val();
    var url = $('#urlInput').val();
    var description = $('#descriptionInput').val();
    var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
    var formData = new FormData($('#goodForm').get(0));
    formData.append("text", text);

    if(name !== '') {
        if(photo !== '') {
            if(url !== '') {
                if(description !== '') {
                    if(text !== '' && text !== '<p><br></p>') {
                        $.ajax({
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: "json",
                            url: "/scripts/admin/iot/ajaxAdd.php",
                            beforeSend: function () {
                                $.notify("Изделие добавляется...", "info");
                            },
                            success: function (response) {
                                switch(response) {
                                    case "ok":
                                        $.notify("Добавление прошло успешно.", "success");

                                        setTimeout(function () {
                                            location.reload();
                                        }, 2000);
                                        break;
                                    case "failed":
                                        $.notify("При добавлении произошла ошибка. Попробуйте снова.", "error");
                                        break;
                                    case "photo":
                                        $.notify("Выбранная фотография имеет недопустимый формат.", "error");
                                        break;
                                    case "additional photos":
                                        $.notify("Одна или несколько дополнительных фотографий имеют недопустимый формат.", "error");
                                        break;
                                    case "url":
                                        $.notify("Введённый URL соответствует другому товару или услуге.", "error");
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
            $.notify("Вы не выбрали фотографию.", "error");
        }
    } else {
        $.notify("Вы не ввели название.", "error");
    }
}