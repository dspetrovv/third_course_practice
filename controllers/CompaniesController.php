<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\CompanyForm;
use app\models\Company;

class CompaniesController extends Controller
{
    
    public function actionIndex()
    {

        return $this->render('index');
    }

}
