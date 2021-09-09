<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\Date;
use app\models\Company;
use app\models\CompanyForm;
use app\models\Demo;
use app\models\DemoForm;

/**
 * Default controller for the `admin` module
 */
class CompanyController extends Controller
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

    public function actionIndex()
    {
    	$Companies = Company::find()->where('id is not null');
        $count = $Companies->count();

        $pagination = new Pagination(['totalCount' => $count,
            'pageSize' => (isset($_GET['per-page']) && strlen($_GET['per-page']) != 0) ? $_GET['per-page'] : 10
        ]);
        $number = $pagination->offset + 1;  

        $pages = $Companies->offset($pagination->offset)
                            ->limit($pagination->limit)
                            ->all();                      
		$date = new Date();
		$date = $date->getDate();
		$date = Yii::$app->formatter->asDatetime($date,'YYYY-MM-dd HH:mm:ss');

        if (Yii::$app->request->isPost){
            if (!is_null(Yii::$app->request->post()['del'])){
                $CompanyForm = new CompanyForm();
                $CompanyForm->deleteCompany(Yii::$app->request->post()['del']);
                return $this->refresh();
            }
            return $this->refresh();
        }

        return $this->render('index',[
        	'companies' => $pages,
            'pagination' => $pagination,
        	'number' => $number,
        	'date' => $date
        ]);
    }

    public function actionEdit()
    {
        if (!isset($_GET['id']) && strlen($_GET['id']) == 0 && !is_numeric($_GET['id']))
            return $this->redirect(Yii::$app->homeUrl . 'admin/company');

        $newCompanyForm = new CompanyForm();
        $company = Company::findOne(['id' => $_GET['id']]);

        if (is_null($company)){
            return $this->redirect(Yii::$app->homeUrl . 'admin/company');
        }

        if (Yii::$app->request->isPost){
            $file = UploadedFile::getInstance($newCompanyForm, 'companyphoto');
            $newCompanyForm->attributes = Yii::$app->request->post('CompanyForm');
            $newCompanyForm->id = Yii::$app->request->post()['hide'];
            if (is_null($file))
                $newCompanyForm->companyphoto = $company->companyphoto;

            if ($newCompanyForm->validate()){
                $newCompanyForm->editCompany($file,$_GET['id']);
                return $this->redirect(Yii::$app->homeUrl . 'admin/company');
            }
        }

        return $this->render('edit',[
            'company' => $newCompanyForm,
            'companyData' => $company
        ]);
    }

    public function actionNew()
    {
    	$newCompanyForm = new CompanyForm();

    	if (Yii::$app->request->isPost){
    		if (Yii::$app->request->post('hide') === "Save"){
    		    $this->CompanySave($newCompanyForm,true);
    		}
    	}

        return $this->render('new',[
        	'company' => $newCompanyForm
        ]);
    }

    public function actionDemo()
    {
        if (isset($_POST['CompanyForm'])){

            $CompanyForm = new CompanyForm();

            if (isset($_POST['CompanyForm']['save'])){
                if ($_POST['CompanyForm']['save'] === 'edit'){
                    $this->SaveFromDemo($CompanyForm,'edit',$_POST['CompanyForm']['id']);
                } else if ($_POST['CompanyForm']['save'] === 'new'){
                    $this->SaveFromDemo($CompanyForm,'new',null);
                }
                return $this->redirect(Yii::$app->homeUrl . 'admin/company');
            }
            
            $DemoForm = new CompanyForm();
            $DemoForm->attributes = $_POST['CompanyForm'];
            if (!is_null($_POST['hide']))
                $DemoForm->id = $_POST['hide'];
            $img = UploadedFile::getInstance($CompanyForm, 'companyphoto');
            if (is_null($img)){
                $DemoForm->companyphoto = Company::findOne(['id' => $_POST['hide']])->companyphoto;
                $DemoForm->id = $_POST['hide'];
            }
            else
                $DemoForm->saveImage($img);

            return $this->render('demo',[
                'demo' => $DemoForm,
                'model' => $CompanyForm,
                'action' => $_POST['action'],
                'validation' => $DemoForm->validate()
            ]);
        } else 
            return $this->goBack();
    }

    public function SaveFromDemo($newDemoForm,$action,$id)
    {
    	$newDemoForm->companyname = Yii::$app->request->post('CompanyForm')['companyname'];
    	$newDemoForm->photoname = Yii::$app->request->post('CompanyForm')['photoname'];
    	$newDemoForm->companydescription = Yii::$app->request->post('CompanyForm')['companydescription'];
    	$newDemoForm->companyrequirements = Yii::$app->request->post('CompanyForm')['companyrequirements'];
    	$newDemoForm->latcoord = Yii::$app->request->post('CompanyForm')['latcoord'];
    	$newDemoForm->longcoord = Yii::$app->request->post('CompanyForm')['longcoord'];
    	$newDemoForm->place = Yii::$app->request->post('CompanyForm')['place'];
        $newDemoForm->id = $id;
        if ($action === 'edit' && $newDemoForm->validate())
            $newDemoForm->editFromDemo();
        else if ($action === 'new' && $newDemoForm->validate())
    	   $newDemoForm->saveFromDemo();
    }

    public function CompanySave($newcompany,$isNew)
    {
    	$newcompany->attributes = Yii::$app->request->post('CompanyForm');
    	$img = UploadedFile::getInstance($newcompany, 'companyphoto');
        if (is_null($img)){
            $newcompany->companyphoto = 'news';
        } else $newcompany->saveImage($img);
        if ($isNew){
            if ($newcompany->validate()){
                $newcompany->createCompany($img,$isNew);
                return $this->redirect(Yii::$app->homeUrl . 'admin/company');
            } 
        } else {
            $newcompany->createCompany($img,$isNew);
            return $this->redirect(Yii::$app->homeUrl . 'admin/company');
        }
    }
}
