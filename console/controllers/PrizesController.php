<?php

namespace console\controllers;

use common\models\MoneyPrizes;
use console\components\BankClient;
use console\components\SendMoneyRequestBuilder;
use yii\console\Controller;
use Yii;

/**
 * Class PrizesController Обработка призов
 * @package console\controllers
 */
class PrizesController extends Controller
{
    /**
     * @var int Количество отправляемых денежных призов
     */
    private $sendMoneyPrizeLimit;

    public function init(): void
    {
        parent::init();
        $this->sendMoneyPrizeLimit = Yii::$app->params['sendMoneyPrizeLimit'];
    }

    /**
     * Начать отправку денежных призов в банк
     */
    public function actionSendMoneyPrizes(): void
    {
        $bankClient = new BankClient();
        $prizes = MoneyPrizes::getNotSentToBank($this->sendMoneyPrizeLimit);

        foreach ($prizes as $prize) {
            /* @var $prize MoneyPrizes*/
            $request = SendMoneyRequestBuilder::build($prize);
            $status = $bankClient->sendMoney($request);

            if ($status === true) {
                $prize->setSentToBank(true);
            } else {
                Yii::error("Ошибка при отправке приза ID = {$prize->id} в банк.");
            }
        }
    }
}
