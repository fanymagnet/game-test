<?php

namespace frontend\controllers;

use common\models\BonusPrizes;
use common\models\ItemPrizes;
use common\models\MoneyPrizes;
use common\models\Prizes;
use common\models\PrizesTypes;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;
use Throwable;
use Yii;

/**
 * Class ApiController
 * @package frontend\controllers
 */
class ApiController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function init(): void
    {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $this->enableCsrfValidation = false;
    }

    /**
     * Получить случайный приз
     * @return array
     */
    public function actionGetRandomPrize(): array
    {
        try {
            Prizes::generateRandomPrize(Yii::$app->user->identity->id);
        } catch (Throwable $exception) {
            Yii::error("Exception: {$exception->getMessage()} ({$exception->getFile()}:{$exception->getCode()})");
            return ['success' => false];
        }

        return ['success' => true];
    }

    /**
     * Изменение статуса приза
     * @return array
     */
    public function actionChangePrizeStatus(): array
    {
        $prizeType = Yii::$app->request->post('dataPrizeType');
        $prizeId = Yii::$app->request->post('dataPrizeId');
        $status = Yii::$app->request->post('status');

        try {
            switch ($prizeType) {
                case PrizesTypes::MONEY:
                    MoneyPrizes::processStatus($prizeId, $status);
                    break;

                case PrizesTypes::ITEM:
                    ItemPrizes::processStatus($prizeId, $status);
                    break;

                case PrizesTypes::BONUS:
                    BonusPrizes::processStatus($prizeId, $status);
                    break;

                default: throw new \RuntimeException('Неизвестный тип приза!');
            }
        } catch (Throwable $exception) {
            Yii::error("Exception: {$exception->getMessage()} ({$exception->getFile()}:{$exception->getCode()})");
            return ['success' => false];
        }

        return ['success' => true];
    }
}
