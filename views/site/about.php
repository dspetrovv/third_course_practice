<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'О нас';
$this->params['breadcrumbs'][] = $this->title;
?>
<head>
    <link rel="stylesheet" href="<?=Yii::getAlias('@web') . '/css/links.css'?>">
</head>

<body>
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10" align="justify">
			<?=$about->about;?>
		</div>
		<div class="col-md-1"></div>
	</div>
</body>

