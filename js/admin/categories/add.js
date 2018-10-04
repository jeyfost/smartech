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
                url: "/scripts/admin/categories/ajaxAddCategory.php",
                beforeSend: function() {
                    $.notify("Раздел добавляетя...", "info");
                },
                success: function (response) {
                    switch (response) {
                        case "ok":
                            $.notify("Раздел был успешно добавлен.", "success");

                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                            break;
                        case "failed":
                            $.notify("В процессе добавления раздела произошла ошибка. Попробуйте снова.", "error");
                            break;
                        case "numeric":
                            $.notify("URL не может состоять из одних цифр.", "error");
                            break;
                        case "url":
                            $.notify("Раздел с таким URL уже существует.", "error");
                            break;
                        case "name":
                            $.notify("Раздел с таким названием уже существует.", "error");
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

function addSubcategory() {
    var categoryID = $("#categorySelect").val();
    var name = $("#subcategoryNameInput").val();
    var url = $("#subcategoryURLInput").val();

    if(name !== "") {
        if(url !== "") {
            $.ajax({
                type: "POST",
                data: {
                    "categoryID": categoryID,
                    "name": name,
                    "url": url
                },
                url: "/scripts/admin/categories/ajaxAddSubcategory.php",
                beforeSend: function() {
                    $.notify("Раздел добавляетя...", "info");
                },
                success: function (response) {
                    switch (response) {
                        case "ok":
                            $.notify("Подраздел был успешно добавлен.", "success");

                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                            break;
                        case "failed":
                            $.notify("В процессе добавления подраздела произошла ошибка. Попробуйте снова.", "error");
                            break;
                        case "numeric":
                            $.notify("URL не может состоять из одних цифр.", "error");
                            break;
                        case "url":
                            $.notify("Подраздел с таким URL уже существует в выбранном разделе.", "error");
                            break;
                        case "name":
                            $.notify("Подраздел с таким названием уже существует в выбранном разделе.", "error");
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