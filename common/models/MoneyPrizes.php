<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "money_prizes".
 *
 * @property int $id
 * @property int $prize_id Приз
 * @property int $status Текущий статус
 * @property double $amount Размер приза
 * @property bool $is_sent_to_bank Приз отправлен в банк
 *
 * @property MoneyPrizeStatus $status0
 * @property Prizes $prize
 */
class MoneyPrizes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'money_prizes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prize_id', 'status', 'amount'], 'required'],
            [['prize_id', 'status'], 'default', 'value' => null],
            [['prize_id', 'status'], 'integer'],
            [['amount'], 'number'],
            [['is_sent_to_bank'], 'boolean'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => MoneyPrizeStatus::className(), 'targetAttribute' => ['status' => 'id']],
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
            'amount' => 'Размер приза',
            'is_sent_to_bank' => 'Приз отправлен в банк',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(MoneyPrizeStatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrize()
    {
        return $this->hasOne(Prizes::className(), ['id' => 'prize_id']);
    }
}
