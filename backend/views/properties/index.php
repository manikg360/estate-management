<?php

use yii\grid\GridView;

$this->title = Yii::t('app', 'Manage Properties');
$arrParams = Yii::$app->request->queryParams;
$intPageSize = (!empty($arrParams['page']) ? $arrParams['page'] : '');
?>

    <div class="estate-index">
        <?=
       
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'floatHeader' => false,
            'responsive' => true,
            'columns' => [
                [
                 'class' => 'yii\grid\SerialColumn', 
                 'contentOptions' => ['style' => 'vertical-align: middle;'],
                ],
                [
                    'attribute'=>'',
                    'headerOptions' => ['style' => 'width: 5%'],
                    'content'=>function($data){
                        $strString = '';
                        $strString .= '<div class="image">';
                        if (empty($data['blb_icon']) || ($data['blb_icon'] == 'null')):
                            $strString .= '<img src="' . Yii::getAlias('@web') . '/res/images/blankphoto.jpg" width="80%" style="border-radius:50%;margin-bottom: 5%;" />';
                        else:
                            $strString .= '<img src="data:image/png;base64,' .$data['image']. '" width="80%"  />';
                        endif;   
                        return $strString;
                    }
                ],
                [
                    'attribute' => 'title',
                    'headerOptions' => ['style' => 'width: 50%'],
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                ],
                        
                [
                'attribute' => 'floor_area',
                'contentOptions' => ['style' => 'vertical-align: middle;'],
                ],
                
                [
                'attribute'=>'txt_latestprice_version_string',
                'contentOptions' => ['style' => 'vertical-align: middle;'],
                ],
                        
                [
                'attribute' => 'bedroom',
                'contentOptions' => ['style' => 'vertical-align: middle;']
                ],
                [
                'attribute' => 'bathroom',
                'contentOptions' => ['style' => 'vertical-align: middle;']
                ],
                [
                'attribute' => 'city',
                'contentOptions' => ['style' => 'vertical-align: middle;']
                ],
                [
                'attribute' => 'address',
                'contentOptions' => ['style' => 'vertical-align: middle;']
                ],
                 
                [
                    'attribute' => '',
                    'value' => '',
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                    'content' => function ($data) use($IntPageSize) {
                        //if($arrVisibleButtons['update'] == 1  || $arrVisibleButtons['delete'] == 1){
                            $str = '<div class="btn-group">
                                                            <a class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                                                <i class="fa fa-cog"></i>
                                                            </a>
                                                            <ul class="dropdown-menu custom" id="applicatinIndexCog">';
                           //   if($arrVisibleButtons['update'] == 1) {
                                $str .= "<li>" . Html::a('<span class="fa fa-edit" aria-hidden="true"></span>&nbsp;&nbsp;' . Yii::t('app', 'Modify'), Url::toRoute(['update', 'id' => $data['id']])). "</li>";
                           // }
                            if($arrVisibleButtons['delete']) {
                               $str .= "<li>" . Html::a('<span class="fa fa-trash" aria-hidden="true"></span>&nbsp;&nbsp;' . Yii::t('app', 'Delete') , Url::toRoute(['delete', 'id' => $data['id'],'page' => $intPageSize]), ['data-method' => 'POST', 'data-confirm' => Yii::t('app', 'Do you want to delete {attribute}?', ['attribute' => 'this property'])]) . "</li>";
                            }
                            $str .= '</ul></div>';
                            return $str;
                        //}
                    }  
                ],
            ],
        ]);
        ?>
    </div>


<style>
    .btn-sm, .btn-group-sm > .btn {
        padding: 2px 6px;
    }

/*    .dropdown-menu {
        left: -134px;
    }*/
#applicatinIndexCog{
    left: -134px;
}
</style>
