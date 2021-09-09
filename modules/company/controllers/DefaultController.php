<?php

namespace app\modules\company\controllers;

use yii\web\Controller;
use app\models\CompanyForm;
use app\models\Company;
use app\models\Sitesettings;
use yii\data\Pagination;

/**
 * Default controller for the `company` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

    	$companies = Company::find();

        $count = $companies->count();

        $settings = Sitesettings::find()->one();

        $pagination = new Pagination(['totalCount' => $count,
            'pageSize' => (isset($_GET['per-page']) && strlen($_GET['per-page']) != 0) ? $_GET['per-page'] : $settings->companypagination, 'forcePageParam' => false, 'pageSizeParam' => false
        ]);

        $pages = $companies->offset($pagination->offset)
                            ->limit($pagination->limit)
                            ->all();
        $count = count($pages);
    	//var_dump($companies->getCompanies());die;
        return $this->render('index',[
        	'companyname' => $pages,
            'pagination' => $pagination,
            'count' => $count
        ]);
    }

}
