<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Usertoexcursion;
use app\models\Sitesettings;
use app\models\SettingsForm;
use app\models\User;
use app\models\Date;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */

    public function actionIndex()
    {
    	$newUserToExc = Usertoexcursion::find()->orderBy('date DESC')->limit(5)->all();
    	$newRegistration = User::find()->orderBy('date DESC')->limit(5)->all();
        $settings = Sitesettings::find()->one();

        if (Yii::$app->request->isPost){
            var_dump(Yii::$app->request->post());die;
        }
        $newDate = new Date();

        return $this->render('index',[
        	'act' => $newUserToExc,
        	'registrations' => $newRegistration,
            'settings' => $settings,
            'newDate' => $newDate
        ]);
    }

}
