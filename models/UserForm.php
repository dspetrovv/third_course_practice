<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class UserForm extends Model
{
    public $name;
    public $surname;
    public $password;
    public $email;
    public $date;
    public $isAdmin;
    public $status;

    public function rules(){
        return [];
    }

    public function changePassword($id)
    {
        $newPassw = User::findOne(['id' => $id]);
        $newPassw->password = sha1($this->password);

        return $newPassw->save();
    }

    public function changeStatus($id)
    {
        $newStat = User::findOne(['id' => $id]);

        if ($newStat->status){
            $newStat->status = 0;

            $date = new Date();
            $date = $date->getDate();
            $date = Yii::$app->formatter->asDatetime($date,'YYYY-MM-dd HH:mm:ss');

            $newExc = Excursions::find()->where('date >= "'. $date . '"')->all();

            foreach ($newExc as $excursion) {
                if ($this->deleteExcursionRecord($id,$excursion->id)){
                    $excursion->signed = $excursion->signed-1;
                    $excursion->save();
                }
            }
        } else $newStat->status = 1;

        return $newStat->save();
    }

    public function deleteExcursionRecord($idusr,$idexc)
    {
        $newExc = Usertoexcursion::find()->where('idexcursion = ' . $idexc . ' and iduser = ' . $idusr)->one();
        if (!is_null($newExc))
            return $newExc->delete();
        else return false;
    }
    

}
