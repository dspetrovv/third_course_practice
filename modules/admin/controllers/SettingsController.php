<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\Sitesettings;
use app\models\SettingsForm;

class SettingsController extends Controller
{

    public function actions()
    {
        return [
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => '/images/',
                'path' => '@webroot/images/',
            ],
        ];
    }

    public function actionMain()
    {

        $newSettingsForm = new SettingsForm();
        $settings = Sitesettings::find()->one();

        if (Yii::$app->request->isPost){

        	$img1 = UploadedFile::getInstance($newSettingsForm, 'photo');
        	$img2 = UploadedFile::getInstance($newSettingsForm, 'mapicon');

            if (is_null($img1)){
            	$image = Sitesettings::find()->one();
                $newSettingsForm->photo = $image->photo;
            }
            else
                $newSettingsForm->saveIcon($img1,'photo');

            if (is_null($img2)){
            	$image = Sitesettings::find()->one();
                $newSettingsForm->mapicon = $image->mapicon;
            }
            else
                $newSettingsForm->saveIcon($img2,'mapicon');

        	$newSettingsForm->attributes = Yii::$app->request->post("SettingsForm");
        	$newSettingsForm->text = Yii::$app->request->post("SettingsForm")['text'];
        	if ($newSettingsForm->validate()){
        		$newSettingsForm->editSettings();
        		return $this->goBack();
        	} return $this->refresh();
        }

        return $this->render('main',[
            'settings' => $settings,
            'newSetts' => $newSettingsForm
        ]);
    }

    public function actionRules()
    {
        $newSettingsForm = new SettingsForm();
        $settings = Sitesettings::find()->one();

        if (Yii::$app->request->isPost){
        	$newSettingsForm->rules = Yii::$app->request->post("SettingsForm")['rules'];
        	if ($newSettingsForm->validate()){
        		$newSettingsForm->editRules();
        		return $this->redirect(Yii::$app->homeUrl . 'admin');
        	} return $this->refresh();
        }

        return $this->render('rules',[
            'settings' => $settings,
            'newSetts' => $newSettingsForm
        ]);
    }

    public function actionAbout()
    {
        $newSettingsForm = new SettingsForm();
        $settings = Sitesettings::find()->one();

        if (Yii::$app->request->isPost){
        	$newSettingsForm->about = Yii::$app->request->post("SettingsForm")['about'];
        	if ($newSettingsForm->validate()){
        		$newSettingsForm->editAbout();
        		return $this->redirect(Yii::$app->homeUrl . 'admin');
        	} return $this->refresh();
        }

        return $this->render('about',[
            'settings' => $settings,
            'newSetts' => $newSettingsForm
        ]);
    }

}
