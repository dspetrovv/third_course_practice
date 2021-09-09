<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

$this->title = $news->name;

$this->params['breadcrumbs'][] = array(
    'label'=> 'Новости', 
    'url'=>Url::toRoute('/news')
);

$this->params['breadcrumbs'][] = array(
    'label'=> $news->name
);

?>

<body>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-lg-10" align="justify" style="border-radius: 10px;">
			<div>
				<?= Html::img('@web/images/'. $news->photo,['width' => '60%']);?>
			</div>
			<h1>
				<?= $news->name?>
			</h1>
				<div style="text-indent: 1.5em;">
					<?= $news->txt?>
				</div>
			<div class="col-sm-1"></div>
		</div>
	</div>
</body>