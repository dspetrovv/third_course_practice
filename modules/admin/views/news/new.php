<?php
use yii\helpers\Html;
use \yii\widgets\ActiveForm;
use yii\helpers\Url;
use vova07\imperavi\Widget;
use kartik\dialog\Dialog;

$demo = Yii::$app->homeUrl . 'admin/news/demo';

$this->title = "Создать новость";

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

<script type="text/javascript">
    <?=Dialog::widget();?>
    function checksubmit() {
        krajeeDialog.alert(document.forms[0].id);
        return false;
    }
</script>

<body>
<div align="justify">
    <h1>Добавить новость</h1>
    <?php
        $form = ActiveForm::begin([
            'id' => 'newsform'
        ]);
    ?>

    <?=
        $form->field($news,'photo')->fileInput(['id' => 'photid','title' => 'Фотография новости'])->label('Фото');
    ?>

    <div class="frm">
    <?=
        $form->field($news,'name')->textInput(['autofocus' => true,'title' => 'Заголовок новости'])->label('Заголовок');
    ?>
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

    <input type="hidden" name="hide" id="hide" value="">
    <input type="hidden" name="action" id="action" value="new">

    <div class="form-group">
        <?= HTML::button('Добавить новость', ['id' => 'subm1','class' => 'btn btn-success-my-2','title' => 'Добавить новость'])?>
    </div>
    <div class="form-group">
        <?= HTML::button('Демо', ['id' => 'subm2','class' => 'btn btn-info-my','title' => 'Посмотреть демонстраницонный вариант'])?>
    </div>

    <?php
        echo Dialog::widget();

        $js = <<< JS
            $("#subm1").on("click", function() {
                if (document.getElementById("photid").value == "")
                    krajeeDialog.alert("Загрузите фотографию!");
                else {
                    document.getElementById("hide").value = "Save";
                    document.forms["newsform"].action = "new";
                    document.forms["newsform"].submit();
                }
                return false;
            });
            $("#subm2").on("click", function() {
                if (document.getElementById("photid").value == "")
                    krajeeDialog.alert("Загрузите фотографию!");
                else {
                    document.getElementById("hide").value = "Demo";
                    document.forms["newsform"].action = "demo";
                    document.forms["newsform"].submit();
                }
                return false;
            });
        JS;

        $this->registerJs($js);
    ?>

    <?php
        ActiveForm::end();
    ?>

</div>
</body>