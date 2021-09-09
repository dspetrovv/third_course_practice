<?php

namespace app\models;

use yii\base\Model;

class Useractivity extends Model
{
	public $id;
    public $iduser;
	public $idexcursion;
	public $date;

	public function saveUserToExcursion()
	{
		$currentActivity = Excursions::findOne(['id' => $this->idexcursion]);
		if ($currentActivity->signed < $currentActivity->participants){
			$currentActivity->signed += 1;
			$currentActivity->save();
			$newActivity = new Usertoexcursion();
			$newActivity->iduser = $this->iduser;
			$newActivity->idexcursion = $this->idexcursion;
			$newActivity->date = $this->date;
			return $newActivity->save();
		}
	}
	
}

?>