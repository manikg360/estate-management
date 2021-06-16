<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\searchModel\PropertiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Properties';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="properties-index">

    <h1><?= Html::encode($this->title).Html::a('Create Properties', ['create'], ['class' => 'btn btn-success pull-right']) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'floor_area',
            'price',
            'image',
            //'bedroom',
            //'bathroom',
            'city',
            //'address',
            //'area',
            //'agent_id',
            //'description:ntext',
            //'nearby:ntext',
            //'dat_created',

            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => '{update}{delete}'
                ],
        ],
    ]); ?>


</div>
