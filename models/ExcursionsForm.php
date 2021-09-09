<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ExcursionsForm extends Model
{
    public $company;
    public $datetime;
    public $participants;
    public $signed;
    public $uniquepeople;

    public function rules()
    {
        return [
            [['company', 'datetime', 'participants'], 'required','message' => 'Обязательно для заполнения'],
            ['participants', 'number', 'min' => 1, 'tooSmall' => 'Количество участников не может быть меньше 1']
        ];
    }

    public function deleteExcursion($id)
    {
        $newExcursion = Excursions::findOne(['id' => $id]);
        $newUsertoExcursion = Usertoexcursion::findOne(['idexcursion' => $id]);
        if (!is_null($newUsertoExcursion))
            $newUsertoExcursion->delete();
        return $newExcursion->delete();
    }

    public function getCompanies()
    {
    	$comp = array();
		$companies = Company::find()->select('companyname')->asArray()->all();
		foreach ($companies as $value) {
			$comp[$value['companyname']] = $value['companyname'];
		}
    	return $comp;
    }

    public function changeAccess($id)
    {
        $Excursion = Excursions::findOne(['id' => $id]);
        $Excursion->uniquepeople = $Excursion->uniquepeople ? 0 : 1;
        return $Excursion->save();
    }

    public function cancelExcursion($id)
    {
        $Excursion = Excursions::findOne(['id' => $id]);
        $Excursion->status = 0;
        return $Excursion->save();
    }

    public function makeExcursion()
    {
        $newExcursion = new Excursions();
        $newExcursion->idcompany = Company::findOne(['companyname' => $this->company])->id;
        $newExcursion->date = $this->datetime;
        $newExcursion->participants = $this->participants;
        $newExcursion->uniquepeople = $this->uniquepeople;
        return $newExcursion->save();
    }

    public function denyRegistration($idusr,$idexc)
    {
        $newExc = Usertoexcursion::find()->where('idexcursion = ' . $idexc . ' and iduser = ' . $idusr)->one();
        if (!is_null($newExc))
            $newExc->delete();
        $newExcursion = Excursions::findOne(['id' => $idexc]);
        if (!is_null($newExcursion)){
            $newExcursion->signed = $newExcursion->signed-1;
            return $newExcursion->save();
        }
    }

    public function validateDatetime($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->datetime || strlen($this->datetime) == 0) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

}
