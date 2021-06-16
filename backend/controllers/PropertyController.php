<?php

namespace backend\controllers;

class PropertyController extends \yii\web\Controller
{
    public function actionIndex()
    {echo 'eg';exit;
        $searchModel = new \backend\models\searchModel\PropertiesSearch();
        $dataprovider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataprovider,
        ]);
    }
    
    public function actionCreate()
    {
        return $this->render('_form');
    }
    
    public function actionUpdate($id)
    {
        return $this->render('_form');
    }

}
