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
    public $demotxt;

    public function createNews($img)
    {
        $image = new Images();
        $newNews = new News();
        $newNews->name = $this->demoname;
        $newNews->photo = $image->uploadImage($img);
        $newNews->txt = $this->demotxt;
        return $newNews->save();
    }
}
