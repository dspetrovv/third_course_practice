<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Profile extends Model{
	
	public function getUserData(){
		$user = Yii::$app->user->identity;
		return $user;
	}

	public function getExcursionList(){
		return false;
	}

	public function deleteExcEntry($id){
		return false;
	}

}


?>