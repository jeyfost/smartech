function edit() {
    var oldLogin = $('#oldLoginInput').val();
    var oldPassword = $('#oldPasswordInput').val();
    var newLogin = $('#newLoginInput').val();
    var newPassword = $('#newPasswordInput').val();

    if(oldLogin !== '') {
        if(oldPassword !== '') {
            if(newLogin !== '' || newPassword !== '') {
                $.ajax({
                    type: "POST",
                    data: {
                        "oldLogin": oldLogin,
                        "oldPassword": oldPassword,
                        "newLogin": newLogin,
                        "newPassword": newPassword
                    },
                    url: "/scripts/admin/security/ajaxAdmin.php",
                    beforeSend: function () {
                        $.notify("Данные авторизации отправлены...", "info");
                    },
                    success: function (response) {
                        switch (response) {
                            case "ok":
                                $.notify("Данные авторизации были изменены.", "success");
                                break;
                            case "failed":
                                $.notify("Во время изменения данных авторизации произошла ошибка. Попробуйте снова.", "error");
                                break;
                            case "incorrect":
                                $.notify("Старый логин или старый пароль введён неверно.", "error");
                                break;
                            case "duplicate":
                                $.notify("Новые данные авторизации совпадают со старыми.", "error");
                                break;
                            default:
                                $.notify(response, "info");
                                break;
                        }
                    }
                });
            } else {
                $.notify("Вы не ввели новые авторизационные данные.", "error");
            }
        } else {
            $.notify("Вы не ввели старый пароль.", "error");
        }
    } else {
        $.notify("Вы не ввели старый логин.", "error");
    }
}