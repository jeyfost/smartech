function editCategory() {
    var category = $('#categorySelect').val();
    var subcategory = $("#subcategorySelect").val();
    var categoryName = $("#categoryNameInput").val();
    var subcategoryName = $("#subcategoryNameInput").val();
    var categoryURL = $("#categoryURLInput").val();
    var subcategoryURL = $("#subcategoryURLInput").val();

    if(category !== "") {
        if(categoryName !== "" || !$("input").is("#categoryNameInput")) {
            if(subcategory !== "") {
                if(subcategoryName !== "") {
                    $.ajax({
                        type: "POST",
                        data: {
                            "subcategoryID": subcategory,
                            "subcategoryName": subcategoryName,
                            "subcategoryURL": subcategoryURL
                        },
                        url: "/scripts/admin/categories/ajaxEditSubcategory.php",
                        beforeSend: function () {
                            $.notify("Подраздел редактируется...", "info");
                        },
                        success: function (response) {
                            switch(response) {
                                case "ok":
                                    $.notify("Данные подраздела были изменены.", "success");

                                    setTimeout(function () {
                                        location.reload();
                                    }, 1500);
                                    break;
                                case "failed":
                                    $.notify("Во время редактирования подраздела произошла ошибка. Попробуйте снова.", "error");
                                    break;
                                case "duplicate":
                                    $.notify("Подраздел с таким названием уже существует в выбранном разделе.", "error");
                                    break;
                                case "empty url":
                                    $.notify("Вы не ввели URL подраздела.", "error");
                                    break;
                                case "numeric":
                                    $.notify("URL подраздела не может состоять из одних цифр.", "error");
                                    break;
                                case "url duplicate":
                                    $.notify("Подраздел с таким URL уже существует.", "error");
                                    break;
                                default:
                                    $.notify(response, "warn");
                                    break;
                            }
                        }
                    });
                } else {
                    $.notify("Вы не ввели название подраздела.", "error");
                }
            } else {
                $.ajax({
                    type: "POST",
                    data: {
                        "categoryID": category,
                        "categoryName": categoryName,
                        "categoryURL": categoryURL
                    },
                    url: "/scripts/admin/categories/ajaxEditCategory.php",
                    beforeSend: function () {
                        $.notify("Раздел редактируется...", "info");
                    },
                    success: function (response) {
                        switch(response) {
                            case "ok":
                                $.notify("Данные раздела были изменены.", "success");

                                setTimeout(function () {
                                    location.reload();
                                }, 1500);
                                break;
                            case "failed":
                                $.notify("Во время редактирования раздела произошла ошибка. Попробуйте снова.", "error");
                                break;
                            case "duplicate":
                                $.notify("Раздел с таким названием уже существует.", "error");
                                break;
                            case "empty url":
                                $.notify("Вы не ввели URL раздела.", "error");
                                break;
                            case "numeric":
                                $.notify("URL раздела не может состоять из одних цифр.", "error");
                                break;
                            case "url duplicate":
                                $.notify("Раздел с таким URL уже существует.", "error");
                                break;
                            default:
                                $.notify(response, "warn");
                                break;
                        }
                    }
                });
            }
        } else {
            $.notify("Вы не ввели название раздела.", "error");
        }
    } else {
        $.notify("Вы не выбрали раздел для редактирования.", "error");
    }
}