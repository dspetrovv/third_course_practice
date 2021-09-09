<?php

namespace app\modules\myprofile\controllers;

use Yii;
use yii\web\Controller;
use app\models\Profile;
use app\models\Date;
use app\models\Usertoexcursion;
use app\models\Excursions;
use yii\data\Pagination;

class DefaultController extends Controller
{

    public function actionIndex()
    {
    	if (Yii::$app->user->isGuest){
            return $this->redirect(['../site/login']);
        }

        $user = new Profile();
        $date = new Date();
        $date = $date->getDate();
        $date = Yii::$app->formatter->asDatetime($date,'YYYY-MM-dd HH:mm:ss');

        $activeExcursion = Excursions::find()->select('id')->where('date >= "' . $date . '"')->asArray()->all();

        $array = array();
        foreach ($activeExcursion as $value) {
            foreach ($value as $val) {
                array_push($array, $val);
            }
        }

        $excursions = Usertoexcursion::find()->where('iduser = '. $user->getUserData()->id . ' and idexcursion in (' . implode(",",$array) . ')');
        $count = $excursions->count();
        
        $paginationActiveExc = new Pagination(['totalCount' => $count,
            'pageSize' => 8, 'pageParam' => 'activeExcPage', 'forcePageParam' => false, 'pageSizeParam' => false
        ]);

        $excursions = $excursions->offset($paginationActiveExc->offset)
                                ->limit($paginationActiveExc->limit)
                                ->all();

        $pastExcursion = Excursions::find()->select('id')->where('date < "' . $date . '"')->asArray()->all();
        $array = array();
        foreach ($pastExcursion as $value) {
            foreach ($value as $val) {
                array_push($array, $val);
            }
        }

        $lastExcursions = Usertoexcursion::find()->where('iduser = '. $user->getUserData()->id . ' and idexcursion in (' . implode(",",$array) . ')');
        $count = $lastExcursions->count();
        
        $paginationPastExc = new Pagination(['totalCount' => $count,
            'pageSize' => 8, 'pageParam' => 'pastExcPage', 'forcePageParam' => false, 'pageSizeParam' => false
        ]);

        $lastExcursions = $lastExcursions->offset($paginationPastExc->offset)
                                ->limit($paginationPastExc->limit)
                                ->all();

        return $this->render('index',[
        	'profile' => $user,
        	'date' => $date,
        	'excursions' => $excursions,
            'lastExcursions' => $lastExcursions,
            'paginationActiveExc' => $paginationActiveExc,
            'paginationPastExc' => $paginationPastExc
        ]);
    }
}
