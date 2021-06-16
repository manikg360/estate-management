<?php

use frontend\models\Properties;
use kartik\widgets\FileInput;
use letyii\tinymce\Tinymce;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Properties */
/* @var $form ActiveForm */
//\yii\bootstrap\BootstrapAsset::register($this);
//AppAsset::register($this);
//\yii\bootstrap\BootstrapPluginAsset::register($this);
 $arrTemplate = [
    'template' => ' <div class="row">
            <div class="col-md-2">{label}</div>
            <div class="col-md-10">{input}{error}</div>
        </div>'
];
$arrInnerTemplate = [
    'template' => ' <div class="row">
            <div class="col-md-3">{label}</div>
            <div class="col-md-9">{input}{error}</div>
        </div>'
];
$form = ActiveForm::begin(
    [
    ]
);
$arrInitialPreviewConfig = [];
$arrInitalPreview = [];
$this->title = 'Create Properties';
?>
<div class="customer-form form">
    <div class="row">
        <div class="col-md-7" style="padding-right:0px!important;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('app', 'Basic Info'); ?></h3>
                </div>
                <div class='panel-body'>

                    <?=  $form->field($model,'title', $arrTemplate)->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'floor_area',$arrTemplate)->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'price',$arrTemplate)->textInput() ?>

                    <?= $form->field($model, 'bedroom',$arrTemplate)->textInput() ?>

                    <?= $form->field($model, 'bathroom',$arrTemplate)->textInput() ?>

                    <?= $form->field($model, 'city',$arrTemplate)->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'address',$arrTemplate)->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'area',$arrTemplate)->textInput() ?>

                </div>
            </div>
           
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('app', 'Other Info'); ?></h3>
                </div>
                <div class='panel-body'>

                    <?= 
                    $form->field($model,'description',[])
                        ->widget(Tinymce::className(),[])
                        ->textArea();
                    ?>
                    <?= 
                    $form->field($model,'nearby',[])
                        ->widget(Tinymce::className(),[])
                        ->textArea();
                    ?>

                </div>
            </div>

        </div>
         <div class="col-md-5" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('app', 'Featured Image'); ?></h3>
                </div>
                <div class='panel-body'>
                    <?php
                    $txtInitialPreviews = '';
                    $arrInitalPreviews = [];
                    $arrInitialPreviewConfigs = [];
                
                if(!empty($model->image)):
                    $txtInitialPreviews = '/Featured/'.$model->id.'/'.$model->image;
              
                    array_push($arrInitalPreviews, $txtInitialPreviews);
                      //echo '<pre>';print_R($arrInitalPreviews);exit;
                    $arrPreviewConfig = ['caption' => $model['image'], 'key' => $model['id']];
                    array_push($arrInitialPreviewConfigs, $arrPreviewConfig);
                else:
                    $arrInitialPreviewConfigs = [];
                    $arrInitalPreviews = [];
                endif;
              
                    echo $form->field($model, 'image')->widget(FileInput::classname(), [
              'name' => 'attachments[23]',
              'options' => [
                'multiple' => false,
                'accept' => 'image/*', 
              ],
              'pluginOptions' => [
              'uploadUrl' => Url::to(['/site/file-upload']),
               // 'deleteUrl' => Url::to(['/product/delete-attachment']),
                'initialPreview' => [$txtInitialPreviews],
                'initialPreviewAsData' => true,
               'initialPreviewConfig' => [['caption' => $model['image'], 'key' => $model['id']]],
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'overwriteInitial' => true,
                'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
              //  'allowedFileTypes' =>  ['image'],
                'dropZoneEnabled' => true,
               // 'dropZoneEnabled'=> false,
                'showBrowse' => true,        
                'browseOnZoneClick' => true,
                'dropZoneClickTitle'=>'',
                'maxFileCount' => 250,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="fa fa-camera"></i>',
                'browseLabel' =>  ' Add image' 
              ],
            ]);
                    ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('app', 'Gallery Images'); ?></h3>
                </div>
                <div class='panel-body'>
                    <?php
                   // echo '<pre>';print_R($attachmentModel);exit;
                        if (!empty($attachmentModel)) :

              foreach ($attachmentModel as $recAttachmentModel) :
                           
                $txtInitialPreview = '/Gallery/'.$model->id.'/'.$recAttachmentModel->name;
                array_push($arrInitalPreview, $txtInitialPreview);
                $arrPreviewConfig = ['caption' => $recAttachmentModel['name'], 'key' => $recAttachmentModel['id']];
                array_push($arrInitialPreviewConfig, $arrPreviewConfig);
              endforeach;
            endif;
          //  echo '<pre>';print_R($arrInitalPreview);exit;
            echo $form->field($attachmentObj, 'name')->widget(FileInput::classname(), [
              'name' => 'attachment[23]',
              'options' => [
                'multiple' => true,
                'accept' => 'image/*', 
              ],
              'pluginOptions' => [
            //  'uploadUrl' => Url::to(['/site/file-upload']),
                'deleteUrl' => Url::to(['/properties','flag' => 'delete-gallery']),
                'initialPreview' => $arrInitalPreview,
                'initialPreviewAsData' => true,
                'initialPreviewConfig' => $arrInitialPreviewConfig,
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'overwriteInitial' => false,
                'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
              //  'allowedFileTypes' =>  ['image'],
                'dropZoneEnabled' => true,
               // 'dropZoneEnabled'=> false,
                'showBrowse' => true,        
                'browseOnZoneClick' => true,
                'dropZoneClickTitle'=>'',
                'maxFileCount' => 250,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="fa fa-camera"></i>',
                'browseLabel' =>  ' Add image' 
              ],
            ]);
                    ?>
                </div>
            </div>
         </div>

    </div>
    <hr />

    <div class="form-group">
        <?php
        echo Html::submitButton('Save',['class' => 'btn btn-primary']);
        echo Html::a('Close','index.php?r=properties',['class' => 'btn btn-primary','style'=>'margin-left:5px;']);
        ?>
    </div>
    <?php $form = ActiveForm::end(); ?>

</div>
