<?php
use yii\helpers\Html;
use \yii\widgets\ActiveForm;
use yii\helpers\Url;
use vova07\imperavi\Widget;
use kartik\dialog\Dialog;

$category = array();

$this->title = "Добавить предприятие";

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
    <h1>Добавить предприятие</h1>
    <?php
        $form = ActiveForm::begin(['id' => 'companyform']);
    ?>

    <?=
        $form->field($company,'companyphoto')->fileInput(['id' => 'photid','title' => 'Фотография предприятия'])->label('Фото');
    ?>

    <div class="frm">
    <?=
        $form->field($company,'companyname')->textInput(['autofocus' => true,'title' => 'Наименование предприятия'])->label('Наименование предприятия');
    ?>
    </div>

    <div>
    <?=
        $form->field($company,'companydescription')->widget(Widget::className(),['settings' => [
            'lang' => 'ru',
            'minHeight' => '200',
            
            'plugins' => [
                'fullscreen',
                'imagemanager',
            ],
            'imageUpload' => Url::to(['/admin/company/image-upload']),
        ]
    ])->label('Описание предприятия');
    ?>
    </div>

    <div>
    <?=
        $form->field($company,'companyrequirements')->widget(Widget::className(),['settings' => [
            'lang' => 'ru',
            'minHeight' => '200',
            
            'plugins' => [
                'fullscreen',
                'imagemanager',
            ],
            'imageUpload' => Url::to(['/admin/company/image-upload']),
        ]
    ])->label('Требования предприятия');
    ?>
    </div> 

    <div><b>Координаты</b></div>

    <table class="table" style="margin-bottom: 0px;">
        <tr>
            <td width="50%" style="padding-left: 0px;">
                <div>
                    <?=
                        $form->field($company,'latcoord')->textInput(['placeholder' => '61.671404','title' => 'Координаты широты'])->label('Широта');
                    ?>
                </div>
            </td>
            <td width="50%">
                <div>
                    <?=
                        $form->field($company,'longcoord')->textInput(['placeholder' => '50.833628','title' => 'Координаты долготы'])->label('Долгота');
                    ?>
                </div>
            </td>
        </tr>
    </table>

    <div class="frm">
    <?=
        $form->field($company,'place')->textInput(['placeholder' => 'ул. "...", д. "№", "Название места"','title' => 'Текст, отображаемый при нажатии на метку'])->label('Место');
    ?>
    </div>

    <input type="hidden" name="hide" id="hide" value="">
    <input type="hidden" name="action" id="action" value="new">

    <div class="form-group">
        <?= HTML::button('Добавить предприятие', ['id' => 'subm1','class' => 'btn btn-success-my-2','title' => 'Добавить предприятие'])?>
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
                    document.forms["companyform"].action = "new";
                    document.forms["companyform"].submit();
                }
                return false;
            });
            $("#subm2").on("click", function() {
                if (document.getElementById("photid").value == "")
                    krajeeDialog.alert("Загрузите фотографию!");
                else {
                    document.getElementById("hide").value = "Demo";
                    document.forms["companyform"].action = "demo"
                    document.forms["companyform"].submit();
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