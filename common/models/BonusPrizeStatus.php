<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bonus_prize_status".
 *
 * @property int $id
 * @property string $name Наименование статуса
 *
 * @property BonusPrizes[] $bonusPrizes
 */
class BonusPrizeStatus extends \yii\db\ActiveRecord
{
    /**
     * Отказ от приза
     */
    public const DENIED = 1;

    /**
     * Перевести на счет
     */
    public const TRANSFER_TO_ACCOUNT = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bonus_prize_status';
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
    public function getBonusPrizes()
    {
        return $this->hasMany(BonusPrizes::className(), ['status' => 'id']);
    }

    /**
     * Опции для выпадающего списка
     * @return array
     */
    public static function getSelectOptions(): array
    {
        return [
            self::DENIED => 'Отказаться',
            self::TRANSFER_TO_ACCOUNT => 'Перевести на счет',
        ];
    }
}
