<?php

namespace console\components;

/**
 * Class BankClient Клиент апи банка. Тут описываются все методы апи
 * @package console\components
 */
class BankClient
{
    /**
     * Отправить приз в банк
     * @param array $request
     * @return bool
     */
    public function sendMoney(array $request): bool
    {
        // Тут отправляем приз в апи банка через yii2-httpclient или curl
        // в случае успеха устанавливаем возвращаем статус

        return true;
    }
}
