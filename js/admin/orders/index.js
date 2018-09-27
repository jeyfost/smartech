$(window).on("load", function () {
    basketRowResize();
});

$(window).on("resize", function () {
    basketRowResize();
});

function basketRowResize() {
    if($("div").is(".basketRow")) {
        $(".basketDescription").width(parseInt($(".basketRow").width() - $(".basketPhoto").width() - 20));
    }
}

function acceptOrder(id) {
    $.ajax({
        type: "POST",
        data: {"id": id},
        url: "/scripts/admin/orders/ajaxAcceptOrder.php",
        success: function (response) {
            switch (response) {
                case "ok":
                    $.notify("Заказ был принят.", "success");

                    setTimeout(function () {
                        location.href = "/admin/orders";
                    }, 1500);
                    break;
                case "failed":
                    $.notify("В процессе принятия заказа произошла ошибка. Попробуйте снова.", "error");
                    break;
                case "accepted":
                    $.notify("Заказ с таким идентификатором был принят ранее.", "error");
                    break;
                case "id":
                    $.notify("Заказа с таким идентификатором не существует.", "error");
                    break;
                default:
                    $.notify(response, "warn");
                    break;
            }
        }
    });
}