<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_prizes".
 *
 * @property int $id
 * @property int $prize_id Приз
 * @property int $status Текущий статус
 * @property int $item_id Предмет
 *
 * @property ItemPrizeStatus $status0
 * @property Prizes $prize
 * @property RefItems $item
 */
class ItemPrizes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_prizes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prize_id', 'status', 'item_id'], 'required'],
            [['prize_id', 'status', 'item_id'], 'default', 'value' => null],
            [['prize_id', 'status', 'item_id'], 'integer'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => ItemPrizeStatus::className(), 'targetAttribute' => ['status' => 'id']],
            [['prize_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prizes::className(), 'targetAttribute' => ['prize_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefItems::className(), 'targetAttribute' => ['item_id' => 'id']],
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
            'item_id' => 'Предмет',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(ItemPrizeStatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrize()
    {
        return $this->hasOne(Prizes::className(), ['id' => 'prize_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(RefItems::className(), ['id' => 'item_id']);
    }
}
