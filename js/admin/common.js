$(window).on("load", function () {
    if($('*').is($('#leftMenu'))) {
        if($('#leftMenu').height() < parseInt($(window).height() - $('#topLine').height())) {
            $('#leftMenu').height(parseInt($(window).height() - $('#topLine').height()));
        }
    }

    if($('*').is($('#content'))) {
        $('#content').width(parseInt($(window).width() - $('#leftMenu').width() - 130));
    }
});

$(window).on("resize", function () {
    if($('*').is($('#leftMenu'))) {
        if($('#leftMenu').height() < parseInt($(window).height() - $('#topLine').height())) {
            $('#leftMenu').height(parseInt($(window).height() - $('#topLine').height()));
        }
    }

    if($('*').is($('#content'))) {
        $('#content').width(parseInt($(window).width() - $('#leftMenu').width() - 130));
    }
});

function buttonHover(id, action) {
    if(action === 1) {
        document.getElementById(id).style.backgroundColor = "#fb5c25";
        document.getElementById(id).style.color = "#fff";
    } else {
        document.getElementById(id).style.backgroundColor = "#dedede";
        document.getElementById(id).style.color = "#4c4c4c";
    }
}

function buttonHoverRed(id, action) {
    if(action === 1) {
        document.getElementById(id).style.backgroundColor = "#d33434";
        document.getElementById(id).style.color = "#fff";
    } else {
        document.getElementById(id).style.backgroundColor = "#dedede";
        document.getElementById(id).style.color = "#4c4c4c";
    }
}

function exit() {
    $.ajax({
        type: "POST",
        url: "/scripts/admin/ajaxExit.php",
        success: function () {
            window.location.href = "../";
        }
    });
}

function textAreaHeight(textarea) {
    if (!textarea._tester) {
        var ta = textarea.cloneNode();
        ta.style.position = 'absolute';
        ta.style.zIndex = 2000000;
        ta.style.visibility = 'hidden';
        ta.style.height = '1px';
        ta.id = '';
        ta.name = '';
        textarea.parentNode.appendChild(ta);
        textarea._tester = ta;
        textarea._offset = ta.clientHeight - 1;
    }
    if (textarea._timer) clearTimeout(textarea._timer);
    textarea._timer = setTimeout(function () {
        textarea._tester.style.width = textarea.clientWidth + 'px';
        textarea._tester.value = textarea.value;
        textarea.style.height = (textarea._tester.scrollHeight - textarea._offset) + 'px';
        textarea._timer = false;
    }, 1);
}

function loadText(id) {
    $.ajax({
        type: "POST",
        data: {"id": id},
        url: "/scripts/admin/ajaxLoadText.php",
        success: function (response) {
            CKEDITOR.instances["textInput"].setData(response);
        }
    });
}

function deletePhoto(photoID) {
    if(confirm("Вы действительно хотите удалить фотографию?")) {
        $.ajax({
            type: "POST",
            data: {"id": photoID},
            url: "/scripts/admin/ajaxDeletePhoto.php",
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