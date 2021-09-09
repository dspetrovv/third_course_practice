<?php
use yii\helpers\Html;
use \yii\widgets\ActiveForm;
use yii\helpers\Url;
use vova07\imperavi\Widget;

$category = array();

$company->companydescription = $companyData->companydescription;
$company->companyrequirements = $companyData->companyrequirements;

$this->title = 'Редактирование предприятия "'.$companyData->companyname.'"';

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
    <h1>Изменить данные предприятия</h1>
    <?php
        $form = ActiveForm::begin(['id' => 'companyform']);
    ?>

    <div class="frm">
    <?=
        $form->field($company,'companyname')->textInput(['autofocus' => true, 'value' => $companyData->companyname, 'id' => 'companyname', 'title' => 'Наименование предприятия'])->label('Наименование предприятия');
    ?>
    </div>

    <div class="row">
        <div class="col-md-4">
            <label for="newsphoto">Текущее фото</label>
            <?= Html::img('@web/images/'. $companyData->companyphoto,['id' => 'newsphoto','height' => '250px', 'alt'=> $companyData->companyphoto]);?>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-4">
            <?=
                $form->field($company,'companyphoto')->fileInput(['title' => 'Фотография предприятия'])->label('Изменить фото');
            ?>
        </div>
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
                        $form->field($company,'latcoord')->textInput(['placeholder' => '61.671404', 'title' => 'Координаты широты', 'value' => $companyData->latcoord])->label('Широта');
                    ?>
                </div>
            </td>
            <td width="50%">
                <div>
                    <?=
                        $form->field($company,'longcoord')->textInput(['placeholder' => '50.833628', 'title' => 'Координаты долготы', 'value' => $companyData->longcoord])->label('Долгота');
                    ?>
                </div>
            </td>
        </tr>
    </table>

    <div class="frm">
    <?=
        $form->field($company,'place')->textInput(['placeholder' => 'ул. "...", д. "№", "Название места"', 'title' => 'Текст, отображаемый при нажатии на метку', 'value' => $companyData->place])->label('Место');
    ?>
    </div>

    <input type="hidden" name="hide" id="hide" value="<?=$companyData->id;?>">
    <input type="hidden" name="action" id="action" value="edit">

    <div class="form-group">
        <?= HTML::submitButton('Сохранить изменения', ['class' => 'btn btn-success-my-2','title' => 'Сохранить изменения'])?>
    </div>
    <div class="form-group">
        <?= HTML::submitButton('Демо', ['class' => 'btn btn-info-my','title' => 'Посмотреть демонстраницонный вариант','onclick' => '
            document.forms["companyform"].action = "demo"'])?>
    </div>

    <?php
        ActiveForm::end();
    ?>

</div>
</body>