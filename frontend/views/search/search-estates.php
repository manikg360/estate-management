<?php

use frontend\models\Properties;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
$form = ActiveForm::begin(['method' => 'get','action' => 'index.php?r=search']);
$arrParams = Yii::$app->request->queryParams;
$model = new Properties();
$model->load($arrParams);
$model->scenario = 'search';
?>
<div>
        <div class="row" style="margin-top: 23px;">
            <div class="col-md-2" style="padding-right:0px!important;margin-left: 100px;">
                <?=  $form->field($model,'title', [])->textInput(['maxlength' => '20%','placeholder' => 'Name of Property'])->label(false); ?>
            </div>
            <div class="col-md-2" style="padding-right:0px!important;">
                <?= $form->field($model, 'city',[])->textInput(['maxlength' => true,'placeholder' => 'City'])->label(false); ?>
            </div>
            <div class="col-md-2" style="padding-right:0px!important;">
                <?= $form->field($model, 'bedroom',[])->textInput(['placeholder' => 'Bedrooms'])->label(false); ?>
            </div>
            <div class="col-md-2" style="padding-right:0px!important;">
                <?= $form->field($model, 'price',[])->textInput(['placeholder' => 'Max Price'])->label(false); ?>
            </div>
            <div class="col-md-2" style="padding-right:0px!important;">
                <?= Html::submitButton('SEARCH',['class' => 'btn btn-primary']); ?>
            </div>
        </div>
    </div>
    
<?php
ActiveForm::end();
?>