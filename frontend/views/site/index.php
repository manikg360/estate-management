<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this View */

$this->title = 'My Yii Application';
?>
    <?php
    echo '<img class="img-responsive" src= "res/images/building1.jpeg"  width = "100%" height="100%" >';
            
    ?>

<footer class="footer" style="background-color: #303f9f !important;">
    <div class="container" >
        <?php
        echo $this->render('search-estates');
        ?>
    </div>
</footer>

<style>
    
    .img-responsive, .thumbnail > img, .thumbnail a > img, .carousel-inner > .item > img, .carousel-inner > .item > a > img {
    display: block;
    /* max-width: 100%; */
    height: 600px;
}

.footer {
    height: 130px !important;
    background-color: #f5f5f5;
    border-top: 1px solid #ddd;
    padding-top: 20px;
}
</style>

