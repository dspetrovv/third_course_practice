<?php

use \yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use vova07\imperavi\Widget;

$newSetts->about = (!is_null($settings)) ? $settings->about : '';

$this->title = "О нас";

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
    	<h1>О нас</h1>
			<?php
                $form = ActiveForm::begin([
                    'id' => 'mainpageform'
                ]);
            ?>

            <div>
                <?=
                    $form->field($newSetts,'about')->widget(Widget::className(),['settings' =>
                        [
                            'lang' => 'ru',
                            'minHeight' => '1000',
                            
                            'plugins' => [
                                'fullscreen',
                                'imagemanager',
                            ],
                            'imageUpload' => Url::to(['/admin/company/image-upload']),
                        ]
                    ])->label('Текст');
                ?>
            </div>

            <div class="form-group">
		        <?= HTML::submitButton('Сохранить', ['class' => 'btn btn-success-my-2','title' => 'Сохранить информацию'])?>
		    </div>

		    <?php
		        ActiveForm::end();
		    ?>
	</div>
</body>