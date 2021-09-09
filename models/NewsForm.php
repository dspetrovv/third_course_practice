<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class NewsForm extends Model
{
    public $id;
    public $name;
    public $photo;
    public $txt;

    public function rules(){
        return [
            [['name','txt'],'required','message' => 'Обязательно для заполнения'],
            ['name', 'validateNewsName'],
            ['txt', 'validateNewsText'],
            [['photo'],'file','extensions' => 'jpg,png'],
        ];
    }

    public function getNews(){
    	return News::find()->all();
    }

    public function deleteNews($id){
        return News::findOne(['id' => $id])->delete();
    }

    public function saveImage($img)
    {
        $image = new Images();
        $this->photo = $image->uploadImage($img);
    }

    public function saveFromDemo()
    {
        $newNews = new News();
        $newNews->name = $this->name;
        $newNews->photo = $this->photo;
        $newNews->txt = $this->txt;
        return $newNews->save();
    }

    public function editFromDemo()
    {
        $newNews = News::findOne(['id' => $this->id]);
        $newNews->name = $this->name;
        $newNews->photo = $this->photo;
        $newNews->txt = $this->txt;
        return $newNews->save();
    }

    public function editNews($img,$id)
    {
        $image = new Images();
        $newNews = News::findOne(['id' => $id]);
        $newNews->name = $this->name;
        $newNews->photo = is_null($img) 
        ? $this->photo
        : $image->uploadImage($img);
        $newNews->txt = $this->txt;
        return $newNews->save();
    }

    public function createNews($img)
    {
        $image = new Images();
        $newNews = new News();
        $newNews->name = $this->name;
        $newNews->photo = $this->photo;
        $newNews->txt = $this->txt;
        return $newNews->save();
    }

    public function validateNewsText($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $news = News::findOne(['id' => $this->id]);
            $news1 = News::findOne(['txt' => $this->txt]);
            if (!is_null($news)) {
                if (!is_null($news1)) {
                    if ($news->id != $news1->id && $news1->txt != "") {
                        $this->addError($attribute, 'Такой текст уже существует');
                    }
                }
            } else if (is_null($news) && !is_null($news1)){
                $this->addError($attribute, 'Такой текст уже существует');
            }
        }
    }

    public function validateNewsName($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $news = News::findOne(['id' => $this->id]);
            $news1 = News::findOne(['name' => $this->name]);
            if (!is_null($news)) {
                if (!is_null($news1)) {
                    if ($news->id != $news1->id && $news1->name != "") {
                        $this->addError($attribute, 'Такое название уже существует');
                    }
                }
            } else if (is_null($news) && !is_null($news1)){
                $this->addError($attribute, 'Такое название уже существует');
            }
        }
    }

}
