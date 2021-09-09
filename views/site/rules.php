<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

$this->title = 'Правила сайта';

$this->params['breadcrumbs'][] = array(
    'label'=> 'Регистрация', 
    'url'=>Url::toRoute('/signup')
);

$this->params['breadcrumbs'][] = array(
    'label'=> 'Правила сайта'
);

?>
<head>
    <link rel="stylesheet" href="<?=Yii::getAlias('@web') . '/css/links.css'?>">
</head>

<body>
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10" align="justify">
			<?= $rules->rules;?>
		</div>
		<div class="col-md-1"></div>
	</div>
</body>