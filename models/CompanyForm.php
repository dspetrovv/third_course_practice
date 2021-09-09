<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class CompanyForm extends Model
{
    public $id;
    public $companyname;
    public $companyphoto;
    public $photoname;
    public $companydescription;
    public $companyrequirements;
    public $latcoord;
    public $longcoord;
    public $place;

    public function rules(){
        return [
            [['companyname','companydescription','companyrequirements','latcoord','longcoord','place'],'required','message' => 'Обязательно для заполнения'],
            ['companyname', 'validateCompanyName'],
            ['companydescription', 'validateCompanyDesc'],
            [['companyphoto'],'file','extensions' => 'jpg,png'],
        ];
    }

    public function getCompanies(){
    	return Company::find()->all();
    }

    public function getCompanynamesList(){
        $complist = Company::find()->asArray()->all();
        $comps = array();
        foreach ($complist as $company) {
            $comps[$company['companyname']] = $company['companyname'];
        }
        return $comps;
    }

    public function deleteCompany($id){
        return Company::findOne(['id' => $id])->delete();
    }

    public function saveImage($img)
    {
        $image = new Images();
        $this->companyphoto = $image->uploadImage($img);
    }

    public function editFromDemo()
    {
        $newCompany = Company::findOne(['id' => $this->id]);
        $newCompany->companyname = $this->companyname;
        $newCompany->companyphoto = $this->photoname;
        $newCompany->companydescription = $this->companydescription;
        $newCompany->companyrequirements = $this->companyrequirements;
        $newCompany->latcoord = $this->latcoord;
        $newCompany->longcoord = $this->longcoord;
        $newCompany->place = $this->place;
        return $newCompany->save();
    }

    public function saveFromDemo()
    {
        $newCompany = new Company();
        $newCompany->companyname = $this->companyname;
        $newCompany->companyphoto = $this->photoname;
        $newCompany->companydescription = $this->companydescription;
        $newCompany->companyrequirements = $this->companyrequirements;
        $newCompany->latcoord = $this->latcoord;
        $newCompany->longcoord = $this->longcoord;
        $newCompany->place = $this->place;
        return $newCompany->save();
    }

    public function editCompany($img,$id)
    {
        $image = new Images();
        $newCompany = Company::findOne(['id' => $id]);
        $newCompany->companyname = $this->companyname;
        $newCompany->companyphoto = is_null($img) 
        ? $this->companyphoto
        : $image->uploadImage($img);
        $newCompany->companydescription = $this->companydescription;
        $newCompany->companyrequirements = $this->companyrequirements;
        $newCompany->latcoord = $this->latcoord;
        $newCompany->longcoord = $this->longcoord;
        $newCompany->place = $this->place;
        return $newCompany->save();
    }

    public function createCompany($img)
    {
        $image = new Images();
        $newCompany = new Company();
        $newCompany->companyname = $this->companyname;
        $newCompany->companyphoto = $this->companyphoto;
        $newCompany->companydescription = $this->companydescription;
        $newCompany->companyrequirements = $this->companyrequirements;
        $newCompany->latcoord = $this->latcoord;
        $newCompany->longcoord = $this->longcoord;
        $newCompany->place = $this->place;
        //var_dump($newCompany->save());die;
        return $newCompany->save();
    }

    public function validateCompanyDesc($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $company = Company::findOne(['id' => $this->id]);
            $company1 = Company::findOne(['companydescription' => $this->companydescription]);
            if (!is_null($company)) {
                if (!is_null($company1)) {
                    if ($company->id != $company1->id && $company1->companydescription != "") {
                        $this->addError($attribute, 'Такое описание уже существует');
                    }
                }
            } else if (is_null($company) && !is_null($company1)){
                $this->addError($attribute, 'Такое описание уже существует');
            }
        }
    }

    public function validateCompanyName($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $company = Company::findOne(['id' => $this->id]);
            $company1 = Company::findOne(['companyname' => $this->companyname]);
            if (!is_null($company)) {
                if (!is_null($company1)) {
                    if ($company->id != $company1->id && $company1->companyname != "") {
                        $this->addError($attribute, 'Такое название уже существует');
                    }
                }
            } else if (is_null($company) && !is_null($company1)){
                $this->addError($attribute, 'Такое название уже существует');
            }
        }
    }

}
