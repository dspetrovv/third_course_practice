<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class DemoForm extends Model
{
    public $demoname;
    public $demophoto;
    public $demodescription;
    public $demorequirements;
    public $demolatcoord;
    public $demolongcoord;
    public $demoplace;

    public function createDemo($img)
    {
        $image = new Images();
        $newDemo = new Demo();
        $newDemo->demoname = $this->demoname;
        $newDemo->demophoto = $image->uploadImage($img);
        $newDemo->demodescription = $this->demodescription;
        $newDemo->demorequirements = $this->demorequirements;
        $newDemo->demolatcoord = $this->demolatcoord;
    	$newDemo->demolongcoord = $this->demolongcoord;
    	$newDemo->demoplace = $this->demoplace;
        $newDemo->save();
        return Demo::findOne(['demoname' => $this->demoname])->id;
    }

    public function saveCompany()
    {
    	$newCompany = new Company();
        $newCompany->companyname = $this->demoname;
        $newCompany->companyphoto = $this->demophoto;
        $newCompany->companydescription = $this->demodescription;
        $newCompany->companyrequirements = $this->demorequirements;
        $newCompany->latcoord = $this->demolatcoord;
        $newCompany->longcoord = $this->demolongcoord;
        $newCompany->place = $this->demoplace;
        return $newCompany->save();
    }
}
