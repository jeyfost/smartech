function loadPostText(id) {
    $.ajax({
        type: "POST",
        data: {"id": id},
        url: "/scripts/admin/blog/ajaxLoadText.php",
        success: function (response) {
            CKEDITOR.instances["textInput"].setData(response);
        }
    });
}

function editPost() {
    var name = $("#nameInput").val();
    var url = $("#urlInput").val();
    var description = $("#descriptionInput").val();
    var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
    var formData = new FormData($('#postForm').get(0));
    formData.append("text", text);

    if(name !== '') {
        if(url !== '') {
            if(description !== '') {
                if(text !== '' && text !== '<p><br></p>') {
                    $.ajax({
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        url: "/scripts/admin/blog/ajaxEditPost.php",
                        beforeSend: function () {
                            $.notify("Запись редактируется...", "info");
                        },
                        success: function (response) {
                            switch (response) {
                                case "ok":
                                    $.notify("Запись успешно отредактирована.", "success");

                                    setTimeout(function () {
                                        location.reload();
                                    }, 1500);
                                    break;
                                case "failed":
                                    $.notify("В процессе редактирования записи произошла ошибка. Попробуйте снова.", "error");
                                    break;
                                case "url":
                                    $.notify("Запись с таким URL уже существует.", "error");
                                    break;
                                case "numeric":
                                    $.notify("URL не может состоять из одних цифр.", "error");
                                    break;
                                case "preview":
                                    $.notify("Выбранное вами превью имеет недопустимый формат.", "error");
                                    break;
                                case "preview upload":
                                    $.notify("Во время загрузки превью произошла ошибка. Попробуйте снова.", "error");
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
                    $.notify("Вы не ввели текст.", "error");
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