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
     * Отказ от призы
     */
    public const DENIED = 1;

    /**
     * Сконвертированы в бонусные баллы
     */
    public const CONVERT_TO_BONUS = 2;

    /**
     * Переведено в банк
     */
    public const TRANSFER_TO_BANK = 3;

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

    /**
     * Опции для выпадающего списка
     * @return array
     */
    public static function getSelectOptions(): array
    {
        return [
            self::DENIED => 'Отказаться',
            self::CONVERT_TO_BONUS => 'Конвертировать в бонусы',
            self::TRANSFER_TO_BANK => 'Перевести в банк',
        ];
    }
}
