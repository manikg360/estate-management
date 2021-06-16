<?php

namespace frontend\controllers;

use frontend\models\Properties;
use frontend\models\PropertyImageGalleries;
use frontend\models\searchModel\PropertiesSearch;
use frontend\models\Users;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * PropertiesController implements the CRUD actions for Properties model.
 */
class PropertiesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action){
        $intLoginUserId = Yii::$app->user->id;
        $arrCustomerType = Users::find()
                                ->select('role_id')
                                ->andWhere('id = '.$intLoginUserId)
                                ->asArray()
                                ->one();
      
        if($arrCustomerType['role_id'] == 3):
            throw new ForbiddenHttpException();
        endif;
        return parent::beforeAction($action);
    }

    /**
     * Lists all Properties models.
     * @return mixed
     */
    public function actionIndex()
    {
        $arrParams = Yii::$app->request->queryParams;
        $arrPost = Yii::$app->request->post();
      
        if(!empty($arrParams['flag']) &&  ($arrParams['flag'] == 'delete-gallery')):
           
            $this->deleteGalleryImage($arrPost['key']);
            return $this->redirect(Yii::$app->request->referrer);
        endif;
        $searchModel = new PropertiesSearch();
        list($dataProvider,$arrData) = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Properties model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Properties model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Properties();
        $attachmentObj = new PropertyImageGalleries();
        $arrPost = Yii::$app->request->post();

        if ($model->load($arrPost)) {
            
            $txtHostName = $_SERVER['DOCUMENT_ROOT'];
           
            
            if(isset($_FILES['Properties']['name']['image']) && !empty($_FILES['Properties']['name']['image'])):
                $model->image = $_FILES['Properties']['name']['image'];
                $id = $model->getNextId('properties','id');
                //Save Featured Image
                 $txtBaseFilePath = '/Featured/'.$id.'/';
                $baseImage = (file_get_contents($_FILES['Properties']['tmp_name']['image']));
                FileHelper::createDirectory($txtHostName.$txtBaseFilePath,$mode = 0777);
            file_put_contents($txtHostName.$txtBaseFilePath.$model->image,$baseImage);
            endif;
         //   echo '<pre>';print_R($model);exit;
            //Save property model
            $model->id = $model->getNextId('properties','id');
            if(empty(Yii::$app->user->id)):
                $model->agent_id = 1;
            else:
                $model->agent_id = Yii::$app->user->id;
            endif;
            
            $model->dat_created = date('Y-m-d');
             $model->save();
             
             //Save attachment
            if(isset($_FILES['PropertyImageGalleries']['name']) && !empty($_FILES['PropertyImageGalleries']['name'])):
                foreach($_FILES['PropertyImageGalleries']['name']['name'] as $key => $txtFileName):
    
                    $id = $model->id;
                    //Save Featured Image
                     $txtBaseFilePath = '/Gallery/'.$id.'/';
                    $baseImage = (file_get_contents($_FILES['PropertyImageGalleries']['tmp_name']['name'][$key]));
                    FileHelper::createDirectory($txtHostName.$txtBaseFilePath,$mode = 0777);
                   file_put_contents($txtHostName.$txtBaseFilePath.$txtFileName,$baseImage);
                   
                   //Save Property Attachment Model
                   $modelAttachment = new PropertyImageGalleries();
                   $modelAttachment->id = $model->getNextId('property_image_galleries','id');
                   $modelAttachment->property_id = $model->id;
                   $modelAttachment->name =$txtFileName;
                   $modelAttachment->size = (string)$_FILES['PropertyImageGalleries']['size']['name'][$key];
                  // $modelAttachment->created_at = time();
                   $modelAttachment->save();
                endforeach;
            endif;
            
            
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'attachmentObj' => $attachmentObj,
            'txtFilePath' => '',
        ]);
    }

    /**
     * Updates an existing Properties model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $attachmentObj = new PropertyImageGalleries();
        $attachmentObj->scenario = 'update';
        $attachmentModel = PropertyImageGalleries::find()
                                    ->andWhere('property_id = '.$id)
                                    ->all();
       
        $txtImageName = $model->image;
        if ($model->load(Yii::$app->request->post())) {
                        $txtHostName = $_SERVER['DOCUMENT_ROOT'];
           
           
            if(isset($_FILES['Properties']['name']['image']) && !empty($_FILES['Properties']['name']['image'])):
                
                $model->image = $_FILES['Properties']['name']['image'];
                $id = $model->id;
                //Save Featured Image
                 $txtBaseFilePath = '/Featured/'.$id.'/';
                $baseImage = (file_get_contents($_FILES['Properties']['tmp_name']['image']));
                FileHelper::createDirectory($txtHostName.$txtBaseFilePath,$mode = 0777);
            file_put_contents($txtHostName.$txtBaseFilePath.$model->image,$baseImage);
            endif;
            
            if(empty(Yii::$app->user->id)):
                $model->agent_id = 1;
            else:
                $model->agent_id = Yii::$app->user->id;
            endif;
            if(empty($model->image)):
                $model->image = $txtImageName;
            endif;
           // echo '<pre>';print_R($model);exit;
             $model->save();
             //echo '<pre>';print_R($_FILES);exit;
             //Save attachment
            if(isset($_FILES['PropertyImageGalleries']['name']['name']) && !empty($_FILES['PropertyImageGalleries']['name'])):
                foreach($_FILES['PropertyImageGalleries']['name']['name'] as $key => $txtFileName):
                    if(empty($txtFileName)):
                        continue;
                    endif;
                    $id = $model->id;
                    //Save Featured Image
                     $txtBaseFilePath = '/Gallery/'.$id.'/';
                    $baseImage = (file_get_contents($_FILES['PropertyImageGalleries']['tmp_name']['name'][$key]));
                    FileHelper::createDirectory($txtHostName.$txtBaseFilePath,$mode = 0777);
                   file_put_contents($txtHostName.$txtBaseFilePath.$txtFileName,$baseImage);
                   
                   //Save Property Attachment Model
                   $modelAttachment = new PropertyImageGalleries();
                   $modelAttachment->id = $model->getNextId('property_image_galleries','id');
                   $modelAttachment->property_id = $model->id;
                   $modelAttachment->name =$txtFileName;
                   $modelAttachment->size = (string)$_FILES['PropertyImageGalleries']['size']['name'][$key];
                   //$modelAttachment->created_at = time();
                   
                   $modelAttachment->save();
                  
                endforeach;
            endif;
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'attachmentObj' => $attachmentObj,
            'attachmentModel' => $attachmentModel,
            'txtFilePath' => '',
        ]);
    }

    /**
     * Deletes an existing Properties model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $modelAttachment = PropertyImageGalleries::find()
                                ->andWhere('property_id = '.$id)
                                ->all();
        foreach($modelAttachment as $recAttachment):
            $this->deleteGalleryImage($recAttachment['id']);
        endforeach;
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Properties model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Properties the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Properties::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function deleteGalleryImage($key){
       $arrGalaryImage = PropertyImageGalleries::find()
                            ->andWhere('id = '.$key)->one();
       if(!empty($arrGalaryImage)):
           $txtImageName = $arrGalaryImage->name;
        $txtHostName = $_SERVER['DOCUMENT_ROOT'];
           $txtBaseFilePath = '/Gallery/'.$arrGalaryImage->property_id.'/';
           $txtPath = $txtHostName.$txtBaseFilePath.$txtImageName;
            
           if(file_exists($txtPath)):
               
               unlink($txtPath);
           endif;
           
           $arrGalaryImage->delete();
           endif;
           
        
    }
}
