<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Images extends Model{
	public $image;

	public function rules(){
		return [
			[['image'],'file','extensions' => 'jpg,png']
		];
	}

	public function uploadImage($img){
		$imagename = md5(uniqid($img->baseName)) . '.' . $img->extension;
		$img->saveAs($this->getFolder() . $imagename);
		return $imagename;
	}

	public function uploadIcon($img){
		$imagename = md5(uniqid($img->baseName)) . '.' . $img->extension;
		$img->saveAs(Yii::getAlias('@web') . 'images/icons/' . $imagename);
		return $imagename;
	}

	public function getFolder(){
		return Yii::getAlias('@web') . 'images/';
	}

	public function deleteImage($filename){
		if ($filename != 'defaultuser.jpg' && file_exists($this->getFolder() . $filename)){
			unlink($this->getFolder() . $filename);
			//var_dump($filename);die;
		}
	}

}


?>