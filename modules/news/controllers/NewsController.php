<?php

namespace app\modules\news\controllers;

use Yii;
use yii\web\Controller;
use app\models\News;

class NewsController extends Controller
{

    public function actionIndex()
    {
		if (isset($_GET['id']) && strlen($_GET['id']) != 0){

			$News = News::findOne(['id' => $_GET['id']]);

			if (is_null($News))
				return $this->redirect([Yii::$app->homeUrl.'/news']);
            
        	return $this->render('index',[
        		'news' => $News,
        	]);
    	} else return $this->redirect([Yii::$app->homeUrl.'/news']);
    }
}
