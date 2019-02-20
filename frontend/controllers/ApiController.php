<?php

namespace frontend\controllers;

use common\models\MoneyPrizes;
use common\models\MoneyPrizeStatus;
use common\models\Prizes;
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
            Prizes::generateRandom();
        } catch (Throwable $exception) {
            Yii::error("Exception: {$exception->getMessage()} ({$exception->getFile()}:{$exception->getCode()})");
            return ['success' => false];
        }

        return ['success' => true];
    }
}
