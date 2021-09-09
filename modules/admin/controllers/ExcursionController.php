<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Company;
use app\models\CompanyForm;
use app\models\Excursions;
use app\models\ExcursionsForm;
use app\models\Date;
use yii\data\Pagination;

class ExcursionController extends Controller
{

    public function actionIndex()
    {
    	$newDate = new Date();
    	$newExcursion = new ExcursionsForm();
        $actionExcursion = new ExcursionsForm();

        $newCompanyForm = new CompanyForm();
		//var_dump($newDate->getDate()->format('Y-m-d H:m:s'));die;
        $complist = Company::find()->asArray()->all();
        $comps = $newCompanyForm->getCompanynamesList();
        foreach ($complist as $company) {
            $comps[$company['companyname']] = $company['companyname'];
        }

    	if (Yii::$app->request->isPost){
            if (Yii::$app->request->post('ExcursionsForm')['action'] === 'new'){
                $newExcursion->attributes = Yii::$app->request->post('ExcursionsForm');
                $newExcursion->uniquepeople = Yii::$app->request->post('ExcursionsForm')['uniquepeople'];
                $newExcursion->datetime = Yii::$app->request->post()['datetime'];
                if ($newExcursion->validate()){
                    $newExcursion->makeExcursion();
                    return $this->refresh();
                }
            } else if (Yii::$app->request->post('ExcursionsForm')['action'] === 'deny'){
                $idexc = Yii::$app->request->post('ExcursionsForm')['idexc'];
                $idusr = Yii::$app->request->post('ExcursionsForm')['idusr'];
                $actionExcursion->denyRegistration($idusr,$idexc);
                return $this->refresh();
            } else if (Yii::$app->request->post('ExcursionsForm')['action'] === 'cancel'){
                $idexc = Yii::$app->request->post('ExcursionsForm')['idexc'];
                $actionExcursion->cancelExcursion($idexc);
                return $this->refresh();
            } else if (Yii::$app->request->post('ExcursionsForm')['action'] === 'access'){
                $idexc = Yii::$app->request->post('ExcursionsForm')['idexc'];
                $actionExcursion->changeAccess($idexc);
                return $this->refresh();
            } return $this->refresh();
    	}

        $currentDate = Yii::$app->formatter->asDatetime($newDate->getDate(),'YYYY-MM-dd HH:mm:ss');
    	$companies = $newExcursion->getCompanies();
    	$activeExcursion = Excursions::find()->where('date > "'. $currentDate .'" and status = 1');

    	$count = $activeExcursion->count();

    	$activeExcursion = $activeExcursion->all();

    	//var_dump($companies);die;
        return $this->render('index',[
        	'excursions' => $activeExcursion,
        	'companies' => $companies,
        	'count' => $count,
            'companynames' => $comps,
        	'excmodel' => $newExcursion,
            'actionExc' => $actionExcursion,
            'currentDate' => $currentDate
        ]);
    }

    public function actionExcursionlist()
    {
        $newDate = new Date();
        $newExcursion = new ExcursionsForm();
        $newCompanyForm = new CompanyForm();

        $complist = Company::find()->asArray()->all();
        $comps = $newCompanyForm->getCompanynamesList();
        foreach ($complist as $company) {
            $comps[$company['companyname']] = $company['companyname'];
        }

        if (Yii::$app->request->isPost){
            $newExcursion = new ExcursionsForm();
            $newExcursion->deleteExcursion(Yii::$app->request->post("CompanyForm")['idexcursion']);
            return $this->refresh();
        }

        $defvalue = null;
        $companies = $newExcursion->getCompanies();
        if (isset($_GET['company'])){
            $tempvalcompany = Company::findOne(['companyname' => $_GET['company']]);
            if (!is_null($tempvalcompany)){
                $activeExcursion = Excursions::find()->where('idcompany = '.$tempvalcompany->id.' and (date < "'. Yii::$app->formatter->asDatetime($newDate->getDate(),'YYYY-MM-dd HH:mm:ss') .'" or status = 0)');
                $defvalue = $_GET['company'];
            } else $activeExcursion = Excursions::find()->where('date < "'. Yii::$app->formatter->asDatetime($newDate->getDate(),'YYYY-MM-dd HH:mm:ss') .'" or status = 0');
        } else $activeExcursion = Excursions::find()->where('date < "'. Yii::$app->formatter->asDatetime($newDate->getDate(),'YYYY-MM-dd HH:mm:ss') .'" or status = 0');

        $count = $activeExcursion->count();

        $pagination = new Pagination(['totalCount' => $count,
            'pageSize' => (isset($_GET['per-page']) && strlen($_GET['per-page']) != 0) ? $_GET['per-page'] : 10
        ]);
        $number = $pagination->offset + 1;
        if (!isset($_GET['idcompany'])){
            $activeExcursion->orderby('idcompany ASC');
        }
        $pages = $activeExcursion->offset($pagination->offset)
                                ->limit($pagination->limit)
                                ->all();

        return $this->render('excursionlist',[
            'excursions' => $pages,
            'number' => $number,
            'companies' => $companies,
            'count' => $count,
            'pagination' => $pagination,
            'companynames' => $comps,
            'defvalue' => $defvalue,
            'companyform' => $newCompanyForm
        ]);
    }

}
