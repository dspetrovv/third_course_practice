<?php

namespace app\models;

use yii\base\Model;

class Date extends Model
{
	public function getDate()
	{
		$date = new \DateTime('now', new\DateTimeZone('GMT+3'));
		return $date;
	}
}

?>