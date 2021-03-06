<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_prize_status".
 *
 * @property int $id
 * @property string $name Наименование статуса
 *
 * @property ItemPrizes[] $itemPrizes
 */
class ItemPrizeStatus extends \yii\db\ActiveRecord
{
    /**
     * Статус отказ
     */
    public const DENIED = 1;

    /**
     * Статус отправлено по почте
     */
    public const MAILED = 2;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_prize_status';
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
    public function getItemPrizes()
    {
        return $this->hasMany(ItemPrizes::className(), ['status' => 'id']);
    }

    /**
     * Опции для выпадающего списка
     * @return array
     */
    public static function getSelectOptions(): array
    {
        return [
            self::DENIED => 'Отказаться',
            self::MAILED => 'Отправить по почте',
        ];
    }
}
