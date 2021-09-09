<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class CompanyForm extends Model
{
    public $companyname;
    public $companyphoto;
    public $companydescription;
    public $companyrequirements;

    public function getCompanies(){
    	return Company::findAll(['id' => 'IS NOT NULL']);
    }

    public function createCompany($img)
    {
        $image = new Images();
        $newCompany = new Company();
        $newCompany->companyname = $this->companyname;
        $newCompany->companyphoto = $image->uploadImage($img);
        $newCompany->companydescription = $this->companydescription;
        $newCompany->companyrequirements = $this->companyrequirements;
        return $newCompany->save();
    }
}
