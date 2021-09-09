<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = $company->companyname;

$this->params['breadcrumbs'][] = array(
    'label'=> 'Предприятия', 
    'url'=>Url::toRoute('/company')
);

$this->params['breadcrumbs'][] = array(
    'label'=> $company->companyname, 
    'url'=>Url::toRoute('/company/company?id='.$_GET['id'].'')
);
?>

<style type="text/css">
	.delimiter {
  		font-size: 1.4em;
  		font-weight: bold;
  		line-height: 1.5em;
  		border-bottom: 1px solid rgba(34, 36, 38, .15);
	}
</style>
<body>
	<div class="row" style="border-radius: 10px;">
		<div class="col-md-1"></div>
		<div class="col-md-10" align="justify" style="background-color: #ffffff; border-radius: 10px;">
			<h1>
				<?= $company->companyname?>
			</h1>
			<div>
				<?= Html::img('@web/images/'. $company->companyphoto,['width' => '100%']);?>
			</div>
			<div>
				<h3>
					Описание:
				</h3>
				<div style="text-indent: 1.5em;">
					<?= $company->companydescription?>
				</div>
			</div>
			<div class="row">
			<div class="delimiter"></div>
		</div>
			<div>
				<h3>
					Правила и требования:
				</h3>
				<div>
					<?= $company->companyrequirements?>
				</div>
			</div>	
			
		</div>
		<div class="col-md-1"></div>
	</div>
</body>