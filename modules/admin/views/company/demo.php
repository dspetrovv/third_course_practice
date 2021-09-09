<?php
use yii\helpers\Html;
use app\models\Demo;
use \yii\widgets\ActiveForm;
use katzz0\yandexmaps\Canvas as YandexMaps;
use katzz0\yandexmaps\Map;
use katzz0\yandexmaps\objects\Placemark;
use katzz0\yandexmaps\Point;
use app\models\Sitesettings;

$settings = Sitesettings::find()->one();

$this->title = 'Демо предприятия "'.$demo->companyname.'"';

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
		<div class="col-md-10" align="justify" style="border-radius: 10px;">
			<?php if (!$validation): ?>
				<h2 style="color: #ff1100;">
					Внимание! Введённые наименование или описание предприятия уже существуют, данная демо версия не будет сохранена!
				</h2>
			<?php endif; ?>
			<h1>
				<?= $demo->companyname?>
			</h1>
			<div>
				<?= Html::img('@web/images/'. $demo->companyphoto,['width' => '100%']);?>
			</div>
			<div>
				<h3>
					Описание:
				</h3>
				<div style="text-indent: 1.5em;">
					<?= $demo->companydescription?>
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
					<?= $demo->companyrequirements?>
				</div>
			</div>

			<h3>
				Карта:
			</h3>

			<div>
				<?= YandexMaps::widget([
    					'htmlOptions' => [
        					'style' => 'height: 400px;',
    					],
    					'map' => new Map('yandex_map', [
        					'center' => [$demo->latcoord, $demo->longcoord],
        					'zoom' => (!is_null($settings)) ? $settings->zoom : 12,
        					'controls' => [Map::CONTROL_ZOOM],
        					'behaviors' => ['default', 'scrollZoom'],
        					'type' => "yandex#map",
    					],
    					[
        					'objects' => [new Placemark(new Point($demo->latcoord, $demo->longcoord), ['balloonContent' => '<strong>' . $demo->place . '</strong>'], [
            				'draggable' => true,
            				'iconLayout' => 'default#image',
            				'iconImageHref' => Yii::$app->urlManager->createUrl(['/images/icons/'. ((!is_null($settings)) ? $settings->mapicon : 'icon.png')]),
            				'events' => [
                				'dragend' => 'js:function (e) {
                    			console.log(e.get(\'target\').geometry.getCoordinates());
                				}'
            				]
        					])]
    					])
						])
					?>
			</div>

			<div class="delimiter"></div>
			<?php
        		$form = ActiveForm::begin();
    		?>

			<?= $form->field($model, 'companyname')->hiddenInput(['value' => $demo->companyname])->label(false); ?>
			<?= $form->field($model, 'photoname')->hiddenInput(['value' => $demo->companyphoto])->label(false); ?>
			<?= $form->field($model, 'companydescription')->hiddenInput(['value' => $demo->companydescription])->label(false); ?>
			<?= $form->field($model, 'companyrequirements')->hiddenInput(['value' => $demo->companyrequirements])->label(false); ?>
			<?= $form->field($model, 'latcoord')->hiddenInput(['value' => $demo->latcoord])->label(false); ?>
			<?= $form->field($model, 'longcoord')->hiddenInput(['value' => $demo->longcoord])->label(false); ?>
			<?= $form->field($model, 'place')->hiddenInput(['value' => $demo->place])->label(false); ?>
			<?= $form->field($model, 'save')->hiddenInput(['value' => $action == 'new' ? 'new' : 'edit'])->label(false); ?>
			<?php if (!is_null($demo->id)) echo $form->field($model, 'id')->hiddenInput(['value' => $demo->id])->label(false); ?>
			<div class="form-group">
        		<?= HTML::submitButton('Сохранить', ['class' => 'btn btn-success-my-2', 'title' => 'Сохранить представленный вариант'])?>
    		</div>
    		<?php
        		ActiveForm::end();
    		?>
			
			
		</div>
		<div class="col-md-1"></div>
	</div>
</body>