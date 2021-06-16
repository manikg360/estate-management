<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Properties */

$this->title = 'Create Properties';
?>
<div class="properties-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'attachmentObj' => $attachmentObj,
        'txtFilePath' => $txtFilePath,
    ]) ?>

</div>
