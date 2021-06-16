<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
$this->title = 'REAL STATE';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode('') ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'REAL STATE',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
            
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
   //     ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    
    if(!empty(Yii::$app->user->id)):
        $intLoginUserId = Yii::$app->user->id;
        $arrCustomerType = frontend\models\Users::find()
                                ->select('role_id')
                                ->andWhere('id = '.$intLoginUserId)
                                ->asArray()
                                ->one();
      
        if($arrCustomerType['role_id']<=2):
            $menuItems[] = ['label' => 'Properties', 'url' => ['/properties']];
        endif;
    endif;
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup'],'options' => ['style' => 'color:green']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $item = [];
        $arrData = ['label' => 'Profile', 'url' => ['/site/profile']];
        array_push($item,$arrData);
        $arrData = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout',
                ['class' => 'btn btn-primary btn-link logout','style'=>'color: #262626;margin-left: 5px;']
            )
            . Html::endForm()
            . '</li>';
        array_push($item,$arrData);
        $menuItems[] = [
            'label' => Yii::$app->user->identity->username,
            'url' => ['#'],
            'items' => $item
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<!--<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<style>
    .navbar-inverse {
    background-color: #2761ca;
    
    /* border-color: #080808; */
}
.navbar-inverse .navbar-nav > li > a {
    color: #ffffff;
}
.navbar-inverse .navbar-brand {
    color: #ffffff;
}
@media (min-width: 1200px){
.container{
        min-width: -webkit-fill-available !important;
}
}
</style>