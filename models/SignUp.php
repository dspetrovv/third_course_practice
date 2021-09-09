<?php

namespace app\models;

use yii\base\Model;

class SignUp extends Model
{
	public $name;
    public $surname;
	public $email;
	public $password;
	public $date;
	public $verifyCode;

	public function rules()
	{
		return [
			[['name','surname','email','password'],'required','message' => 'Обязательно для заполнения'],
			['email','email','message' => 'Email введён некорректно'],
			[['email'],'unique','targetClass' => 'app\models\User'],
			['password','string','min' => 6,'max' => 12,'tooShort' => 'Пароль должен содержать от 6 до 12 символов', 'tooLong' => 'Пароль должен содержать от 6 до 12 символов'],
			['verifyCode', 'captcha', 'captchaAction' => 'site/captcha']
		];
	}

	public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

	public function SignUp()
	{
		$newUser = new User();
		$getdate = new Date();
		$newUser->name = $this->name;
		$newUser->surname = $this->surname;
		$newUser->email = $this->email;
		$newUser->setPassword($this->password);
		$newUser->date = $getdate->getDate()->format('Y-m-d H:m:s');
		return $newUser->save(false);
	}
}

?>