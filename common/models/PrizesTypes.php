<?php

namespace common\models;

use Yii;

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
            [['name', 'limit'], 'required'],
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
}
