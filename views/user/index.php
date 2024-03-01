<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            if(Yii::$app->user->identity->role_id == '3...') {
                echo Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ;
            }
        ?>
    </p> 

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'fio',
            'phone',
            'email:email',
            'login',
            'status',
            [
                'attribute'=> 'status',
                //смена статуса вмдна только админу
                'visible' => (Yii::$app->user->identity->role_id == '1' || Yii::$app->user->identity->role_id == '2')?true:false,
                'format'=> 'raw',
                'value'=> function ($data) {
                    $html = Html::beginForm(Url::to(['update', 'id' => $data->id]));
                    $html .= Html::activeDropDownList($data, 'status_id', [
                        2 => 'Подтверждено',
                        3 => 'Отклонено',
                    ],
                    [
                        'prompt' => [
                            'text'=> 'new',
                            'options' => [
                                'value'=> '1',
                                'style'=> 'display: none',
                            ]
                        ]
                    ]);
                    $html .= Html::submitButton('Принять', ['class' => 'btn btn-link']);
                    $html .= Html::endForm();
                    return $html;
                }
            ],
        ],
    ]); ?>


</div>
