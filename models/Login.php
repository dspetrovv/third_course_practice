<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Login extends Model{
	public $email;
	public $password;

	public function rules(){
		return [
			[['email','password'],'required'],
			['email','email'],
			['password','validatePassword']
		];
	}

	public function login(){
		if ($this->validate()){
			return Yii::$app->user->login($this->getUser());
		}
	}

	public function validateUserPassword($attr){
		
		if (!$this->hasErrors()){
			$user = $this->getUser();
			if (!$user || !$user->validateUserPassword($this->password)){
				$this->addError($attr,'Email или пароль введены неправильно');
			}
		}
		
	}

	public function getUser(){
		return User::findOne(['email' => $this->email]);
	}

}


?>