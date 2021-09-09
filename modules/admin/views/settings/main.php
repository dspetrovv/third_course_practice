<?php

use app\models\User;
use app\models\Company;
use app\models\Excursions;
use \yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use vova07\imperavi\Widget;

$newSetts->text = (!is_null($settings)) ? $settings->text : '';

$this->title = "Основные настройки";

?>
<head>
    <link href="<?=Yii::getAlias('@web') . '/css/links.css'?>" rel="stylesheet">
    <style type="text/css">
        .frm .form-control {
            width: 30%;
        }
        .formdrop .form-control {
            width: 40%;
        }
        .formdscr .form-control {
            width: 50%;
        }
        .formtxt .form-control {
            width: 70%;
        }
    </style>
</head>

<body>
	<div align="justify">
    	<h1>Настройки сайта</h1>
			<?php
                $form = ActiveForm::begin([
                    'id' => 'mainpageform'
                ]);
            ?>
            <div class="row">
                <div class="col-md-4">
                    <?=
                        $form->field($newSetts,'name')->textInput(['autofocus' => true, 'title' => 'Название сайта', 'value' => (!is_null($settings)) ? $settings->name : 'Сайт'])->label('Название сайта');
                    ?>
                </div>
                <div class="col-md-4" align="right">
                    <?= Html::img('@web/images/icons/'. ((!is_null($settings)) ? $settings->photo : 'logo.png'),['height' => '75px', 'alt' => (!is_null($settings)) ? $settings->name : 'Лого']);?>
                </div>
                <div class="col-md-4">
                    <?=
                        $form->field($newSetts,'photo')->fileInput(['title' => 'Иконка сайта'])->label('Иконка сайта');
                    ?>
                </div>
            </div>

            <div>
                <?=
                    $form->field($newSetts,'text')->widget(Widget::className(),['settings' =>
                        [
                            'lang' => 'ru',
                            'minHeight' => '500',
                            
                            'plugins' => [
                                'fullscreen',
                                'imagemanager',
                            ],
                            'imageUpload' => Url::to(['/admin/company/image-upload']),
                        ]
                    ])->label('Текст на главной странице');
                ?>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?=
                        $form->field($newSetts,'latcoord')->textInput(['title' => 'Координаты широты','value' => (!is_null($settings)) ? $settings->latcoord : 61.6688])->label('Координаты широты');
                    ?>
                </div>
                <div class="col-md-3">
                    <?=
                        $form->field($newSetts,'longcoord')->textInput(['title' => 'Координаты долготы','value' => (!is_null($settings)) ? $settings->longcoord : 50.8365])->label('Координаты долготы');
                    ?>
                </div>
                <div class="col-md-2">
                    <?=
                        $form->field($newSetts,'zoom')->textInput(['title' => 'Приближение карты на главной странице','type' => 'number', 'value' => (!is_null($settings)) ? $settings->zoom : 12])->label('Приближение');
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">
                    <?= Html::img('@web/images/icons/'. ((!is_null($settings)) ? $settings->mapicon : 'icon.png'),['height' => '50px', 'alt' => (!is_null($settings)) ? $settings->name : 'Иконка']);?>
                </div>
                <div class="col-md-3">
                    <?=
                        $form->field($newSetts,'mapicon')->fileInput(['title' => 'Иконка, которая будет отображаться на карте'])->label('Иконка на карте');
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <?=
                        $form->field($newSetts,'companypagination')->textInput(['type' => 'number', 'title' => 'Количество представленных на одной странице предприятий', 'value' => (!is_null($settings)) ? $settings->companypagination : 10])->label('Пагинация предприятий');
                    ?>
                </div>
                <div class="col-md-2">
                    <?=
                        $form->field($newSetts,'newspagination')->textInput(['type' => 'number', 'title' => 'Количество представленных на одной странице новостей', 'value' => (!is_null($settings)) ? $settings->newspagination : 10])->label('Пагинация новостей');
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <?=
                        $form->field($newSetts,'leftfooter')->textInput(['title' => 'Текст, находящийся в левой части футера','value' => (!is_null($settings)) ? $settings->leftfooter : ''])->label('Текст футера слева');
                    ?>
                </div>
                <div class="col-md-5">
                    <?=
                        $form->field($newSetts,'rightfooter')->textInput(['title' => 'Текст, находящийся в правой части футера','value' => (!is_null($settings)) ? $settings->rightfooter : ''])->label('Текст футера справа');
                    ?>
                </div>
            </div>
            <div class="form-group">
		        <?= HTML::submitButton('Сохранить', ['class' => 'btn btn-success-my-2','title' => 'Сохранить настройки'])?>
		    </div>

		    <?php
		        ActiveForm::end();
		    ?>
	</div>
</body>