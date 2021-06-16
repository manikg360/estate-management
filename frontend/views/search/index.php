
<?php
use yii\helpers\Html;

?>
<div class="search" style="background-color: #303f9f !important;">
<div class="container" >
        <?php
        echo $this->render('search-estates');
        ?>
    </div>
</div>


<div class="search-apartment" style="margin-top:15px;">
    <?php
    foreach($arrData as $key => $recData):
        if($key%3 == 0):
            if($key!=0):
                echo '</div>';
            endif;
            echo '<div class="row">';
        endif;
    ?>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4><b>
                        <?php echo Html::a($recData['title'],'index.php?r=search/show-detail&id='.$recData['id']);?>
                    </b></h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <p>
                                <span style="color:green;">BEDROOMS</span> : <?php echo $recData['bedroom'];?>
                            </p>
                            <p>
                                <span style="color:green;">BATHROOMS</span> : <?php echo $recData['bathroom'];?>
                            </p><!-- comment -->
                            <p>
                                <span style="color:green;">City</span> : <?php echo $recData['city'];?>
                            </p><!-- comment -->
                            <p>
                                <span style="color:green;">PRICE</span> : Rs. <?php echo $recData['price'];?>
                            </p><!-- comment -->
                            <p>
                                <span style="color:green;">ADDRESS</span> : <?php echo $recData['address'];?>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <?php  
                            if(empty($recData['image'])):
                                $txtPath = 'res/images/building1.jpeg';
                            else:
                                $txtPath = '/Featured/'.$recData['id'].'/'.$recData['image'];
                            endif;
                            
                            echo '<img class="img-responsive image" src= "'.$txtPath.'"  width = "100%" height="212px; !important" >';?>
                        </div>
                    </div>
                    
            </div>
         </div>
        
       </div>
    <?php
    endforeach;
    ?>
</div>
</div>
<style>
    .search {
    height: 130px !important;
    background-color: #f5f5f5;
    border-top: 1px solid #ddd;
    padding-top: 20px;
}
.image{
    height:212px !important;
}
</style>