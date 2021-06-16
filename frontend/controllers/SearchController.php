<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Properties;
use frontend\models\searchModel\PropertiesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PropertiesController implements the CRUD actions for Properties model.
 */
class SearchController extends Controller
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

    /**
     * Lists all Properties models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PropertiesSearch();
        $arrParams = Yii::$app->request->queryParams;
        list($dataProvider,$arrData) = $searchModel->search($arrParams);
     
        return $this->render('index', [
            'searchModel' => $searchModel,
            'arrData' => $arrData,
        ]);
    }
    
    public function actionShowDetail($id){
        $arrData = Properties::find()
                        ->andWhere('id = '.$id)
                        ->one();
        $txtUsername = '';
        $txtOwnername = '';
        $intCustomerType = '';
        $intLoginUserID = '';
        $intOwnerID = '';
        $arrAgentUsers = [];
        $intLoginUserID = Yii::$app->user->id;
        $intOwnerID = $arrData['agent_id'];
        $arrMessage =[];
        $arrGalleryImages = \frontend\models\PropertyImageGalleries::find()
                                ->andWhere('property_id = '.$id)
                                ->all();
     
        if(!Yii::$app->user->isGuest):
            $arrMessage = \frontend\models\Messages::find()
                            ->andWhere('user_id = '.$intLoginUserID.' or agent_id = '.$intLoginUserID)
                            ->andWhere('property_id='.$id)
                            ->asArray()
                            ->all();
            $arrLoginUser = \frontend\models\Users::find()
                                ->andWhere('id = '.$intLoginUserID)
                                ->asArray()
                                ->one();
            $txtUsername = $arrLoginUser['name'];
            $intCustomerType= $arrLoginUser['role_id'];
            $txtOwnername = \frontend\models\Users::find()
                                ->andWhere('id = '.$intOwnerID)
                                ->asArray()
                                ->one()['name'];
            $arrAgentUsers = \yii\helpers\ArrayHelper::getColumn($arrMessage,'user_id');
            $arrAgentUsers = array_unique($arrAgentUsers);
        endif;
        
        return $this->render('show-detail', [
            'arrData' => $arrData,
            'arrGalleryImages' => $arrGalleryImages,
            'arrMessage' => $arrMessage,
            'txtUsername' => $txtUsername,
            'txtOwnername' => $txtOwnername,
            'intCustomerType' =>$intCustomerType,
            'intLoginUserID' => $intLoginUserID,
            'intOwnerID' => $intOwnerID,
            'arrAgentUsers' => $arrAgentUsers,
            'intPropertyId' => $id
        ]);
    }
    
    public function actionMessage(){
        $arrPost = Yii::$app->request->post();
        $propertyMOdel = new Properties();
        $txtMessage = 'hello';
        $intOwnerId = $arrPost['intOwnerId'];
        $intUserId = $arrPost['intUserId'];
        $intPropertyId = $arrPost['intPropertyId'];
        
        $model = new \frontend\models\Messages();
        $model->message = $txtMessage;
        $model->user_id = $intUserId;
        $model->agent_id  =$intOwnerId;
        $model->property_id = $intPropertyId;
        $model->id = $propertyMOdel->getNextId('messages','id');
       
        $model->save();
         
        $strContent = $this->getMessage($intPropertyId,$intUserId,$intOwnerId);
        return $strContent;
    }
    
    public function getMessage($intPropertyId,$intUserId,$intOwnerId){
        $arrMessage = \frontend\models\Messages::find()
                            ->andWhere('user_id = '.$intUserId)
                            ->andWhere('property_id='.$intPropertyId)
                            ->asArray()
                            ->all();
        $strContent = '';
        $txtUsername = \frontend\models\Users::find()->andWhere('id = '.$intUserId)->one()['name'];
         $txtOwnerName = \frontend\models\Users::find()->andWhere('id = '.$intOwnerId)->one()['name'];
        
         foreach($arrMessage as $recMessage):
            if((($intUserId == $recMessage['user_id']) && $recMessage['ysn_reply'] ==0) || (($intUserId == $recMessage['agent_id']) && $recMessage['ysn_reply'] ==1)):
                $strContent.= '<div class="badge media pull-right" style="font-size: xx-small;"><div class="media-body media-body-width"><h5 class="my-0 font-weight-bold" style="font-size: 13px;">'.$txtUsername.'</h5>';
                $strContent.= '<span class="commentView">'.$recMessage['message'].'</span></div></div>';
            else:
                $strContent.= '<<div class="media"><div class="media-body media-body-width"><h5 class="my-0 font-weight-bold" style="font-size: 13px;">'.(!empty($recMessage['ysn_reply']) ? $txtOwnerName : $txtUsername).'</h5>';
                $strContent.= '<span class="commentView">'.$recMessage['message'].'</span></div></div>';
            endif;


        endforeach;
        return $strContent;
        
    }
}