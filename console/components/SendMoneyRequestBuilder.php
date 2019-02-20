<?php

namespace console\components;

use common\models\MoneyPrizes;

/**
 * Class SendMoneyRequestBuilder
 * @package console\components
 */
class SendMoneyRequestBuilder
{
    /**
     * Собираем запрос для апи банка
     * @param MoneyPrizes $prize
     * @return array
     */
    public static function build(MoneyPrizes $prize): array
    {
        // Тут собираем запрос для апи банка (массив или объект)
        return [
            // ....
        ];
    }
}
