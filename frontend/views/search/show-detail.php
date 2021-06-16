<?php

use frontend\models\Properties;
use kartik\widgets\FileInput;
use letyii\tinymce\Tinymce;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;


$arrInitialPreviewConfig = [];
$arrInitalPreview = [];
$this->title = 'View Property';
?>
<div class="customer-form form">
    <div class="row">
        <div class="col-md-8" style="padding-right:0px!important;">
            <div class = "user1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('app', 'PROPERTY DETAILS - '.$arrData['title']); ?>
                    <span class="pull-right">Rs. <?php echo $arrData['price'];?></span>
                    </h3>
                    
                </div>
                <div class='panel-body'>

                    <div class = "row">
                        <div class="col-md-6">
                            <div class="col-md-12">
                                
                        
                        <span class="badge bg-success">Bedroom:  <?php echo $arrData['bedroom'];?></span>
                    </div>
                            <div class="col-xs-12">
                                
                        
                        <span class="badge bg-success">Bathroom: <?php echo $arrData['bathroom'];?></span>
                    </div>
                            <div class="col-xs-12">
                                
                        
                        <span class="badge bg-success">Area: <?php echo $arrData['area'];?> Sq Ft</span>
                    </div>
                            <div class="col-xs-12" style="margin-top: 23px;">
                             <p >
                                <span style="color:green;font-size: 20px;">Floor Area : <?php echo $arrData['bedroom'];?></span>
                            </p>
                            <p>
                                <span style="color:green;font-size: 20px;">Description : <?php echo $arrData['bathroom'];?></span>
                            </p><!-- comment -->
                            <p>
                                <span style="color:green;font-size: 20px;">City : <?php echo $arrData['city'];?></span>
                            </p><!-- comment -->
                            <p>
                                <span style="color:green;font-size: 20px;">PRICE : Rs. <?php echo $arrData['price'];?></span>
                            </p><!-- comment -->
                            <p>
                                <span style="color:green;font-size: 20px;">ADDRESS : <?php echo $arrData['address'];?></span>
                            </p>
                        </div>
                        </div>
                        <div class="col-md-6">
                            <?php  
                            if(empty($arrData['image'])):
                                $txtPath = 'res/images/building1.jpeg';
                            else:
                                $txtPath = '/Featured/'.$arrData['id'].'/'.$arrData['image'];
                            endif;
                            
                            echo '<img class="img-responsive image" src= "'.$txtPath.'"  width = "100%" min-height="242px; !important" >';?>

                        </div>
                    </div>

                </div>
            </div>
           

        </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('app', 'Description - '.$arrData['title']); ?>
                    </h3>
                    
                </div>
                <div class='panel-body'>
                    <div style="min-height:230px;">
                    <?php echo $arrData['description']; ?>    
                    </div>
                    </div>
                </div>
                  </div>
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('app', 'Gallery Images'); ?>
                    </h3>
                    
                </div>
                <div class = "panel-body">
                    <div class="wrapper">   
    <div id="slider4" class="text-center">

                    <?php
                    if(empty($arrGalleryImages)):
                        echo 'No Gallery Images Found.';
                    else:
                      
                        foreach($arrGalleryImages as $recImage):
                          $txtPath = '/Gallery/'.$recImage['property_id'].'/'.$recImage['name'];
                        echo '<div class="slide"><img class="img-responsive image" src= "'.$txtPath.'"  width = "100%" style="margin-left:12px;" ></div>';

                        endforeach;
                    endif;
                    ?>
                </div></div>
                </div>
            </div>
        </div>
        <?php if(0):?>
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('app', 'Send Query'); ?>
                    </h3>
                    
                </div>
                <div class = "panel-body">
                    <div>
                        <div class="col-md-4">
                            <?php
                            if($intCustomerType ==2):
                                if(!empty($arrAgentUsers)):
                        $str = '<ul class="side-tabs">';
                        foreach ($arrAgentUsers as $key=>$intUserId):
                            $txtName = frontend\models\Users::find()->andWhere('id = '.$intUserId)->one()->name;
                           $str .= '<li class="list-group-item list-group-item-secondary">';
                            $str .= Html::a($txtName,'');
                            $str .= '</li>';    
                        endforeach;
                        $str .= '</ul>';
                        echo $str;
                    endif;
                            endif;
                            ?>
                        </div>
                        <div class="col-md-8">
                    <div class="commentContainer mt-2 bg-white" id="commentCon_245" style="">
                        <span style="display: none;" id="storeuser"><?php echo $intLoginUserID?></span>
                                    <div id="notes_245" class="addReadMore showlesscontent"> <div class="media"><div class="media-body media-body-width updatecontent">
                                                <?php 
                                                foreach($arrMessage as $recMessage):
                                                    if((($intLoginUserID == $recMessage['user_id']) && $recMessage['ysn_reply'] ==0) || (($intLoginUserID == $recMessage['agent_id']) && $recMessage['ysn_reply'] ==1)):
                                                        echo '<div class="badge media pull-right" style="font-size: xx-small;"><div class="media-body media-body-width"><h5 class="my-0 font-weight-bold" style="font-size: 13px;">'.$txtUsername.'</h5>';
                                                        echo '<span class="commentView">'.$recMessage['message'].'</span></div></div>';
                                                    else:
                                                        echo '<div class=" badge media" style="font-size: xx-small;><div class="media-body media-body-width"><h5 class="my-0 font-weight-bold" style="font-size: 13px;">'.(!empty($recMessage['ysn_reply']) ? $txtOwnerName : $txtUsername).'</h5>';
                                                        echo '<span class="commentView">'.$recMessage['message'].'</span></div></div>';
                                                    endif;
                                                    
                                                   
                                                endforeach;
                                                ?>
							</div><!--media-body-->
						  </div>
                </div>
                        <div class="media mb-0" style="margin-top: 369px;"><div><div class="form-group highlight-addon field-pmsscribblereaction-245-txt_notes">

                                    <div class="row"><div class="col-md-9">
