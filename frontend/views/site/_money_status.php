<?php

/* @var $this yii\web\View */
/* @var $moneyPrize \common\models\MoneyPrizes */

use yii\helpers\Html;
use common\models\MoneyPrizeStatus;

?>

<?php if ($moneyPrize->status === null): ?>
    <div><?= Html::dropDownList('money-status-select', null, MoneyPrizeStatus::getSelectOptions(), ['class' => 'select-prize-status', 'prompt' => '...', 'data-prize-type' => $moneyPrize->prize->type, 'data-prize-id' => $moneyPrize->id, 'style' => ['width' => '100%']]) ?></div>
<?php else: ?>
    <div><?= $moneyPrize->prizeStatus->name ?></div>
<?php endif ?>
