<?php

use yii\helpers\Html;
use katzz0\yandexmaps\Canvas as YandexMaps;
use katzz0\yandexmaps\Map;
use katzz0\yandexmaps\objects\Placemark;
use katzz0\yandexmaps\Point;
use app\models\Sitesettings;
/* @var $this yii\web\View */
$settings = Sitesettings::find()->one();

if (!is_null($settings))
	$this->title = $settings->name;

$arr = array();

foreach ($companies as $company) {
	$comp1 = new Placemark(
		new Point($company->latcoord, $company->longcoord), [
			'balloonContent' => '<strong>' . $company->place . '</strong>'
		],
        [
		    'draggable' => true,
		    'iconLayout' => 'default#image',
		    'iconImageHref' => Yii::$app->urlManager->createUrl(['/images/icons/'. ((!is_null($settings)) ? $settings->mapicon : 'icon.png')]),
		    'events' => [
		        'dragend' => 'js:function (e) {
		            console.log(e.get(\'target\').geometry.getCoordinates());
		        }'
		    ]
        ]
    );
    array_push($arr, $comp1);
}

?>

<head>
    <link rel="stylesheet" href="<?=Yii::getAlias('@web') . '/css/links.css'?>">
</head>

<script type="text/javascript">

</script>

<body>
	<div class="row">
		<div class="col-md-12" align="justify">
			<?= (!is_null($settings)) ? $settings->text : '<h1>Главная</h1>'; ?>
		</div>
	</div>
	<div class="row">
	<h3>
		Карта:
	</h3>
		<div class="col-md-12">
			<?= YandexMaps::widget([
    			'htmlOptions' => [
        			'style' => 'height: 450px;',
    			],
    			'map' => new Map('yandex_map', [
        			'center' => [61.668831, 50.836461],
        			'zoom' => (!is_null($settings)) ? $settings->zoom : 12,
        			'controls' => [Map::CONTROL_ZOOM],
        			'behaviors' => ['default', 'scrollZoom'],
        			'type' => "yandex#map",
    			],
    			[
        			'objects' => $arr
    			])
			])
			?>
		</div>
	</div>
</body>