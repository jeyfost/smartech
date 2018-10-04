function editCategory() {
    var id = $("#categorySelect").val();
    var name = $("#categoryNameInput").val();
    var url = $("#categoryURLInput").val();

    if(name !== "") {
        if(url !== "") {
            $.ajax({
                type: "POST",
                data: {
                    "id": id,
                    "name": name,
                    "url": url
                },
                url: "/scripts/admin/blog-categories/ajaxEditCategory.php",
                beforeSend: function() {
                    $.notify("Раздел редактируется...", "info");
                },
                success: function (response) {
                    switch(response) {
                        case "ok":
                            $.notify("Раздел был успешно отредактирован.", "success");

                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                            break;
                        case "failed":
                            $.notify("В процессе редактирования раздела произошла ошибка. Попробуйте снова.", "error");
                            break;
                        case "name":
                            $.notify("Раздел с таким названием уже существует.", "error");
                            break;
                        case "url":
                            $.notify("Раздел с таким URL уже существует.", "error");
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
            $.notify("Вы не ввели URL раздела.", "error");
        }
    } else {
        $.notify("Вы не ввели название раздела.", "error");
    }
}

function deleteCategory() {
    if(confirm("Вы действительно хотите удалить раздел? Все записи, относящиеся к разделу, также будут удалены.")) {
        var id = $("#categorySelect").val();

        $.ajax({
            type: "POST",
            data: {"id": id},
            url: "/scripts/admin/blog-categories/ajaxDeleteCategory.php",
            beforeSend: function () {
                $.notify("Раздел удаляется...", "info");
            },
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Раздел успешно удалён.", "success");

                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        break;
                    case "failed":
                        $.notify("В проессе удаления раздела произошла ошибка. Попробуйте снова.", "error");
                        break;
                    case "id":
                        $.notify("Раздела с таким идентификатором не существует.", "error");
                        break;
                    default:
                        $.notify(response, "warn");
                        break;
                }
            }
        });
    }
}