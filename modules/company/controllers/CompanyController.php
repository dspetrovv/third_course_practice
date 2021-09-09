<?php

namespace app\modules\company\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\Date;
use app\models\Excursions;
use app\models\CompanyForm;
use app\models\Company;
use app\models\User;
use app\models\Useractivity;
use app\models\Usertoexcursion;

class CompanyController extends Controller
{

    public function actionIndex()
    {
		if (isset($_GET['id']) && strlen($_GET['id']) != 0 && is_numeric($_GET['id'])){
            $newParticipant = new Useractivity();

            $date = new Date();
            $date = $date->getDate();
            $date = Yii::$app->formatter->asDatetime($date,'YYYY-MM-dd HH:mm:ss');

            $newExcursions = Excursions::findBySql('Select * From Excursions Where idcompany = '. $_GET['id'] . ' and date >= "'. $date . '" order by date ASC')->all();
            
            $isActive = array();

            $checkExc = Excursions::find()->select('id')->where('idcompany = '.$_GET['id'])->all();
            $checkArr = array();
            foreach ($checkExc as $value) {
                array_push($checkArr, $value->id);
            }
            
            $totalParticipants = array();
            $currentParticipants = array();
            $uniqueParticipant = array();
            $isParticipant = array();
            $access = array();
            //var_dump($newExcursions->id);die;

    		$company = Company::find()->where('id = ' . $_GET['id'])->one();

            if (is_null($company))
                return $this->redirect([Yii::$app->homeUrl.'/company']);

            $userStatus = null;
            if (!Yii::$app->user->isGuest)
                $userStatus = User::findOne(['id' => Yii::$app->user->identity->id])->status;
            else
                $userStatus = null;

            if (!is_null($newExcursions)){
                foreach ($newExcursions as $newExc){
                    array_push($totalParticipants, $newExc->participants);
                    array_push($currentParticipants, $newExc->signed);
                    array_push($access,
                        $newExc->uniquepeople ?
                        Usertoexcursion::find()->where('idexcursion = '.
                            $newExc->id
                            .' and iduser = '.Yii::$app->user->identity->id)->one()
                        : null
                    );
                    array_push($uniqueParticipant,
                        $newExc->uniquepeople ?
                        Usertoexcursion::find()->where('idexcursion in ('.
                            implode(",",$checkArr)
                            .') and iduser = '.Yii::$app->user->identity->id)->one()
                        : null
                    );
                    if (Yii::$app->user->isGuest) {
                        $participation = Usertoexcursion::findBySql('Select * From Usertoexcursion Where idexcursion = '. $newExc->id)->one();
                    } else if (!Yii::$app->user->isGuest)
                        $participation = Usertoexcursion::findBySql('Select * From Usertoexcursion Where idexcursion = '. $newExc->id . ' and iduser = '. Yii::$app->user->identity->id)->one();
                    array_push($isParticipant, is_null($participation) ? false : true);
                }
            }
            else {
                $access = null;
                $totalParticipants = null;
                $currentParticipants = null;
                $uniqueParticipants = null;
                $isParticipant = null;
            }
            //var_dump($access);die;

            if (!is_null($currentParticipants) && !is_null($totalParticipants)){
                for ($i=0; $i < count($currentParticipants); $i++) { 
                    array_push($isActive, ($currentParticipants[$i] < $totalParticipants[$i]) ? true : false);
                }
            } else $isActive = null;

            if (Yii::$app->request->isPost){
                $idexc = Yii::$app->request->post('Useractivity')['idexcursion'];
                if ($currentParticipants[$idexc] < $totalParticipants[$idexc]){
                    $newParticipant->iduser = Yii::$app->user->identity->id;
                    $newParticipant->idexcursion = $newExcursions[$idexc]->id;
                    $newParticipant->date = $date;
                    $newParticipant->saveUserToExcursion();
                }
                return $this->refresh();
            }
    	
        	return $this->render('index',[
        		'company' => $company,
                'isParticipant' => $isParticipant,
                'participation' => $newParticipant,
                'isActive' => $isActive,
                'userStatus' => $userStatus,
                'current' => $currentParticipants,
                'total' => $totalParticipants,
                'uniquepart' => $uniqueParticipant,
                'newExcursions' => $newExcursions,
                'access' => $access
        	]);
    	} else return $this->redirect([Yii::$app->homeUrl.'/company']);
    }
}
