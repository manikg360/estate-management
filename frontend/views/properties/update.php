<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Properties */

$this->title = 'Update Properties: ' . $model->title;
//$this->params['breadcrumbs'][] = ['label' => 'Properties', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="properties-update">

    <h3><?= Html::encode($this->title) ?></h3><hr>

    <?= $this->render('_form', [
        'model' => $model,
        'attachmentObj' => $attachmentObj,
        'txtFilePath' => $txtFilePath,
         'attachmentModel' => $attachmentModel,
    ]) ?>

</div>