<textarea id="message" class="form-control-custom CommentDescription form-control" name="Message[message]" rows="1" style="width: calc(100% - 20px);" placeholder="Write a comment..."></textarea>
                                    </div>
                                        <div class="col-md-3" style="font-size:12px"><button class="btn btn-primary post"> SEND</button></div>

</div></div></div>
            </div>
                    </div></div></div>
    </div>
            </div>
        </div>
        <?php endif;?>
</div><!doctype html>
</div>

    <style>
        .user {
    position: relative;
    padding-left: 25px;
    padding-right: 25px;
    padding-top: 20px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);
}
.container{
        min-width: -webkit-fill-available !important;
}

.badge{
        width: -webkit-fill-available;
    background-color: chocolate ;
    font-size: x-large;
    margin-top:20px;
}
.commentContainer {
        padding: 10px;
        border-radius: 5px;
        min-height: 422px;
    }
     .media-dev {
        width: max-content;
    }
    .media-body-width{
        width: max-content;
    }
    .wrapper{
    width: 500px; 
    overflow-x:scroll;     
    white-space: nowrap;
}
.slide{
    height: 200px;
    display: inline-block;
    min-width: 500px;
}
    </style>


<?php

$script = 'var addMessage="' . Url::to(['message']) . '";';
$script .= 'var intOwnerId ="' . $intOwnerID . '";';
$script .= 'var intPropertyId ="' . $intPropertyId . '";';
$script .= <<<Js
        $(".post").click(function() {
            var messasge = $("#message").val();
            var intUserId = $("#storeuser").text();
        console.log(message);
       
          $.ajax({
               type: "POST",
               url: addMessage,
               data: 'message=' + message + '&intOwnerId=' + intOwnerId + '&intUserId=' + intUserId + '&intPropertyId=' + intPropertyId,
            }).done(function(data) {
              $('.updatecontent').html('');
               $('.updatecontent').html(data);
           });
        });
Js;
$this->registerJs($script);
?>