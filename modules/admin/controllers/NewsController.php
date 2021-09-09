<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\News;
use app\models\NewsForm;

/**
 * Default controller for the `admin` module
 */
class NewsController extends Controller
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
    	$News = News::find()->where('id is not null');

        $count = $News->count();

        $pagination = new Pagination(['totalCount' => $count,
            'pageSize' => (isset($_GET['per-page']) && strlen($_GET['per-page']) != 0) ? $_GET['per-page'] : 10
        ]);
        $number = $pagination->offset + 1;  

        $pages = $News->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();

        if (Yii::$app->request->isPost){
            if (!is_null(Yii::$app->request->post()['del'])){
                $NewsForm = new NewsForm();
                $NewsForm->deleteNews(Yii::$app->request->post()['del']);
                return $this->refresh();
            }
            return $this->refresh();
        }

        return $this->render('index',[
        	'news' => $pages,
            'pagination' => $pagination,
            'number' => $number,
        ]);
    }

    public function actionEdit()
    {
        if (!isset($_GET['id']) && strlen($_GET['id']) == 0  && !is_numeric($_GET['id']))
            return $this->redirect(Yii::$app->homeUrl . 'admin/news');

        $newNewsForm = new NewsForm();
        $news = News::findOne(['id' => $_GET['id']]);

        if (is_null($news)){
            return $this->redirect(Yii::$app->homeUrl . 'admin/news');
        }

        if (Yii::$app->request->isPost){
            $file = UploadedFile::getInstance($newNewsForm, 'photo');
            $newNewsForm->attributes = Yii::$app->request->post('NewsForm');
            $newNewsForm->id = Yii::$app->request->post()['hide'];
            if (is_null($file))
                $newNewsForm->photo = $news->photo;

            if ($newNewsForm->validate()){
                $newNewsForm->editNews($file,$_GET['id']);
                return $this->redirect(Yii::$app->homeUrl . 'admin/news');
            }
        }

        return $this->render('edit',[
            'news' => $newNewsForm,
            'newsData' => $news
        ]);
    }

    public function actionNew()
    {
    	$NewsForm = new NewsForm();

    	if (Yii::$app->request->isPost){
    		if (Yii::$app->request->post('hide') === "Save"){
    		    $this->NewsSave($NewsForm);
    		} else if (Yii::$app->request->post('hide') === "Demo") {
    			$newDemoForm = new DemoForm();
    			$id = $this->ShowDemo($newDemoForm,$NewsForm);
    			return $this->redirect(Yii::$app->homeUrl . 'admin/company/demo?id=' . $id);
    		}
    	}

        return $this->render('new',[
        	'news' => $NewsForm
        ]);
    }

    public function actionDemo()
    {
    	if (isset($_POST['NewsForm'])){

    		$NewsForm = new NewsForm();

            if (isset($_POST['NewsForm']['save'])){
                if ($_POST['NewsForm']['save'] === 'edit'){
                    $this->SaveFromDemo($NewsForm,'edit',$_POST['NewsForm']['id']);
                } else if ($_POST['NewsForm']['save'] === 'new'){
                    $this->SaveFromDemo($NewsForm,'new',null);
                }
                return $this->redirect(Yii::$app->homeUrl . 'admin/news');
            }

    		if (isset($_POST['NewsForm']['save'])){
    			$this->SaveFromDemo($NewsForm);
    			return $this->redirect(Yii::$app->homeUrl . 'admin/news');
    		}
    		
    		$DemoForm = new NewsForm();

            $DemoForm->attributes = $_POST['NewsForm'];
            if (!is_null($_POST['hide']))
                $DemoForm->id = $_POST['hide'];
            $img = UploadedFile::getInstance($NewsForm, 'photo');
            if (is_null($img)){
                $DemoForm->photo = News::findOne(['id' => $_POST['hide']])->photo;
                $DemoForm->id = $_POST['hide'];
            }
            else
                $DemoForm->saveImage($img);

        	return $this->render('demo',[
        		'demo' => $DemoForm,
        		'model' => $NewsForm,
                'action' => $_POST['action'],
                'validation' => $DemoForm->validate()
        	]);
    	} else 
    		return $this->goBack();
    }

    public function NewsSave($news)
    {
    	$news->attributes = Yii::$app->request->post('NewsForm');
    	$img = UploadedFile::getInstance($news, 'photo');
        if (is_null($img)){
            $news->photo = null;
        } else $news->saveImage($img);
        if ($news->validate()){
            $news->createNews($img);
            return $this->redirect(Yii::$app->homeUrl . 'admin/news');
        } 
    }

    public function SaveFromDemo($NewsForm,$action,$id)
    {
    	$NewsForm->name = Yii::$app->request->post('NewsForm')['name'];
    	$NewsForm->photo = Yii::$app->request->post('NewsForm')['photos'];
    	$NewsForm->txt = Yii::$app->request->post('NewsForm')['txt'];
        $NewsForm->id = $id;
        if ($action === 'edit' && $NewsForm->validate())
            $NewsForm->editFromDemo();
        else if ($action=== 'new' && $NewsForm->validate())
           $NewsForm->saveFromDemo();
    }
}
