$(document).ready(function () {
    /* Получаем случайный приз для пользователя по начатию */
    $("#get-random-prize").on('click', function () {
        $.ajax({
            url: '/api/get-random-prize',
            type: 'POST',
            beforeSend: function() {
                $("#get-random-prize").attr("disabled", "disabled");
            },
            success: function (result) {
                if(result.success === true) {
                    $.pjax.reload({container: '#grid-user-prizes', async: false});
                } else {
                    // отображаем ошибку
                }
            },
            error: function() {
                // отображаем ошибку
            },
            complete: function() {
                $("#get-random-prize").removeAttr("disabled");
            },
        });
    });
});