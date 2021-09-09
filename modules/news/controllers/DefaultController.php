<?php

namespace app\modules\news\controllers;

use yii\web\Controller;
use app\models\News;
use app\models\Sitesettings;
use yii\data\Pagination;

/**
 * Default controller for the `news` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$news = News::find();

    	$count = $news->count();

    	$settings = Sitesettings::find()->one();

        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => (isset($_GET['per-page']) && strlen($_GET['per-page']) != 0)
                ? $_GET['per-page']
                : (!is_null($settings->newspagination)
                    ? $settings->newspagination
                    : 10),
                'forcePageParam' => false,
                'pageSizeParam' => false
        ]);

        $pages = $news->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();
        $count = count($pages);
        
        return $this->render('index',[
        	'news' => $pages,
            'pagination' => $pagination,
            'count' => $count
        ]);
    }
}
