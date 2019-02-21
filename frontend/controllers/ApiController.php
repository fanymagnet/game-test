<?php

namespace frontend\controllers;

use common\models\Prizes;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
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
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class
        ];

        return $behaviors;
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
            Prizes::changeStatusPrize($prizeType, $prizeId, $status);
        } catch (Throwable $exception) {
            Yii::error("Exception: {$exception->getMessage()} ({$exception->getFile()}:{$exception->getCode()})");
            return ['success' => false];
        }

        return ['success' => true];
    }
}
