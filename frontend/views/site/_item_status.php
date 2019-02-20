<?php

/* @var $this yii\web\View */
/* @var $itemPrize \common\models\ItemPrizes */

use yii\helpers\Html;
use common\models\ItemPrizeStatus;

?>

<?php if ($itemPrize->status === null): ?>
    <div><?= Html::dropDownList('item-status-select', null, ItemPrizeStatus::getSelectOptions(), ['class' => 'select-prize-status', 'prompt' => '...', 'data-prize-type' => $itemPrize->prize->type, 'data-prize-id' => $itemPrize->id, 'style' => ['width' => '100%']]) ?></div>
<?php else: ?>
    <div><?= $itemPrize->prizeStatus->name ?></div>
<?php endif ?>