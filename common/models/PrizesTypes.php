<?php

namespace common\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "prizes_types".
 *
 * @property int $id
 * @property string $name Наименование приза
 * @property int $limit Оставшиеся ресурсы
 *
 * @property Prizes[] $prizes
 */
class PrizesTypes extends \yii\db\ActiveRecord
{
    /**
     * Денежный приз
     */
    public const MONEY = 1;

    /**
     * Случайный предмет
     */
    public const ITEM = 2;

    /**
     * Бонусы
     */
    public const BONUS = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prizes_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['limit'], 'default', 'value' => null],
            [['limit'], 'integer'],
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
            'name' => 'Наименование приза',
            'limit' => 'Оставшиеся ресурсы',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrizes()
    {
        return $this->hasMany(Prizes::className(), ['type' => 'id']);
    }

    /**
     * Получить случайный тип приза
     * @return PrizesTypes|null
     */
    public static function getRandomType(): ?self
    {
        return self::find()
            ->where([
                'or',
                ['is', 'limit', null],
                ['>', 'limit', 0]
            ])
            ->orderBy(new Expression('random()'))
            ->limit(1)
            ->one();
    }

    /**
     * Обновление лимита на тип приза
     * @param int $amount
     */
    public function updateLimit(int $amount): void
    {
        $this->setAttribute('limit', $this->limit - $amount);

        if ($this->save() === false) {
            throw new \RuntimeException('Ошибка при обновлении лимита!');
        }
    }
}
