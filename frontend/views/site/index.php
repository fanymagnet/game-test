<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $prizesDataProvider \yii\data\ActiveDataProvider */

$this->title = 'Розыгрыш призов!';

?>
<div class="site-index">

    <div class="jumbotron">
        <p>
            <button class="btn btn-lg btn-success" id="get-random-prize">Получить приз</button>
        </p>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
                <?php Pjax::begin(['id' => 'grid-user-prizes']) ?>
                <h2>Мои призы (на вашем счету: <?= Yii::$app->user->identity->bonus ?> бал.)</h2>
                <?= GridView::widget([
                    'dataProvider' => $prizesDataProvider,
                    'columns' => [
                        ['class' => \yii\grid\SerialColumn::class],
                        [
                            'attribute' => 'prizeType.name'
                        ],
                        [
                            'attribute' => 'information'
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' => ['date', 'format' => 'php:d.m.Y H:i:s']
                        ]
                    ],
                    'tableOptions' => [
                        'class' => 'table'
                    ]
                ]) ?>
                <?php Pjax::end() ?>
            </div>
        </div>
    </div>
</div>