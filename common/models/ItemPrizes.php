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
 * @property ItemPrizeStatus $prizeStatus
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
            [['prize_id', 'item_id'], 'required'],
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
    public function getPrizeStatus()
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

    /**
     * Создать случайный приз физический предмет
     * @param Prizes $prize
     */
    public static function generateRandom(Prizes $prize): void
    {
        $randomItem = RefItems::getRandomItem();

        $itemPrizes = new self();
        $itemPrizes->setAttributes([
            'prize_id' => $prize->id,
            'item_id' => $randomItem->id
        ]);

        if ($itemPrizes->save() === false) {
            throw new \RuntimeException('Ошибка при сохранении приза "физ. предмет"');
        }

        /* Обновляем лимит оставшихся призов */
        $prize->prizeType->updateLimit(1);
    }

    /**
     * Обработка изменения статуса приза
     * @param int $prizeId
     * @param int $status
     */
    public static function processStatus(int $prizeId, int $status): void
    {
        $itemPrize = self::findOne(['id' => $prizeId]);

        if ($itemPrize === null) {
            throw new \RuntimeException('Приз не найден!');
        }

        switch ($status) {
            case ItemPrizeStatus::DENIED:
                $itemPrize->setStatus(ItemPrizeStatus::DENIED);
                break;

            case ItemPrizeStatus::MAILED:
                $itemPrize->setStatus(ItemPrizeStatus::MAILED);
                break;

            default: throw new \RuntimeException('Неизвестный статус!');
        }
    }

    /**
     * Установить статус призу
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->setAttribute('status', $status);

        if ($this->save() === false) {
            throw new \RuntimeException('Ошибка при изменении приза!');
        }
    }
}
