<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "prizes".
 *
 * @property int $id
 * @property int $user_id Пользователь
 * @property int $type Текущий статус
 * @property string $created_at Дата выигрыша
 *
 * @property BonusPrizes[] $bonusPrizes
 * @property ItemPrizes[] $itemPrizes
 * @property MoneyPrizes[] $moneyPrizes
 * @property PrizesTypes $type0
 * @property User $user
 */
class Prizes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prizes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'required'],
            [['user_id', 'type'], 'default', 'value' => null],
            [['user_id', 'type'], 'integer'],
            [['created_at'], 'safe'],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => PrizesTypes::className(), 'targetAttribute' => ['type' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'type' => 'Текущий статус',
            'created_at' => 'Дата выигрыша',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBonusPrizes()
    {
        return $this->hasMany(BonusPrizes::className(), ['prize_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemPrizes()
    {
        return $this->hasMany(ItemPrizes::className(), ['prize_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMoneyPrizes()
    {
        return $this->hasMany(MoneyPrizes::className(), ['prize_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(PrizesTypes::className(), ['id' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
