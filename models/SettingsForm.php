<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class SettingsForm extends Model
{
    public $name;
    public $text;
    public $photo;
    public $mapicon;
    public $latcoord;
    public $longcoord;
    public $zoom;
    public $companypagination;
    public $newspagination;
    public $leftfooter;
    public $rightfooter;
    public $rules;
    public $about;

    public function rules(){
        return [
            [['name'],'required','message' => 'Обязательно для заполнения'],
        	['name', 'default', 'value' => 'orp'],
            [['latcoord', 'longcoord'], 'double'],
            [['leftfooter', 'rightfooter'], 'string', 'max' => 50],
            ['latcoord', 'default', 'value' => 61.6688],
            ['longcoord', 'default', 'value' => 50.8365],
            ['zoom', 'number', 'min' => 5, 'max' => 17, 'tooSmall' => 'Приближение не может быть меньше 5', 'tooBig' => 'Приближение не может быть больше 17'],
            ['companypagination', 'number', 'min' => 1, 'tooSmall' => 'Значение не может быть меньше 1'],
            ['newspagination', 'number', 'min' => 1, 'tooSmall' => 'Значение не может быть меньше 1'],
        ];
    }

    public function saveIcon($img,$type)
    {
        $image = new Images();
        if ($type == 'photo')
        	$this->photo = $image->uploadIcon($img);
        else if ($type == 'mapicon')
        	$this->mapicon = $image->uploadIcon($img);
    }

    public function getSettings(){
    	return Sitesettings::find()->all();
    }

    public function editSettings()
    {
        $newSettings = Sitesettings::find()->one();
        $newSettings->name = $this->name;
        $newSettings->text = $this->text;
        $newSettings->photo = $this->photo;
        $newSettings->mapicon = $this->mapicon; 
        $newSettings->latcoord = $this->latcoord;
	    $newSettings->longcoord = $this->longcoord;
	    $newSettings->zoom = $this->zoom;
	    $newSettings->companypagination = $this->companypagination;
	    $newSettings->newspagination = $this->newspagination;
	    $newSettings->leftfooter = $this->leftfooter;
	    $newSettings->rightfooter = $this->rightfooter;

        return $newSettings->save();
    }

    public function editRules()
    {
        $newRules = Sitesettings::find()->one();
        $newRules->rules = $this->rules;

        return $newRules->save();
    }

    public function editAbout()
    {
        $newAbout = Sitesettings::find()->one();
        $newAbout->about = $this->about;

        return $newAbout->save();
    }

}
