function addCategory() {
    var name = $("#categoryNameInput").val();
    var url = $("#categoryURLInput").val();

    if(name !== "") {
        if(url !== "") {
            $.ajax({
                type: "POST",
                data: {
                    "name": name,
                    "url": url
                },
                url: "/scripts/admin/blog-categories/ajaxAddCategory.php",
                beforeSend: function() {
                    $.notify("Раздел добавляется...", "info");
                },
                success: function (response) {
                    switch(response) {
                        case "ok":
                            $.notify("Раздел был успешно добавлен.", "success");

                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                            break;
                        case "failed":
                            $.notify("В процессе добавления раздела произошла ошибка. Попробуйте снова.", "error");
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