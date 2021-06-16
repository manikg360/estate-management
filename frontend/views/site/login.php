<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
        <div class="col m6 offset-m3 signup">
            <div class="user">
    <h1 style = "text-align: center;color: #3f51b5 !important;">Login</h1>

    <hr>
    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true,'placeholder' => 'Email','class'=>'form-control signup1'])->label(false); ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password','class'=>'form-control signup1'])->label(false); ?>
                
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'style'=>'margin-top:30px;','name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
            </div>
</div>
<style>
    input:focus{
        outline: 0 !important;
    }
    .signup{
    margin-left: 20%;
    width:100%;
}
.user {
    position: relative;
    margin-right: 30% !important;
    padding-left: 25px;
    padding-right: 25px;
    padding-top: 20px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);
}
.signup1{
    
    border-top: 0 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    border-left: 0 !important;
    border-right: 0 !important;
    margin-top: 52px !important;

}
.checkbox{
    position: relative;
    display: block;
    margin-top: 50px;
    margin-bottom: 10px;
}

    
</style>

