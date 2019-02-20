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
            [['prize_id', 'amount'], 'required'],
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

    /**
     * Получить определённое количество призов для отправки в банк
     * @param int $limit количество отбираемых призов
     * @return array
     */
    public static function getNotSentToBank(int $limit): array
    {
        return static::find()
            ->where([
                'status' => MoneyPrizeStatus::TRANSFER_TO_BANK,
                'is_sent_to_bank' => false
            ])
            ->limit($limit)
            ->all();
    }

    /**
     * Установить атрибут отправки в банк
     * @param bool $status значение статуса
     */
    public function setSentToBank(bool $status): void
    {
        $this->setAttribute('is_sent_to_bank', $status);

        if ($this->save() === false) {
            throw new \RuntimeException("Ошибка при изменении статуса отправки в банк приза ID = {$this->id}");
        }
    }

    /**
     * @param Prizes $prize
     * @throws \Exception
     */
    public static function generateRandom(Prizes $prize): void
    {
        $moneyPrize = new self();
        $moneyPrize->setAttributes([
            'prize_id' => $prize->id,
            'amount' => random_int(Yii::$app->params['moneyPrizeFrom'], Yii::$app->params['moneyPrizeTo'])
        ]);

        if ($moneyPrize->save() === false) {
            throw new \RuntimeException('Ошибка при сохранении денежного приза');
        }

        /* Обновляем лимит оставшихся призов */
        $prize->prizeType->updateLimit($moneyPrize->amount);
    }
}
