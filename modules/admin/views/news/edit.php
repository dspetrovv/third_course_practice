<?php
use yii\helpers\Html;
use \yii\widgets\ActiveForm;
use yii\helpers\Url;
use vova07\imperavi\Widget;

$demo = Yii::$app->homeUrl . 'admin/news/demo';
$news->txt = $newsData->txt;

$this->title = 'Редактирование новости "'.$newsData->name.'"';

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
    <h1>Добавить новость</h1>
    <?php
        $form = ActiveForm::begin([
            'id' => 'newsform'
        ]);
    ?>

    <div class="frm">
        <?=
            $form->field($news,'name')->textInput(['autofocus' => true, 'value' => $newsData->name])->label('Заголовок');
        ?>
    </div>

    <div class="row">
        <div class="col-md-4">
            <label for="newsphoto">Текущее фото</label>
            <?= Html::img('@web/images/'. $newsData->photo,['id' => 'newsphoto','height' => '250px', 'alt'=> $newsData->photo]);?>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-4">
            <?=
                $form->field($news,'photo')->fileInput(['title' => 'Фотография новости'])->label('Изменить фото');
            ?>
        </div>
    </div>   

    <div>
    <?=
        $form->field($news,'txt')->widget(Widget::className(),['settings' => [
            'lang' => 'ru',
            'minHeight' => '500',
            
            'plugins' => [
                'fullscreen',
                'imagemanager',
            ],
            'imageUpload' => Url::to(['/admin/company/image-upload']),
        ]
    ])->label('Текст новости');
    ?>
    </div>

    <input type="hidden" name="hide" id="hide" value="<?=$newsData->id;?>">
    <input type="hidden" name="action" id="action" value="edit">
    <div class="form-group">
        <?= HTML::submitButton('Сохранить изменения', ['class' => 'btn btn-success-my-2','title' => 'Сохранить изменения'])?>
    </div>
    <div class="form-group">
        <?= HTML::submitButton('Демо', ['class' => 'btn btn-info-my','title' => 'Посмотреть демонстраницонный вариант','onclick' => '
            document.forms["newsform"].action = "demo";'])?>
    </div>

    <?php
        ActiveForm::end();
    ?>

</div>
</body>