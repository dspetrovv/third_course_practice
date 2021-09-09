<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use \yii\widgets\ActiveForm;
use katzz0\yandexmaps\Canvas as YandexMaps;
use katzz0\yandexmaps\Map;
use katzz0\yandexmaps\objects\Placemark;
use katzz0\yandexmaps\Point;
use app\models\Sitesettings;

$settings = Sitesettings::find()->one();

$this->title = $company->companyname;

$this->params['breadcrumbs'][] = array(
    'label'=> 'Предприятия', 
    'url'=>Url::toRoute('/company')
);

$this->params['breadcrumbs'][] = array(
    'label'=> $company->companyname
);
?>
<head>
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
	<div class="row" style="border-radius: 10px;">
		<div class="col-sm-1"></div>
		<div class="col-lg-10" align="justify">
			<h1>
				<?= $company->companyname?>
			</h1>
			<div align="center">
				<?= Html::img('@web/images/'. $company->companyphoto,['width' => '80%']);?>
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
			<br>
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

			<div class="row">
			<br>
			<div class="delimiter"></div>
		</div>

			<div class="row" align="center">
<?php if (!Yii::$app->user->isGuest) : ?>

	<?php if ($userStatus) : ?>

		<?php if (is_null($isParticipant) || count($isParticipant) == 0): ?>

			<h3>
				На данное предприятие пока нет экскурсий
			</h3>

		<?php else : ?>

			<?php for ($i=0; $i < count($total); $i++): ?>

				<h3 align="justify"><b>
					Экскурсия
					<?=Yii::$app->formatter->asDatetime($newExcursions[$i]->date . Yii::$app->getTimeZone());
	    						?></b>
				</h3>

				<?php if ($newExcursions[$i]->status != 0) : ?>
					<h4>
						<?php if (is_null($uniquepart[$i])): ?>
							
							<p align="justify">
								<b>
								Мест на экскурсию <?= $total[$i]; ?> (занято: <?= $current[$i]; ?>)
								</b>
							</p>

						<?php endif; ?>

						<?php if (!is_null($uniquepart[$i]) && (!is_null($access) && is_null($access[$i]))): ?>
							<div class="myunique">
								Эта экскурсия только для пользователей, ещё не посещавших это предприятие
							</div>

						<?php elseif (!is_null($isParticipant) && $isParticipant[$i]): ?>
							Вы записаны на экскурсию в это предприятие
							
						<?php elseif (!is_null($isParticipant) && !is_null($isActive) && !$isActive[$i]): ?>
							<p align="justify">
								На эту экскурсию больше нет мест
							</p>
						<?php endif; ?>
				
					

						<?php if (!is_null($isParticipant) && !$isParticipant[$i] && is_null($uniquepart[$i])): ?>
							<?php
			        			$form = ActiveForm::begin();
			    			?>

			    			<?= $form->field($participation, 'idexcursion')->hiddenInput(['value' => $i])->label(false); ?>

			    			<div style="padding-top: 10px;">
			    				<?= HTML::submitButton('Записаться', ['class' => 'btn btn-success-my', 'title' => 'Записаться']);
			    				?>
			    			</div>

			    			<?php
			        			ActiveForm::end();
			    			?>
						<?php endif; ?>
					</h4>
				<?php else : ?>
					<h3 style="color: red;">
						Экскурсия отменена!
					</h3>
				<?php endif; ?>

			<?php endfor; ?>

		<?php endif; ?>
	<?php else : ?>
		<h3>Ваш аккаунт заблокирован. Вы не можете просматривать и принимать участие в экскурсиях.</h3>
	<?php endif; ?>

<?php endif; ?>

			</div>
			<div>
				<h3>
					Карта:
				</h3>
				<div>
					<?= YandexMaps::widget([
    					'htmlOptions' => [
        					'style' => 'height: 400px;',
    					],
    					'map' => new Map('yandex_map', [
        					'center' => [$company->latcoord, $company->longcoord],
        					'zoom' => (!is_null($settings)) ? $settings->zoom : 12,
        					'controls' => [Map::CONTROL_ZOOM],
        					'behaviors' => ['default', 'scrollZoom'],
        					'type' => "yandex#map",
    					],
    					[
        					'objects' => [new Placemark(new Point($company->latcoord, $company->longcoord), ['balloonContent' => '<strong>' . $company->place . '</strong>'], [
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
			</div>
		</div>
		<div class="col-sm-1"></div>
	</div>
</body>