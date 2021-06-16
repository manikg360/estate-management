<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\searchModel\PropertiesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="properties-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'floor_area') ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'bedroom') ?>

    <?php // echo $form->field($model, 'bathroom') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'agent_id') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'nearby') ?>

    <?php // echo $form->field($model, 'dat_created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
