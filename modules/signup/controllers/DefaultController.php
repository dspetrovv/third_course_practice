<?php

namespace app\modules\signup\controllers;

use Yii;
use yii\web\Controller;
use yii\captcha\Captcha;
use app\models\SignUp;

/**
 * Default controller for the `signup` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
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

    public function actionIndex()
    {
        $model = new SignUp();
        if (isset($_POST['SignUp'])){

            $model->attributes = Yii::$app->request->post('SignUp');
            //var_dump($model->errors);die;
            if ($model->validate() && $model->SignUp()){
                $this->goBack();
            }
        }
        return $this->render('index',[
            'model' => $model
        ]);
    }
}
