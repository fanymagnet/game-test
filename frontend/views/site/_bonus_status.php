<?php

/* @var $this yii\web\View */
/* @var $bonusPrize \common\models\ItemPrizes */

use yii\helpers\Html;
use common\models\BonusPrizeStatus;

?>

<?php if ($bonusPrize->status === null): ?>
    <div><?= Html::dropDownList('bonus-status-select', null, BonusPrizeStatus::getSelectOptions(), ['class' => 'select-prize-status', 'prompt' => '...', 'data-prize-type' => $bonusPrize->prize->type, 'data-prize-id' => $bonusPrize->id, 'style' => ['width' => '100%']]) ?></div>
<?php else: ?>
    <div><?= $bonusPrize->prizeStatus->name ?></div>
<?php endif ?>