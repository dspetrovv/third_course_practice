<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Usertoexcursion;
use app\models\Excursions;
use app\models\User;
use app\models\Date;
use app\models\UserForm;

class UsersController extends Controller
{

    public function actionIndex()
    {
    	$newRegistration = User::find();
    	$newUserForm = new UserForm();

        $date = new Date();
        $date = $date->getDate();
        $date = Yii::$app->formatter->asDatetime($date,'YYYY-MM-dd HH:mm:ss');

        $arrExc = Excursions::find()->select('id')->where('date <= "'.$date.'"')->all();
        $excArr = array();
        foreach ($arrExc as $value) {
            array_push($excArr, $value->id);
        }

    	if (isset($_GET['name']) && strlen($_GET['name']) != 0){
            $newRegistration = $newRegistration->where("`name` like '%" . $_GET['name'] . "%'");
        } else if (isset($_GET['surname']) && strlen($_GET['surname']) != 0){
            $newRegistration = $newRegistration->where("`surname` like '%" . $_GET['surname'] . "%'");
        } else if (isset($_GET['email']) && strlen($_GET['email']) != 0){
            $newRegistration = $newRegistration->where("`email` like '%" . $_GET['email'] . "%'");
        }

    	$count = $newRegistration->count();

    	if (Yii::$app->request->isPost){
            $id = Yii::$app->request->post("UserForm")['idusr'];
            if (Yii::$app->request->post("UserForm")['action'] == "exc"){
                $idexc = Yii::$app->request->post("UserForm")['idexc'];
                if (!is_null($idexc) && $idexc != ''){
                    $newUserForm->deleteExcursionRecord($id,$idexc);
                    $this->refresh();
                } $this->refresh();
            } else if (Yii::$app->request->post("UserForm")['action'] == "passwd"){
        		$passwd = Yii::$app->request->post("UserForm")['password'];
        		if (!is_null($id) && !is_null($passwd) && $passwd != '' && $id != ''){
        			$newUserForm->password = $passwd;
        		    $newUserForm->changePassword($id);
        		    $this->refresh();
        		} $this->refresh();
            } else if (Yii::$app->request->post("UserForm")['action'] == "status"){
                if (!is_null($id) && $id != ''){
                    $newUserForm->changeStatus($id);
                    $this->refresh();
                } $this->refresh();
            }
        }

        $pagination = new Pagination(['totalCount' => $count,
            'pageSize' => (isset($_GET['per-page']) && strlen($_GET['per-page']) != 0) ? $_GET['per-page'] : 10
        ]);
        $number = $pagination->offset + 1;  

        $pages = $newRegistration->offset($pagination->offset)
                            ->limit($pagination->limit)
                            ->all();  

        return $this->render('index',[
        	'users' => $pages,
        	'pagination' => $pagination,
        	'number' => $number,
        	'usrform' => $newUserForm,
            'date' => $date,
            'excArr' => $excArr
        ]);
    }
}
