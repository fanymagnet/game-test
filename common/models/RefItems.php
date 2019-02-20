<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ref_items".
 *
 * @property int $id
 * @property string $name Наименование предмета
 *
 * @property ItemPrizes[] $itemPrizes
 */
class RefItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_items';
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
            'name' => 'Наименование предмета',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemPrizes()
    {
        return $this->hasMany(ItemPrizes::className(), ['item_id' => 'id']);
    }
}
