<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bonus_prizes".
 *
 * @property int $id
 * @property int $prize_id Приз
 * @property int $status Текущий статус
 * @property double $amount Размер бонусов
 *
 * @property BonusPrizeStatus $prizeStatus
 * @property Prizes $prize
 */
class BonusPrizes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bonus_prizes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prize_id', 'amount'], 'required'],
            [['prize_id', 'status'], 'default', 'value' => null],
            [['prize_id', 'status'], 'integer'],
            [['amount'], 'number'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => BonusPrizeStatus::className(), 'targetAttribute' => ['status' => 'id']],
            [['prize_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prizes::className(), 'targetAttribute' => ['prize_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prize_id' => 'Приз',
            'status' => 'Текущий статус',
            'amount' => 'Размер бонусов',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrizeStatus()
    {
        return $this->hasOne(BonusPrizeStatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrize()
    {
        return $this->hasOne(Prizes::className(), ['id' => 'prize_id']);
    }

    /**
     * Создание случайного приза бонусные баллы
     * @param Prizes $prize
     * @throws \Exception
     */
    public static function generateRandom(Prizes $prize): void
    {
        $bonusPrize = new self();
        $bonusPrize->setAttributes([
            'prize_id' => $prize->id,
            'amount' => random_int(Yii::$app->params['bonusPrizeFrom'], Yii::$app->params['bonusPrizeTo'])
        ]);

        if ($bonusPrize->save() === false) {
            throw new \RuntimeException('Ошибка при сохранении приза бонусные баллы');
        }
    }
}
