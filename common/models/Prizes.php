<?php

namespace common\models;

use Yii;
use Throwable;
use yii\db\Exception;

/**
 * This is the model class for table "prizes".
 *
 * @property int $id
 * @property int $user_id Пользователь
 * @property int $type Текущий статус
 * @property string $created_at Дата выигрыша
 *
 * @property BonusPrizes $bonusPrize
 * @property ItemPrizes $itemPrize
 * @property MoneyPrizes $moneyPrize
 * @property PrizesTypes $prizeType
 * @property User $user
 * @property string $information
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
            'type' => 'Тип приза',
            'created_at' => 'Дата выигрыша',
            'information' => 'Информация'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBonusPrize()
    {
        return $this->hasOne(BonusPrizes::className(), ['prize_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemPrize()
    {
        return $this->hasOne(ItemPrizes::className(), ['prize_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMoneyPrize()
    {
        return $this->hasOne(MoneyPrizes::className(), ['prize_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrizeType()
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

    /**
     * Создать приз для пользователя
     * @param int $userId
     * @param int $type
     * @param int|null $status
     * @return Prizes
     */
    public static function createPrize(int $userId, int $type, ?int $status = null): self
    {
        $prize = new self();
        $prize->setAttributes([
            'user_id' => $userId,
            'type' => $type,
            'status' => $status
        ]);

        if ($prize->save() === false) {
            throw new \RuntimeException('Ошибка при сохранении приза!');
        }

        return $prize;
    }

    /**
     * Генерация случайного приза для текущего пользователя
     * @throws Throwable
     */
    public static function generateRandom(): void
    {
        /* Получаем случайный тип приза */
        $randomType = PrizesTypes::getRandomType();

        if ($randomType === null) {
            throw new \RuntimeException('Нет призов!');
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $prize = self::createPrize(Yii::$app->user->identity->id, $randomType->id);

            switch ($prize->type) {
                case PrizesTypes::MONEY:
                    MoneyPrizes::generateRandom($prize);
                    break;

                case PrizesTypes::ITEM:
                    ItemPrizes::generateRandom($prize);
                    break;

                case PrizesTypes::BONUS:
                    BonusPrizes::generateRandom($prize);
                    break;
            }

            $transaction->commit();
        } catch (Throwable $exception) {
            $transaction->rollBack();
            throw $exception;
        }
    }

    /**
     * Получить информацию о призе
     * @return string
     * @throws Exception
     */
    public function getInformation(): string
    {
        switch ($this->type) {
            case PrizesTypes::MONEY:
                return "Вы выиграли: {$this->moneyPrize->amount}$";

            case PrizesTypes::ITEM:
                return "Вы выиграли: {$this->itemPrize->item->name}";
                break;

            case PrizesTypes::BONUS:
                return "Вы выиграли: {$this->bonusPrize->amount}B";

            default: throw new Exception('Неизвестный тип приза!');
        }
    }
}
