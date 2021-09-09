<?php
use yii\helpers\Html;
use app\models\Demo;
use \yii\widgets\ActiveForm;
use katzz0\yandexmaps\Canvas as YandexMaps;
use katzz0\yandexmaps\Map;
use katzz0\yandexmaps\objects\Placemark;
use katzz0\yandexmaps\Point;

$this->title = 'Демо новости "'.$demo->name.'"';

?>
<head>
    <link href="<?=Yii::getAlias('@web') . '/css/links.css'?>" rel="stylesheet">
	<style type="text/css">
		.delimiter {
	  		font-size: 1.4em;
	  		font-weight: bold;
	  		line-height: 1.5em;
	  		border-bottom: 1px solid rgba(34, 36, 38, .15);
		}
	</style>
</head>

<body>
	<div class="row" style="background-color: #ffffff; border-radius: 10px;">
		<div class="col-md-1"></div>
		<div class="col-md-10" align="justify" style="background-color: #ffffff; border-radius: 10px;">
			<?php if (!$validation): ?>
				<h2 style="color: #ff1100;">
					Внимание! Введённые наименование или описание предприятия уже существуют, данная демо версия не будет сохранена!
				</h2>
			<?php endif; ?>
			<h1>
				<?= $demo->name?>
			</h1>
			<div>
				<?php if (!is_null($demo->photo)) echo Html::img('@web/images/'. $demo->photo,['width' => '100%']);?>
			</div>
			<div>
				<div style="text-indent: 1.5em;">
					<?= $demo->txt?>
				</div>
			</div>

			<?php
        		$form = ActiveForm::begin();
    		?>

			<?= $form->field($model, 'name')->hiddenInput(['value' => $demo->name])->label(false); ?>
			<?= $form->field($model, 'photos')->hiddenInput(['id' => 'hidphoto','value' => ''])->label(false); ?>
			<?= $form->field($model, 'txt')->hiddenInput(['value' => $demo->txt])->label(false); ?>
			<?= $form->field($model, 'save')->hiddenInput(['value' => $action == 'new' ? 'new' : 'edit'])->label(false); ?>
			<?php if (!is_null($demo->id)) echo $form->field($model, 'id')->hiddenInput(['value' => $demo->id])->label(false); ?>
			<div class="form-group">
        		<?= HTML::submitButton('Сохранить', ['class' => 'btn btn-success-my-2', 'title' => 'Сохранить представленный вариант', 'onclick' => 'document.getElementById("hidphoto").value = "'.$demo->photo.'"'])?>
    		</div>
    		<?php
        		ActiveForm::end();
    		?>
			
			
		</div>
		<div class="col-md-1"></div>
	</div>
</body>