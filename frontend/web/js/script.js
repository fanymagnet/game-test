
"use strict";

$(document).ready(function () {
    /**
     * Выполнить запрос к АПИ
     * @param functionName
     * @param functionData
     * @param method
     * @param callBackSuccess
     * @param callBackError
     */
    function apiRequest(functionName, functionData, method, callBackSuccess, callBackError) {
        $.ajax({
            url: '/api/' + functionName,
            data: functionData,
            method: method,
            // beforeSend: function (data) {
            //      data.setRequestHeader("Authorization", "Bearer qwerty");
            // },
            success: function (data) {
                if (data.success === true) {
                    callBackSuccess.call(data);
                } else {
                    callBackError.call(data);
                }
            },
            error: function (data) {
                callBackError.call(data);
            },
            timeout: 10000
        });
    }

    /**
     * Событие в случае успешного получения случайного приза
     */
    function onGetRandomPrizeSuccess() {
        $.pjax.reload({container: '#grid-user-prizes', async: false});
        $("#get-random-prize").removeAttr("disabled");
    }

    /**
     * Событие в случае ошибки при получении случаного приза
     */
    function onGetRandomPrizeError() {
        $("#get-random-prize").removeAttr("disabled");
        // display error
    }

    /**
     * Получаем случайный приз для пользователя по начатию
     */
    $("#get-random-prize").on('click', function () {
        $("#get-random-prize").attr("disabled", "disabled");
        apiRequest('get-random-prize', null, 'GET', onGetRandomPrizeSuccess, onGetRandomPrizeError);
    });

    /**
     * Событие при успешном изменении статуса приза
     */
    function onChangePrizeStatusSuccess() {
        $.pjax.reload({container: '#grid-user-prizes', async: false});
    }

    /**
     * Событие при ошибке при изменении статуса приза
     */
    function onChangePrizeStatusError() {
        // display error
    }

    /**
     * При изменении статуса приза
     */
    $(".select-prize-status").on('change', function (e) {
        let selectElement = $(e.target);
        let dataPrizeType = selectElement.attr('data-prize-type');
        let dataPrizeId = selectElement.attr('data-prize-id');
        let status = $('option:selected', selectElement).val();
        let data = {
            dataPrizeType: dataPrizeType,
            dataPrizeId: dataPrizeId,
            status: status
        };
        apiRequest('change-prize-status', data, 'POST', onChangePrizeStatusSuccess, onChangePrizeStatusError);
    });
});