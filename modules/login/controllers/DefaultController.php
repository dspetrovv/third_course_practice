<?php

namespace app\modules\login\controllers;

use yii\web\Controller;
use Yii;
use app\models\LoginForm;

/**
 * Default controller for the `login` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if (Yii::$app->request->post('LoginForm')){
            $model->attributes = Yii::$app->request->post('LoginForm');

            if ($model->validate()){
                $model->login();
                return $this->goHome();
            }
        }

        return $this->render('index',[
            'model' => $model
        ]);
    }
}
