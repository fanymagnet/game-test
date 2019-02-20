<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "money_prize_status".
 *
 * @property int $id
 * @property string $name Наименование статуса
 *
 * @property MoneyPrizes[] $moneyPrizes
 */
class MoneyPrizeStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'money_prize_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование статуса',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMoneyPrizes()
    {
        return $this->hasMany(MoneyPrizes::className(), ['status' => 'id']);
    }
}
