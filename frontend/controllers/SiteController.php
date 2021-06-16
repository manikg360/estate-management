<?php
namespace frontend\controllers;

use common\models\LoginForm;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\Properties;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\Users;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use const YII_ENV_TEST;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
   

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $modelProperties = new Properties();
        $arrPost = Yii::$app->request->post();
        if ($model->load($arrPost)) {
            
            if(Yii::$app->request->isAjax):
                $arrError = ActiveForm::validate($model);
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return $arrError;
            endif;
//             $user = new User();
//            $user->setPassword($model->password);
//            $user->generateAuthKey();
//            $user->generateEmailVerificationToken();
            
            $modelUser = new Users();
            $modelUser->password = Yii::$app->security->generatePasswordHash($model->password);
            $modelUser->auth_key = Yii::$app->security->generateRandomString();
            $modelUser->email = $model->email;
           // $modelUser->created_at = time();
            $modelUser->role_id = (!empty($model->usertype) ? 2:3);
            $modelUser->name = $model->name;
            $modelUser->id = $modelProperties->getNextId('user','id');
           
            $arr = explode("/", $model->name, 2);
            $modelUser->username = $arr[0];
          //  echo '<pre>';print_R($modelUser);exit;
            $modelUser->save();
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please sign in to continue to this site.');
            return $this->redirect(['login','r'=>'login']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
    
    public function actionProfile(){
        $id = Yii::$app->user->id;
        $model = Users::find()->andWhere('id='.$id)->one();
        $modelProperties = new Properties();
        $arrPost = Yii::$app->request->post();
        $txtPassword = $model->password;
        $txtImage = $model->image;
        if ($model->load($arrPost)) {
            
            if(Yii::$app->request->isAjax):
                $arrError = ActiveForm::validate($model);
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return $arrError;
            endif;
//             $user = new User();
//            $user->setPassword($model->password);
//            $user->generateAuthKey();
//            $user->generateEmailVerificationToken();
            
//            $modelUser = new Users();
//            $modelUser->email = $model->email;
//           // $modelUser->created_at = time();
//            $modelUser->name = $model->name;
           if($txtPassword != $model->password):
                $model->password = Yii::$app->security->generatePasswordHash($model->password);
            $model->auth_key = Yii::$app->security->generateRandomString();
           endif;
            $arr = explode("/", $model->name, 2);
            $model->username = $arr[0];
          
             $txtHostName = $_SERVER['DOCUMENT_ROOT'];
            if(isset($_FILES['Users']['name']['image']) && !empty($_FILES['Users']['name']['image'])):
                
                $model->image = $_FILES['Users']['name']['image'];
                $id = $model->id;
                //Save Featured Image
                 $txtBaseFilePath = '/Profile/'.$id.'/';
                $baseImage = (file_get_contents($_FILES['Users']['tmp_name']['image']));
                FileHelper::createDirectory($txtHostName.$txtBaseFilePath,$mode = 0777);
            file_put_contents($txtHostName.$txtBaseFilePath.$model->image,$baseImage);
            endif;
           
            if(empty($model->image)):
                $model->image = $txtImage;
            endif;
            $model->save();
            Yii::$app->session->setFlash('success', 'Profile has been updated successfully..');
            return $this->goHome();
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }
}
